<?php

namespace App\Support;

class GoogleMapsUrl
{
    public static function embedUrl(?string $url): ?string
    {
        $parts = self::parseGoogleMapsUrl($url);

        if ($parts === null) {
            return null;
        }

        parse_str($parts['query'] ?? '', $params);
        $search = $params['q'] ?? $params['query'] ?? $params['text'] ?? null;

        if (preg_match('/!3d(-?\d+(?:\.\d+)?)!4d(-?\d+(?:\.\d+)?)/', $parts['path'] ?? '', $coordinates)
            || preg_match('/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/', $parts['path'] ?? '', $coordinates)) {
            $search = $coordinates[1].','.$coordinates[2];
        } elseif (! $search && preg_match('~(?:^|/)maps/place/([^/?]+)~', $parts['path'] ?? '', $place)) {
            $search = str_replace('+', ' ', rawurldecode($place[1]));
        }

        if (! is_string($search) || trim($search) === '') {
            return null;
        }

        return 'https://www.google.com/maps?q='.urlencode($search).'&output=embed';
    }

    public static function isGoogleMapsUrl(?string $url): bool
    {
        return self::parseGoogleMapsUrl($url) !== null;
    }

    private static function parseGoogleMapsUrl(?string $url): ?array
    {
        if (! is_string($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $parts = parse_url($url);
        $scheme = strtolower($parts['scheme'] ?? '');
        $host = strtolower($parts['host'] ?? '');

        if (! in_array($scheme, ['http', 'https'], true)) {
            return null;
        }

        $isGoogleMapsHost = $host === 'maps.app.goo.gl'
            || $host === 'goo.gl'
            || preg_match('/(^|\.)google\.(?:com(?:\.[a-z]{2})?|[a-z]{2}(?:\.[a-z]{2})?)$/', $host) === 1;

        return $isGoogleMapsHost ? $parts : null;
    }
}

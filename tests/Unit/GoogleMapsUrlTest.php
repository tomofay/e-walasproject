<?php

namespace Tests\Unit;

use App\Support\GoogleMapsUrl;
use PHPUnit\Framework\TestCase;

class GoogleMapsUrlTest extends TestCase
{
    public function test_it_creates_an_embed_url_from_a_google_maps_search_link(): void
    {
        $this->assertSame(
            'https://www.google.com/maps?q=Bogor&output=embed',
            GoogleMapsUrl::embedUrl('https://maps.google.com/?q=Bogor')
        );
    }

    public function test_it_uses_coordinates_from_a_google_maps_place_link(): void
    {
        $this->assertSame(
            'https://www.google.com/maps?q=-6.4955734%2C106.7892957&output=embed',
            GoogleMapsUrl::embedUrl('https://www.google.com/maps/place/Warung+subuh/@-6.4955734,106.7867208,17z/data!3d-6.4955734!4d106.7892957')
        );
    }

    public function test_it_does_not_embed_a_short_google_maps_link(): void
    {
        $url = 'https://maps.app.goo.gl/B9vHGrz11uRBcDcv9';

        $this->assertNull(GoogleMapsUrl::embedUrl($url));
        $this->assertTrue(GoogleMapsUrl::isGoogleMapsUrl($url));
    }

    public function test_it_rejects_non_google_urls(): void
    {
        $url = 'https://example.com/maps?q=Somewhere';

        $this->assertNull(GoogleMapsUrl::embedUrl($url));
        $this->assertFalse(GoogleMapsUrl::isGoogleMapsUrl($url));
    }
}

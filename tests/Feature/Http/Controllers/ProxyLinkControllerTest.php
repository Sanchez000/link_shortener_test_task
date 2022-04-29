<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProxyLinkControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
        $this->artisan('db:seed');
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:reset');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShortLinkRedirectToOriginalLink()
    {
        $link = Link::factory()->create();

        $response = $this->get('/'.$link->short_code);

        $response->assertRedirect($link->original_url);
    }

    public function testExpiredLinkNotRedirecting()
    {
        $link = Link::factory()->withExpiredDate()->create();

        $response = $this->get('/'.$link->short_code);

        $response->assertStatus(404);
    }

    public function testClicksLimitWork()
    {
        $link = Link::factory()->create(
            ['clicks_limit' => 1]
        );

        $response = $this->get('/'.$link->short_code);

        $link = $link->fresh();
        //it increment clicks
        $this->assertEquals($link->clicks, 1);
        $response->assertRedirect($link->original_url);
        // and if limit exceeded - return 404
        $response = $this->get('/'.$link->short_code);
        $response->assertStatus(404);
    }

    public function testItCanRedirectManyTimesIfClicksLimitZero()
    {
        //TODO refactor this
        $link = Link::factory()->withClicksUnlimit()->create();

        $response = $this->get('/'.$link->short_code);

        $response->assertRedirect($link->original_url);

        $link = $link->fresh();

        $this->assertEquals($link->clicks, 1);

        $response = $this->get('/'.$link->short_code);

        $response->assertRedirect($link->original_url);

        $link = $link->fresh();

        $this->assertEquals($link->clicks, 2);

        $response = $this->get('/'.$link->short_code);

        $response->assertRedirect($link->original_url);
    }
}

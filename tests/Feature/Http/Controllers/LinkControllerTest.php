<?php

namespace Tests\Feature\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
        $this->artisan('db:seed');

        $this->requestBody = [
            'clicks_limit' => 0,
            'expired_at' => Carbon::now()->add(1,'hours')->toDateTimeString(),
            'original_url' => 'https://blabla.com',
        ];
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
    public function testHomePageIsAvailable()
    {
        $response = $this->get('/');
        $response->assertViewIs('links.create')
        ->assertSeeText('Short links creator')
        ->assertSeeText('Link')
        ->assertSeeText('Clicks limit')
        ->assertSeeText('Time to live')
        ->assertStatus(200);
    }

    public function testDontStoreLinkWithoutParams()
    {
        $this->requestBody = [];

        $response = $this->post('/links', $this->requestBody);

        $response->assertStatus(302)
        ->assertSessionHasErrors(['clicks_limit', 'expired_at','original_url']);
    }

    public function testDontStoreLinkWithWrongClicksLimit()
    {
        $this->requestBody['clicks_limit'] = -1;

        $response = $this->post('/links', $this->requestBody);

        $response->assertStatus(302)
        ->assertSessionHasErrors(['clicks_limit']);
    }

    public function testDontStoreLinkWithWrongUrl()
    {
        $this->requestBody['original_url'] = 'test simple text';

        $response = $this->post('/links', $this->requestBody);

        $response->assertStatus(302)
        ->assertSessionHasErrors(['original_url']);
    }


    public function testDontStoreLinkWithDateGreaterThanOneDay()
    {
        $this->requestBody['expired_at'] = Carbon::now()->add(36,'hours')->toDateTimeString();

        $response = $this->post('/links', $this->requestBody);

        $response->assertStatus(302)
        ->assertSessionHasErrors(['expired_at']);
    }

    public function testItCanStoreLinkWithRigthParams()
    {
        $response = $this->post('/links', $this->requestBody);

        $this->assertDatabaseHas('links', [
            'original_url' =>  $this->requestBody['original_url'],
        ]);

        $response->assertStatus(302)
        ->assertLocation('links/1')
        ->assertSessionDoesntHaveErrors();
    }

    public function testShowActionIsAvailable()
    {
        $this->post('/links', $this->requestBody);
        
        $response = $this->get('links/1');

        $content = $response->getContent();

        $this->assertMatchesRegularExpression('/http:\/\/localhost\/(.*){'.
                                config('services.code.length').'}/', $content);

        $response->assertViewIs('links.show')
        ->assertViewHas('link')
        ->assertStatus(200);
    }
}

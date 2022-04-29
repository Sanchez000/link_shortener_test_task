<?php

namespace Tests\Unit\Services;

use App\Http\Requests\CreateLinkRequest;
use App\Models\Link;
use App\Services\ShortLinkCreator;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class ShortLinkCreatorTest extends TestCase
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
     * A basic unit test example.
     *
     * @return void
     */
    public function testItCanCreateNewLink()
    {
        /** 
         * @var \App\Http\Requests\CreateLinkRequest
         * */
        $mockedRequest = $this->mock(CreateLinkRequest::class, function ($mock) {
            $mock->shouldReceive('passes')->andReturn(true);
            $mock->shouldReceive('get')->with('original_url')->andReturn($this->requestBody['original_url']);
            $mock->shouldReceive('get')->with('clicks_limit')->andReturn($this->requestBody['clicks_limit']);
            $mock->shouldReceive('get')->with('expired_at')->andReturn($this->requestBody['expired_at']);
            
         });

         $creator = new ShortLinkCreator();
         $mustBeALink = $creator->createNewLink($mockedRequest);
         $this->assertTrue($mustBeALink instanceof Link);
         $this->assertMatchesRegularExpression('/(.*){'.config('services.code.length').'}/',
                                              $mustBeALink->short_code);
         $this->assertDatabaseHas('links', $this->requestBody);
    }

    public function testItCanThrowAnExceptionIfOriginalNotProvided()
    {
        $this->requestBody['original_url'] = null;
        /** 
         * @var \App\Http\Requests\CreateLinkRequest
         * */
        $mockedRequest = $this->mock(CreateLinkRequest::class, function ($mock) {
            $mock->shouldReceive('passes')->andReturn(true);
            $mock->shouldReceive('get')->with('original_url')->andReturn($this->requestBody['original_url']);
            $mock->shouldReceive('get')->with('clicks_limit')->andReturn($this->requestBody['clicks_limit']);
            $mock->shouldReceive('get')->with('expired_at')->andReturn($this->requestBody['expired_at']);
            
         });

         $this->expectException(QueryException::class);

         $creator = new ShortLinkCreator();
         $creator->createNewLink($mockedRequest);
    }
}

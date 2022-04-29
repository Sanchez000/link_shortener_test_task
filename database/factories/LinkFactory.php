<?php

namespace Database\Factories;

use Carbon\Carbon;
use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                'clicks_limit' => 2,
                'clicks' => 0,
                'expired_at' => Carbon::now()->add(1,'hours')->toDateTimeString(),
                'original_url' => 'https://blabla.com',
                'short_code' => (new Client())->generateId(config('services.code.length'),
                                                           Client::MODE_DYNAMIC),
            ];
    }

    /**
     * Indicate that the link with unlimited cliks.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withClicksUnlimit()
    {
        return $this->state(function (array $attributes) {
            return [
                'clicks_limit' => 0,
            ];
        });
    }

    public function withExpiredDate()
    {
        return $this->state(function (array $attributes) {
            return [
                'expired_at' => Carbon::now()->sub('hour', 3)->toDateTimeString(),
            ];
        });
    }
}

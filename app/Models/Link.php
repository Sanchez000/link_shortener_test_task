<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
     * @property int id
     * @property string short_code
     * @property string original_url
     * @property int clicks_limit
     * @property int clicks
     * @property Carbon expired_at
     * @property Carbon created_at
     * @property Carbon updated_at
 */

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_code', 'original_url', 'clicks_limit', 'clicks', 'expired_at'
    ];

    public function scopeGetActiveByShortCode($query, $shortCode)
    {
        return $query->where([
                                ['short_code', '=', $shortCode],
                                ['expired_at', '>', Carbon::now()->toDateTimeString()],
                            ]);
    }
}

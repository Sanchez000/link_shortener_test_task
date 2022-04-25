<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class CreateLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'original_url' => 'required|active_url|max:400',
            'clicks_limit' => 'required|integer|min:0',
            'expired_at' => "required|date|date_format:Y-m-d H:i:s|before:". 
                                                Carbon::now()->add(24,'hours')
        ];
    }
}

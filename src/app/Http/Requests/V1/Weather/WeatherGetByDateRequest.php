<?php

namespace App\Http\Requests\V1\Weather;

use Illuminate\Foundation\Http\FormRequest;

class WeatherGetByDateRequest extends FormRequest
{
    public function rules(): array {
        return [
            'date' => ['required', 'date'],
        ];
    }
}

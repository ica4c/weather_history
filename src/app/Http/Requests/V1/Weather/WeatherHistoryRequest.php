<?php


namespace App\Http\Requests\V1\Weather;


use Illuminate\Foundation\Http\FormRequest;

class WeatherHistoryRequest extends FormRequest
{
    public function rules(): array {
        return [
            'lastDays' => ['required', 'int', 'min:1', 'max:31'],
        ];
    }
}

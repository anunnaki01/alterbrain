<?php

namespace App\Http\Requests\Activities;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class FilterActivitiesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => [ 'required', 'date', 'date_format:Y-m-d', 'after:' . Carbon::yesterday()->format('Y-m-d'),],
            'number_people' => ['required', 'integer', 'min:1'],
        ];
    }
}

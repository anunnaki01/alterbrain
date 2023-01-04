<?php

namespace App\Http\Requests\Booking;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
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
            'activity_id' => ['required', 'exists:activities,id'],
            'number_people' => ['integer', 'required', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'activity_date' => ['required', 'after:' . Carbon::yesterday()->format('Y-m-d')],
        ];
    }
}

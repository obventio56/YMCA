<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationSlot extends FormRequest
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
        'title' => 'required',
        'primary_email' => 'required|email',
        'time_interval' => 'required|numeric',
        'max_time' => 'required|numeric',
        'reservation_window' => 'required|numeric',
        'hours_of_operation.sunday.open' => 'required|date_format:h:i A|before_or_equal:hours_of_operation.sunday.close',
        'hours_of_operation.sunday.close' => 'required|date_format:h:i A',
        'hours_of_operation.monday.open' => 'required|date_format:h:i A|before_or_equal:hours_of_operation.monday.close',
        'hours_of_operation.monday.close' => 'required|date_format:h:i A',
        'hours_of_operation.tuesday.open' => 'required|date_format:h:i A|before_or_equal:hours_of_operation.tuesday.close',
        'hours_of_operation.tuesday.close' => 'required|date_format:h:i A',
        'hours_of_operation.wednesday.open' => 'required|date_format:h:i A|before_or_equal:hours_of_operation.wednesday.close',
        'hours_of_operation.wednesday.close' => 'required|date_format:h:i A',
        'hours_of_operation.thursday.open' => 'required|date_format:h:i A|before_or_equal:hours_of_operation.thursday.close',
        'hours_of_operation.thursday.close' => 'required|date_format:h:i A',
        'hours_of_operation.friday.open' => 'required|date_format:h:i A|before_or_equal:hours_of_operation.friday.close',
        'hours_of_operation.friday.close' => 'required|date_format:h:i A',
        'hours_of_operation.saturday.open' => 'required|date_format:h:i A|before_or_equal:hours_of_operation.saturday.close',
        'hours_of_operation.saturday.close' => 'required|date_format:h:i A'
      ];
    }
}

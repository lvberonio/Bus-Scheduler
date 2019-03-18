<?php namespace App\Http\Requests;

class ScheduleRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'station'           => 'required',
            'bus'               => 'required',
            'day'               => 'required',
            'status'            => 'required',
            'arrival_time'      => 'required',
            'departure_time'    => 'required|greater_than_field:arrival_time'
        ];
    }

}
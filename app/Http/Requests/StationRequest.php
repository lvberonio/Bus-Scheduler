<?php namespace App\Http\Requests;

class StationRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required',
            'location'  => 'required',
            'latitude'  => 'required',
            'longitude' => 'required'
        ];
    }

}
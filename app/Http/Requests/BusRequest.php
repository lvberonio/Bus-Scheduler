<?php namespace App\Http\Requests;

class BusRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'route_no'      => 'required',
            'description'   => 'required',
            'status'        => 'required'
        ];
    }

}
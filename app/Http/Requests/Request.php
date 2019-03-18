<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

	public function authorize()
	{
		// Honeypot
        //var_dump($this->input('address'));
		return  $this->input('address') == '';
	}

}

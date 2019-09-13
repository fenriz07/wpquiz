<?php namespace App\Http\Requests;

class TestRequest extends BaseRequest
{

    protected $rules = [
        'action'               => 'required',
        'email'                => 'required|valid_email',
        'idtest'               => 'required|numeric',
        'name-test'            => 'required|alpha_space',
        'test'                 => 'required'
    ];




}

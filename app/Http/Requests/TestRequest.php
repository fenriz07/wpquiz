<?php namespace App\Http\Requests;

class TestRequest extends BaseRequest
{

    protected $rules = [
        'action'               => 'required',
        'email'                => 'required|valid_email',
        'id_category'          => 'required|numeric',
        'lastname'             => 'required|alpha|max_len,25',
        'name-level'           => 'required|alpha_space',
        'name-test'            => 'required|alpha_space',
        'phone'                => 'required|numeric',
        'test'                 => 'required'
    ];




}

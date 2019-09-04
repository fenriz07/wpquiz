<?php namespace App\Http\Requests;

class ContactRequest extends BaseRequest
{

    protected $rules = [
        'action'               => 'required',
        'lastname'             => 'required|alpha_numeric|max_len,25',
        'name-test'            => 'required|max_len,25',
        'phone'                => 'required|max_len,25',
        'email'                => 'required|valid_email',
        'a'                    => 'required',
    ];




}

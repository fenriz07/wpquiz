<?php namespace App\Http\Controllers\Api;

use App\Http\Requests\ContactRequest;
use App\Http\Controllers\BaseController;

/**
 *
 */

class ContactController extends BaseController
{

  function __construct(){}

  public static function store($request)
  {
    $r =  json_decode( $request->get_body(), true );

    $request = ( new ContactRequest( $r  ) )->getRequest();

    if( is_wp_error( $request ) )
    {
        return $request;
      
    }

    $data = [
      'personal' => [
        'lastname'  => $request->lastname,
        'email'     => $request->email,
        'phone'     => $request->phone,
        'name-test' => $request->{'name-test'},
      ]
    ];


    self::sendMail( $data );
    //Enviar email
    $messages['status'] = 1;
    return $messages;
    
  }

  private static function sendMail($data)
  {

    $templates = (object) [
      'data_email'    => ['{fullname}','{email}','{phone}','{name-test}'],
      'email'         => file_get_contents(LEVEL_PLACEMENT_DIR .'partials/contact-email.html'),
    ];

    $email_html = '';

    $data_email = $data['personal'];

    $email_html = str_replace($templates->data_email,$data_email,$templates->email);

    $headers    = [ 'Content-Type: text/html; charset=UTF-8' ];
    $subject    = 'Contact Test';
    $to_owner   = get_option('admin_email');
    wp_mail($to_owner, $subject, $email_html, $headers);

  }


}

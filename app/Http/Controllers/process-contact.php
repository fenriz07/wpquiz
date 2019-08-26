<?php


/**
 *
 */
class ProcessContact
{

  function __construct(){}

  public function processingPost($data)
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

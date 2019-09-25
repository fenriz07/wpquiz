<?php namespace App\Mails;

use App\Helpers\View;

class Mail
{
    public static function send($template,$content,$to,$subject)
    {
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $body = View::make($template,$content);

        wp_mail( $to, $subject, $body, $headers);
    }
}
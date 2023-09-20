<?php
add_action('sendMail', 'sendMail', 10, 4);
function sendMail($mail, $subject, $message)
{
    $subject = $subject;
    $message = $message;

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
    );

    wp_mail($mail, $subject, $message, $headers);
}

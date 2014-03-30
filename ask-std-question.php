<?php

$name = $_POST['name'];
$email = $_POST['email'];
$order = $_POST['order'];
$question = $_POST['question'];

$to = 'help@getstdtested.com';
$subject = '[getSTDtested.com] Inquiry from Contact page';
$headers = 'From: info@getstdtested.com';

if ($name != '') $message = 'Name: '.$name.'

';
if ($email != '') $message .= 'Email: '.$email.'

';
if ($order != '') $message .= 'Order ID: '.$order.'

';
if ($question != '') $message .= 'Question: '.$question.'




';

mail($to, $subject, $message, $headers) or die('Error sending Mail');

?>
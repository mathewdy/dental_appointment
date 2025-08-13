<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Manila');

include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/connection/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/styles.php');
echo '
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="'. BASE_PATH .'/assets/img/logo.png" type="image/x-icon">
    <title>'. APP_NAME .'</title>
  </head>
  <body>
';

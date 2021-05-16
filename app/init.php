<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL);
$app = __DIR__;

require_once "{$app}/classes/ErrorHandler.php";
require_once "{$app}/classes/Database.php";
require_once "{$app}/classes/Validator.php";
require_once "{$app}/classes/Auth.php";
require_once "{$app}/classes/Hash.php";
require_once "{$app}/classes/TokenHandler.php";
require_once "{$app}/classes/UserHelper.php";
require_once "{$app}/classes/MailConfigHelper.php";

$database = new Database();
$errorHandler = new ErrorHandler();
$validator = new Validator($database, $errorHandler);
$userHelper = new UserHelper($database);
$tokenHandler = new TokenHandler($database);
$auth = new Auth($database, $userHelper, $tokenHandler);
$mail = MailConfigHelper::getMailer();

$auth->build();
$tokenHandler->build();

?>
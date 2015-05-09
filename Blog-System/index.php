<?php

require_once('includes/config.php');
require_once('application.php');

session_start();
session_set_cookie_params(3600, '/');

$app = Application::getInstance();
$app->start();

function __autoload($className) {
    if (file_exists("controllers/$className.php")) {
        include "controllers/$className.php";
    } else if (file_exists("models/$className.php")) {
        include "models/$className.php";
    }
}

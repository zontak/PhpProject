<?php

abstract class BaseModel {
    public function __construct() {
        require_once 'libs/rb.php';
        if (!R::testConnection()) {
            R::setup('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        }
    }
}

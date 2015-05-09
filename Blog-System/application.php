<?php

class Application {
    private static $instance;

    private function __construct() {}

    public function start() {
        $router = new FrontController();
        $router->parse();
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Application();
        }

        return self::$instance;
    }
}

<?php

class FrontController {
    public function parse() {
        $requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $controllerName = DEFAULT_CONTROLLER;
        $actionName = DEFAULT_ACTION;
        $params = [];

        if (count($requestParts) >= 2 && $requestParts[1]) {
            $controllerName = strtolower($requestParts[1]);
            if (preg_match('/\\W/', $controllerName)) {
                die('Invalid controller name.');
            }
        }

        if (count($requestParts) >= 3 && $requestParts[2]) {
            $actionName = $requestParts[2];
            if (preg_match('/\\W/', $actionName)) {
                die('Invalid action name.');
            }
        }

        if (count($requestParts) >= 4) {
            $params = array_splice($requestParts, 3);
        }

        $controllerClassName = ucfirst($controllerName) . 'Controller';
        if (class_exists($controllerClassName)) {
            $controller = new $controllerClassName($controllerName, $actionName);
            if (method_exists($controller, $actionName)) {
                call_user_func_array(array($controller, $actionName), $params);
                $controller->renderView();
            } else {
                die('Error: cannot find action "' . $actionName . '" in controller ' . $controllerClassName);
            }
        } else {
            $controllerFileName = 'controllers/' . $controllerClassName . '.php';
            die ('Error: cannot find controller: ' . $controllerFileName);
        }
    }
}

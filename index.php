<?php
require __DIR__ . '/ApplicationController.php';

try {
    $controller = new ApplicationController();
    echo $controller->start();
}
catch (Exception $error) {
    http_response_code(500);
    var_dump($error);
}

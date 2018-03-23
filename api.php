<?php

require_once 'vendor/autoload.php';

$controller = new \Lib\FrontController();

$controller
    ->setAction($_GET['action'] ?? null)
    ->setToken($_GET['token'] ?? null)
    ->run()
;

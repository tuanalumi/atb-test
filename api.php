<?php

$action = $_GET['action'];

if ($action === 'get_token') {
    // authenticate with username/password

}

$token = $_GET['token'];

if (empty($token)) {
    // return 403
}


<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');


// Include action.php file
// include_once 'db.php';
require_once __DIR__."/Shared/utils.php";
// Create object of Users class
// $user = new Database();
$util = new Util();
// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['id'] ?? '');

if ($api == 'GET') {
    echo $util->getAllProducts();
}

if ($api == 'POST') {
    $data = json_encode($_POST);
    echo $util->addProduct($data);
}

if ($api == 'DELETE') {
    $data = json_encode($_POST);
    echo $data;
}
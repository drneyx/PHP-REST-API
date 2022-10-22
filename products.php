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


function parseInput()
{
    $data = file_get_contents("php://input");

    if($data == false)
        return array();

    parse_str($data, $result);

    return $result;
}

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
    $body = file_get_contents("php://input");
    $_DELETE = parseInput();
    // echo print_r($_DELETE, true);
    // $data = json_encode($_DELETE);
    print_r($body);
    // echo $util->massDeleteProducts($_DELETE);
}
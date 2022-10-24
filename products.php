<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
header('Content-Type: application/json');

require_once __DIR__."/Shared/utils.php";

$util = new Util();
$api = $_SERVER['REQUEST_METHOD'];


function parseInput()
{
    $data = file_get_contents("php://input");
    if($data == false)
        return array();
    parse_str($data, $result);
    return $result;
}

if ($api == 'GET') {
    echo $util->getAllProducts();
}

if ($api == 'POST') {
    $body = file_get_contents("php://input");
    echo $util->addProduct($body);
}

if ($api == 'DELETE') {
    $body = file_get_contents("php://input");
    $_DELETE = parseInput();
    // echo print_r($_DELETE, true);
    // $data = json_encode($_DELETE);
    print_r($body);
    // echo $util->massDeleteProducts($_DELETE);
}
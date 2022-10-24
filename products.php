<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
header('Content-Type: application/json');

require_once __DIR__."/Shared/utils.php";

$util = new Util();
$api_method = $_SERVER['REQUEST_METHOD'];

if ($api_method == 'GET') {
    echo $util->getAllProducts();
}

if ($api_method == 'POST') {
    $body = file_get_contents("php://input");
    echo $util->addProduct($body);
}

if ($api_method == 'DELETE') {
    $body = file_get_contents("php://input");
    echo $util -> massDeleteProducts($body);
}
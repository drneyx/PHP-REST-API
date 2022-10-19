<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');


// Include action.php file
// include_once 'db.php';
require_once __DIR__."/utils.php";
// Create object of Users class
// $user = new Database();
$util = new Util();
// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['id'] ?? '');

if ($api == 'GET') {
    return $this->util->getAllProducts();
}


if ($api == 'POST') {
	$name = $user->test_input($_POST['name']);
	$email = $user->test_input($_POST['email']);
	$phone = $user->test_input($_POST['phone']);

	if ($user->insert($name, $email, $phone)) {
		echo $user->message('User added successfully!',false);
	} else {
		echo $user->message('Failed to add an user!',true);
	}
}



if ($api == 'PUT') {
	parse_str(file_get_contents('php://input'), $post_input);

	$name = $user->test_input($post_input['name']);
	$email = $user->test_input($post_input['email']);
	$phone = $user->test_input($post_input['phone']);

	if ($id != null) {
		if ($user->update($name, $email, $phone, $id)) {
			echo $user->message('User updated successfully!',false);
		} else {
			echo $user->message('Failed to update an user!',true);
		}
	} else {
		echo $user->message('User not found!',true);
	}
}


if ($api == 'DELETE') {
	if ($id != null) {
		if ($user->delete($id)) {
			echo $user->message('User deleted successfully!', false);
		} else {
			echo $user->message('Failed to delete an user!', true);
		}
	} else {
		echo $user->message('User not found!', true);
	}
}
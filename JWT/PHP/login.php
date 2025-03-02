<?php
session_start();

require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;
include 'check_jwt.php';

$jwt = checkJWT();
if($jwt === True){
	echo "OK";
	exit();
}
$secret_key = "secret";
$data = json_decode(file_get_contents("php://input"));
$user = $data->user;
$pass = $data->pass;
if($_SERVER["REQUEST_METHOD"] === "POST"){
	if(isset($user) && isset($pass)){
		if($user == 'admin'){
			echo "admin not authorization";
			exit();
		}
		$expiration_time = time() + 3600;
		$payload = [
			'exp'=>$expiration_time,
			'user'=>$user,
		];
		$jwt = JWT::encode($payload,$secret_key,'HS256');
		$_SESSION['jwt'] = $jwt;
		echo json_encode(["jwt"=>$jwt]);
	}
}else{
	header("Location: login.html");
}
?>
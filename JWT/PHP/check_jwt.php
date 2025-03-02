<?php
session_start();

function checkJWT(){
	if(isset($_SESSION['jwt'])){
		return True;
	}
}
?>
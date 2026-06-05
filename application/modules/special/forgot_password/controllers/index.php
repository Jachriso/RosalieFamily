<?php
require_once 'ForgotPasswordController.php';
if($starter->extranet){
	$this->forgotPassword = new ForgotPassword();
}
else{
	$login = (object) array();
	$login->forgotPassword = new ForgotPassword();
}
?>
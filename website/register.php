<?php


require_once( 'classes/Database.php' );
require_once( 'classes/UserModel.php' );

echo $_POST['address'];


    
UserModel::registerUser($_POST['username'], $_POST['title'],$_POST['firstname'],$_POST['lastname'], $_POST['address'], 
	$_POST['city'], $_POST['zipcode'], $_POST['email'], $_POST['phone'], $_POST['user_password']);
echo "<br/> Congratulations ! you are now registered as a user.";


?>
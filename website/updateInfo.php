<?php

session_start();

require_once( 'functions/authorizations.php' );
require_once( 'classes/Database.php' );

if(SessionLogin::isLoggedIn())
{

  echo "you are logged in as ".SessionLogin::getUsername();

  
}

else {

echo "you are not logged in. Please log in <a href='login.php'>here</a>";

die();

}




function updateAccount() 
{


$db = Database::getConnection();



$request = $db->prepare("UPDATE Person SET Title  = :Title,
   FirstName = :FirstName, 
   LastName = :LastName, 
   Address = :Address, 
   Postcode = :Postcode, 
   City = :City, 
   Telephone = :Telephone, 
   Email = :Email,
   WHERE UserId = :UserId;");


$request->execute(array(':Title'=> $_POST['title'], 
            ':FirstName'=>$_POST['first_name'],
            ':LastName' => $_POST['last_name'],
            ':Address' => $_POST['address'],  
            ':Postcode' => $_POST['postcode'],  
            ':City' => $_POST['city'],
            ':Telephone' => $_POST['telephone'],
            ':Email'=> $_POST['email'],
            ':UserId'=> SessionLogin::getUsername()  
          ));

echo "Details saved !";

if (isset($_POST['new_password'])) {
	# code...

$password = $_POST['new_password'];
$hashedPassword = hash('sha512',$password);

echo "hashed password: ".$hashedPassword;

$updatePassword = $db->prepare("UPDATE User SET Password = :Password WHERE UserId = ?");
$updatePassword ->execute(array(':Password'=>$hashedPassword, SessionLogin::getUsername()));

echo "Password Changed Successfulluy !";

}

else
{

}


}

updateAccount();
?>
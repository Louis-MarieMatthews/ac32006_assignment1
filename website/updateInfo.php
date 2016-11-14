<?php


session_start();

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/functions/authorizations.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/Database.php' );

if(SessionLogin::isLoggedIn())
{

	echo "you are logged in as ".SessionLogin::getUsername();

	
}

else {

echo "you are not logged in. Please log in <a href='login.php'>here</a>";

die();

}

if (isset($_POST['password']))
{
$password = $_POST['password'];
}


$db = Database::getConnection();

function updateUserInfo(string $username, string $password)
{


//create UPDATE query string

if (isset('submit')) {
	# code...


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
            ':Email'=> $_POST['email']	
					));

}

/*if (isset($password) {
	# code...
	$hashedPassword = hash('sha512', $_POST['password']);

	$queryPass = $db->prepare("UPDATE User SET 	Password = ? WHERE UserId = ?");
	$queryPass->execute(array(':UserId'=>$username, 'Password'=>$hashedPassword));
	echo "password changed successfully";
*/

echo "Details saved! <a href='viewProfile.php'> View Your Profile "; 

?>
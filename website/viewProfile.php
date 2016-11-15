<?php

session_start();

require_once( 'functions/authorizations.php' );
require_once( 'classes/Database.php' );


if(SessionLogin::isLoggedIn())
{

	echo "you are logged in as <b>".SessionLogin::getUsername()."</b>";

	
}

else {

echo "you are not logged in. Please log in <a href='login.php'>here</a>";

die();

}


// You defined the function but didn't call it, so it won't do anything!
  function viewAccount()
  {
  	
  	$db = Database::getConnection();


  	 		$request = Database::query( "SELECT Title, FirstName, LastName, Address, Postcode, City, Telephone, Email, c.Notes
  	 		 FROM Person p, Customer c WHERE p.PersonId =( SELECT PersonID FROM Person WHERE UserId = ?) = c.PersonId", array(SessionLogin::getUsername()));
        
		if ($request->rowCount() === 1) {
			// fetchAll() is an instance method that returns the results as an two-dimensional array.
      // so you could do something like:
      // $row = $request->fetchAll()[0] // access the FIRST row of the results, and you remove the while loop
		$row = $request->fetch(); 
				
				echo "<br/>";
				echo "Title: ".$row['Title']. "       First Name ".$row['FirstName']."  ".$row['LastName']; // It's Title
				echo "<br/>";

				echo "Address: ".$row['Address'];
				echo "<br/>";

				echo " City ".$row['City']."  ".$row['Postcode'];
				echo "<br/>";

				echo "Telephone: ".$row['Telephone']; // it's Telephone
				echo "<br/>";

				echo "Email: ".$row['Email'];
				echo "<br/>";
				echo "Notes: ".$row['Notes'];
				echo "<br />";
		}
	
  }

  viewAccount();
  echo "<a href='edit-details.php'>Update Personal Details</a>";


  ?>



         <form action="viewProfile.php" method="POST">
        <button type="submit" id="deleteAccount">Delete Account</button>
        </form>
      

        <?php

          $db = Database::getConnection();



          $deleteAccount = $db->prepare("SET FOREIGN_KEY_CHECKS=0;". " DELETE FROM User WHERE UserId = ?");
          $deleteAccount->execute(array(SessionLogin::getUsername()));


          $db = null;

          $db_conn = Database::getConnection();

          $deletePersonal = $db_conn->prepare("SET FOREIGN_KEY_CHECKS=0;". " DELETE FROM Person WHERE UserId = ?");
          $deletePersonal->execute(array(SessionLogin::getUsername()));
          

          session_destroy();
        ?>


?>

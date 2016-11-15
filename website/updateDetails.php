<!doctype html>
<html>
  <head>
    <title>Update Details</title>
  </head>
  <body>
    <main>
      <h1>Update Your Details</h1>
     
<?php 

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/functions/authorizations.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/Database.php' );

session_start();

if(SessionLogin::isLoggedIn())
{

  echo "you are logged in as ".SessionLogin::getUsername();

  
}

else {

echo "you are not logged in. Please log in <a href='login.php'>here</a>";

die();

}

$db = Database::getConnection();


        /*
            I am performing this query for the purpose that if user does not fill anything in the form and accidently presses "update", the database table does not get updated with nulls. 
            therefore prefilling the forms will ensure that even if the form is submitted with NO changes, it does not affect the existing record in database.
        */

        $request = Database::query("SELECT Title, FirstName, LastName, Address, Postcode, City, Telephone, Email
         FROM Person WHERE UserId = ?", array(SessionLogin::getUsername()));

        if ($request->rowCount() === 1)
        {

            $row = $request->fetch()

        
        ?>

    <form action="updateInfo.php" id="form" method="POST">

      <table>

        </tr>
        <tr>
          <td><label for="title" form="form">Title</label></td>
          <td><input form="form" id="title"  type="text" value="<?php echo $row['Title']; ?>" /></td>
        </tr>
        <tr>
          <td><label for="first-name" form="form">First Name</label></td>
          <td><input id="first_name" type="text" value="<?php echo $row['FirstName'];?>" /></td>
        </tr>
        <tr>
          <td><label for="last-name" form="form">Last Name</label></td>
          <td><input  id="last_name"  type="text" value="<?php echo $row['LastName']; ?>" /></td>
        </tr>
        <tr>
          <td><label for="address" form="form">Address</label></td>
          <td><input  id="address"  type="text" value="<?php echo $row['Address']; ?>" /></td>
        </tr>
        <tr>
          <td><label for="postcode" form="form">Postcode</label></td>
          <td><input  id="postcode"  type="text" value="<?php echo $row['Postcode']; ?>" /></td>
        </tr>
        <tr>
          <td><label for="city" form="form">City</label></td>
          <td><input  id="city"  type="text" value="<?php echo $row['City']; ?>" /></td>
        </tr>
        <tr>
          <td><label for="telephone" form="form">Telephone</label></td>
          <td><input  id="telephone"  type="text" value="<?php echo $row['Telephone']; ?>" /></td>
        </tr>
        <tr>
          <td><label for="email" form="form">Email</label></td>
          <td><input id="email" name="email" type="text" value="<?php echo $row['Email']; ?>" /></td>
        </tr>

        <p> Change Password </p>

        <tr>
          <td><label for="password" form="form">New Password</label></td>
          <td><input  id="new_password" type="password" value="" /></td>
        </tr>

<?php  


  }

  ?>

      </table>
      
        <?php // TODO: (minor) add here and in other places a reset button? ?>
        <button type="submit">Update Details</button>
        </form>

         <form action="updateDetails.php" method="POST">
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

    </main>
  </body>
</html>
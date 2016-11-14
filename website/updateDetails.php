<!doctype html>
<html>
  <head>
    <title>Update Details</title>
  </head>
  <body>
    <main>
      <h1>Update Your Details</h1>
     
<?php 

$db = Database::getConnection();


        $request = Database::query("SELECT Title, FirstName, LastName, Address, Postcode, City, Telephone, Email
         FROM Person WHERE UserId = ?", array(SessionLogin::getUsername()));

        if ($request->rowCount() === 1)
        {

            $row = $request->fetch();

        }
?>


      <table>

        </tr>
        <tr>
          <td><label for="title" form="form">Title</label></td>
          <td><input form="form" id="title" name="title" type="text" value="<?php echo( getPost( 'title' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="first-name" form="form">First Name</label></td>
          <td><input form="form" id="first-name" name="first-name" type="text" value="<?php echo( getPost( 'first-name' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="last-name" form="form">Last Name</label></td>
          <td><input form="form" id="last-name" name="last-name" type="text" value="<?php echo( getPost( 'last-name' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="address" form="form">Address</label></td>
          <td><input form="form" id="address" name="address" type="text" value="<?php echo( getPost( 'address' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="postcode" form="form">Postcode</label></td>
          <td><input form="form" id="postcode" name="postcode" type="text" value="<?php echo( getPost( 'postcode' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="city" form="form">City</label></td>
          <td><input form="form" id="city" name="city" type="text" value="<?php echo( getPost( 'city' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="telephone" form="form">Telephone</label></td>
          <td><input form="form" id="telephone" name="telephone" type="text" value="<?php echo( getPost( 'telephone' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="email" form="form">Email</label></td>
          <td><input form="form" id="email" name="email" type="text" value="<?php echo( getPost( 'email' ) ) ?>" /></td>
        </tr>


      </table>
      <form action="updateInfo.php" id="form" method="POST">
        <?php // TODO: (minor) add here and in other places a reset button? ?>
        <button type="submit">Update Details</button>
      </form>
    </main>
  </body>
</html>
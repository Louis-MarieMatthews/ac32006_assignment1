<?php
session_start();

require_once( 'functions/html.php' );
require_once( 'functions/authorizations.php' );
require_once( 'classes/CustomerUserModel.php' );

checkIfNotLoggedIn();

// check received post variables
if ( isset( $_POST['username'] ) ) {
  $username = $_POST['username'];
}
else {
  $username = null;
}

if ( isset( $_POST['password'] ) ) {
  $password = $_POST['password'];
}
else {
  $password = null;
}

if ( isset( $_POST['title'] ) ) {
  $title = $_POST['title'];
}
else {
  $title = null;
}

if ( isset( $_POST['first-name'] ) ) {
  $firstName = $_POST['first-name'];
}
else {
  $firstName = null;
}

if ( isset( $_POST['last-name'] ) ) {
  $lastName = $_POST['last-name'];
}
else {
  $lastName = null;
}

if ( isset( $_POST['address'] ) ) {
  $address = $_POST['address'];
}
else {
  $address = null;
}

if ( isset( $_POST['post-code'] ) ) {
  $postCode = $_POST['post-code'];
}
else {
  $postCode = null;
}

if ( isset( $_POST['city'] ) ) {
  $city = $_POST['city'];
}
else {
  $city = null;
}

if ( isset( $_POST['telephone'] ) ) {
  $telephone = $_POST['telephone'];
}
else {
  $telephone = null;
}

if ( isset( $_POST['email'] ) ) {
  $email = $_POST['email'];
}
else {
  $email = null;
}

$formErrors = array();
if ( $username !== null & $password !== null & $firstName !== null & $lastName !== null & 
     $address !== null & $city !== null ) {
  $customer = new CustomerUserModel;
  try {
    $customer->setUsername( $username );
  }
  catch( DomainException $e ) {
    // TODO: maybe use a custom class as need to be sure DomainException caused by sql type classes
    $formErrors[] = $e->getMessage();
  }
  try {
    $customer->setPassword( $password );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
  try {
    $customer->setFirstName( $firstName );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
  try {
    $customer->setLastName( $lastName );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
  try {
    $customer->setAddress( $address );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
  try {
    $customer->setCity( $city );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
  
  if ( $title !== null ) {
    try {
      $customer->setTitle( $title );
    }
    catch( DomainException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  
  if ( $postCode !== null ) {
    try {
      $customer->setPostCode( $postCode );
    }
    catch( DomainException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  
  if ( $telephone !== null ) {
    try {
      $customer->setTelephone( $telephone );
    }
    catch( DomainException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  
  if ( $email !== null ) {
    try {
      $customer->setEmail( $email );
    }
    catch( DomainException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
}

?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Register</title>
  </head>
  <body>
    <main>
      <h1>Register</h1>
      <p>Want to become a customer is just as easy as filling this form!</p>
      <?php displayErrors( $formErrors ); ?>
      <?php // TODO: input validation html ?>
      <?php // TODO: input types, other input properties ?>
      <table>
        <tr>
          <td><label for="username" form="form">Username</label></td>
          <td><input form="form" id="username" name="username" type="text" value="<?php echo( $username ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="password" form="form">Password</label></td>
          <td><input form="form" id="password" name="password" type="text" value="<?php echo( $password ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="title" form="form">Title</label></td>
          <td><input form="form" id="title" name="title" type="text" value="<?php echo( $title ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="first-name" form="form">First Name</label></td>
          <td><input form="form" id="first-name" name="first-name" type="text" value="<?php echo( $firstName ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="last-name" form="form">Last Name</label></td>
          <td><input form="form" id="last-name" name="last-name" type="text" value="<?php echo( $lastName ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="address" form="form">Address</label></td>
          <td><input form="form" id="address" name="address" type="text" value="<?php echo( $address ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="post-code" form="form">Post Code</label></td>
          <td><input form="form" id="post-code" name="post-code" type="text" value="<?php echo( $postCode ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="city" form="form">City</label></td>
          <td><input form="form" id="city" name="city" type="text" value="<?php echo( $city ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="telephone" form="form">Telephone</label></td>
          <td><input form="form" id="telephone" name="telephone" type="text" value="<?php echo( $telephone ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="email" form="form">Email</label></td>
          <td><input form="form" id="email" name="email" type="text" value="<?php echo( $email ) ?>" /></td>
        </tr>
      </table>
      <form action="register.php" id="form" method="POST">
        <?php // add here and in other places a reset button? ?>
        <button type="submit">Register</button>
      </form>
    </main>
  </body>
</html>
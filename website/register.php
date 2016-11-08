<?php
session_start();

require_once( 'functions/html.php' );
require_once( 'functions/authorizations.php' );
require_once( 'classes/CustomerModel.php' );
require_once( 'classes/UserModel.php' );

checkIfNotLoggedIn();

// TODO: special handling when missing required value?
$formErrors = array();
if ( getPost( 'username' ) != null & 
     getPost( 'password' ) != null &
     getPost( 'first-name' ) != null &
     getPost( 'last-name' ) != null & 
     getPost( 'address' ) != null &
     getPost( 'city' ) != null ) {
  $customer = new CustomerModel;
  $user = new UserModel;
  $areDetailsValid = true;
  try {
    $customer->setUsername( getPost( 'username' ) );
    $user->setUsername( getPost( 'username' ) );
  }
  catch( DomainException $e ) {
    // TODO: (minor) maybe use a custom class as need to be sure
    // that DomainException caused by sql type classes
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $user->setPassword( getPost( 'password' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $customer->setFirstName( getPost( 'first-name' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $customer->setLastName( getPost( 'last-name' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $customer->setAddress( getPost( 'address' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $customer->setCity( getPost( 'city' ) );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  
  if ( getPost( 'title' ) !== null ) {
    try {
      $customer->setTitle( getPost( 'title' ) );
    }
    catch( DomainException $e ) {
      $formErrors[] = $e->getMessage();
      $areDetailsValid = false;
    }
  }
  
  if ( getPost( 'postcode' ) !== null ) {
    try {
      $customer->setPostcode( getPost( 'postcode' ) );
    }
    catch( DomainException $e ) {
      $formErrors[] = $e->getMessage();
      $areDetailsValid = false;
    }
  }
  
  if ( getPost( 'telephone' ) !== null ) {
    try {
      $customer->setTelephone( getPost( 'telephone' ) );
    }
    catch( DomainException $e ) {
      $formErrors[] = $e->getMessage();
      $areDetailsValid = false;
    }
  }
  
  if ( getPost( 'email' ) !== null ) {
    try {
      $customer->setEmail( getPost( 'email' ) );
    }
    catch( DomainException $e ) {
      $formErrors[] = $e->getMessage();
      $areDetailsValid = false;
    }
  }
  
  if ( $areDetailsValid ) {
    // TODO: (minor) what if user creation suceed but customer fail?
    // Customer insertion has no reason to fail though.
    try {
      $user->insert();
      $customer->insert();
      displayMessagePage( 'Registration sucessful', 'Your registration was
      successful!' );
      die();
    }
    catch( Exception $e ) {
      $formErrors[] = 'An error has occured. Your username is maybe 
      already taken.';
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
          <td><input form="form" id="username" name="username" type="text" value="<?php echo( getPost( 'username' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="password" form="form">Password</label></td>
          <td><input form="form" id="password" name="password" type="text" value="<?php echo( getPost( 'password' ) ) ?>" /></td>
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
      <form action="register.php" id="form" method="POST">
        <?php // add here and in other places a reset button? ?>
        <button type="submit">Register</button>
      </form>
    </main>
  </body>
</html>
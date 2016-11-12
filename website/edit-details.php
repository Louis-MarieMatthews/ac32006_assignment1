<?php

// Starts the session - necessary to enable login features
session_start();

// Dependencies
require_once( 'functions/html.php' );
require_once( 'classes/Database.php' );
require_once( 'classes/stores/Person.php' );
require_once( 'classes/SessionLogin.php' );

// Checks if logged in
if ( ! SessionLogin::isLoggedIn() ) {
  echo( 'You are not logged in.' );
  die();
}

// Gets the position and details of the currently logged-in user
// TODO make everything in one query using a JOIN
// TODO: Gets the person ID first, then do queries?
// TODO: Store the person ID in SessionLogin?
$pSql = '
  SELECT *
  FROM   Person
  WHERE  PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );
';  
$cmSql = '
  SELECT *
  FROM   CompanyManager
  WHERE  PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );
';
$bmSql = '
  SELECT *
  FROM   BranchManager
  WHERE  PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );
';
$saSql = '
  SELECT *
  FROM   SalesAssistant
  WHERE  PersonId = ( SELECT PersonId FROM Person WHERE UserId = ? );
';
$cSql = '
  SELECT *
  FROM   Customer
  WHERE  CustomerId = ( SELECT PersonId FROM Person WHERE UserId = ? );
';
$pFetch = Database::query( $pSql, array( SessionLogin::getUsername() ) )->fetch();
$cmFetch = Database::query( $cmSql, array( SessionLogin::getUsername() ) )->fetch();
$bmFetch = Database::query( $bmSql, array( SessionLogin::getUsername() ) )->fetch();
$saFetch = Database::query( $saSql, array( SessionLogin::getUsername() ) )->fetch();
$cFetch = Database::query( $cSql, array( SessionLogin::getUsername() ) )->fetch();

// Create and hydrate person object
$person = new Person;
$person->setPersonId( $pFetch['PersonId'] );
$person->setTitle( $pFetch['Title'] );
$person->setFirstName( $pFetch['FirstName'] );
$person->setLastName( $pFetch['LastName'] );
$person->setAddress( $pFetch['Address'] );
$person->setPostcode( $pFetch['Postcode'] );
$person->setCity( $pFetch['City'] );
$person->setTelephone( $pFetch['Telephone'] );
$person->setEmail( $pFetch['Email'] );

// Updates values with the potential correct post values
// TODO: Obviously, to refactor
$formErrors = array();
if ( getPost( 'title' ) !== null ) {
  try {
    $person->setTitle( getPost( 'title' ) );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
}
if ( getPost( 'first-name' ) !== null ) {
  try {
    $person->setFirstName( getPost( 'first-name' ) );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
}
if ( getPost( 'last-name' ) !== null ) {
  try {
    $person->setLastName( getPost( 'last-name' ) );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
}
if ( getPost( 'address' ) !== null ) {
  try {
    $person->setAddress( getPost( 'address' ) );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
}
if ( getPost( 'postcode' ) !== null ) {
  try {
    $person->setPostcode( getPost( 'postcode' ) );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
}
if ( getPost( 'city' ) !== null ) {
  try {
    $person->setCity( getPost( 'city' ) );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
}
if ( getPost( 'telephone' ) !== null ) {
  try {
    $person->setTelephone( getPost( 'telephone' ) );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
}
if ( getPost( 'email' ) !== null ) {
  try {
    $person->setEmail( getPost( 'email' ) );
  }
  catch ( DomainException $e ) {
    $formErrors[] = $e->getMessage();
  }
}

// Pushes the new person to the database
// TODO: only make commands if there has change and commit only
// changed values.
$updatePersonSql = '
  UPDATE Person
  SET    Title = ?,
         FirstName = ?,
         LastName = ?,
         Address = ?,
         Postcode = ?,
         City = ?,
         Telephone = ?,
         Email = ?
  WHERE  PersonId = ?;
';
$updatePersonParameters = array(
  $person->getTitle(),
  $person->getFirstName(),
  $person->getLastName(),
  $person->getAddress(),
  $person->getPostcode(),
  $person->getCity(),
  $person->getTelephone(),
  $person->getEmail(),
  $person->getPersonId() );
// TODO: check that the commit went fine
Database::query( $updatePersonSql, $updatePersonParameters );
?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Edit your Details</title>
  </head>
  <body>
    <main>
      <?php displayErrors( $formErrors ); ?>
      <table>
        <tr>
          <td>
            Person Id
          </td>
          <td>
            <?php echo( $person->getPersonId() ) ?>
          </td>
        </tr>
        <tr>
          <td>
            Username
          </td>
          <td>
            <?php echo( SessionLogin::getUsername() ) ?>
          </td>
        </tr>
        <tr>
          <td>
            <label for="title" form="form">Title</label>
          </td>
          <td>
            <input form="form" id="title" name="title" type="text"
            value="<?php echo( $person->getTitle() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="first-name" form="form">First Name</label>
          </td>
          <td>
            <input form="form" id="first-name" name="first-name"
            type="text" value="<?php echo( $person->getFirstName() ) ?>"
            />
          </td>
        </tr>
        <tr>
          <td>
            <label for="last-name" form="form">Last Name</label>
          </td>
          <td>
            <input form="form" id="last-name" name="last-name"
            type="text" value="<?php echo( $person->getLastName() ) ?>"
            />
          </td>
        </tr>
        <tr>
          <td>
            <label for="address" form="form">Address</label>
          </td>
          <td>
            <input form="form" id="address" name="address" type="text"
            value="<?php echo( $person->getAddress() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="postcode" form="form">Postcode</label>
          </td>
          <td>
            <input form="form" id="postcode" name="postcode"
            type="text" value="<?php echo( $person->getPostcode() ) ?>"/>
          </td>
        </tr>
        <tr>
          <td>
            <label for="city" form="form">City</label>
          </td>
          <td>
            <input form="form" id="city" name="city" type="text"
            value="<?php echo( $person->getCity() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="telephone" form="form">Telephone</label>
          </td>
          <td>
            <input form="form" id="telephone" name="telephone" type="text"
            value="<?php echo( $person->getTelephone() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="email" form="form">Email</label>
          </td>
          <td>
            <input form="form" id="email" name="email" type="text"
            value="<?php echo( $person->getEmail() ) ?>" />
          </td>
        </tr>
      </table>
      <form id="form" method="POST" action="#">
        <button type="submit">Update Details</button>
      </form>
    </main>
  </body>
</html>
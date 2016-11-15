<?php

// Starts the session - necessary to enable login features
session_start();

// Dependencies
require_once( 'functions/html.php' );
require_once( 'classes/Database.php' );
require_once( 'classes/stores/Person.php' );
require_once( 'classes/stores/BranchManager.php' );
require_once( 'classes/stores/SalesAssistant.php' );
require_once( 'classes/stores/CompanyManager.php' );
require_once( 'classes/SessionLogin.php' );

// Checks if logged in
if ( ! SessionLogin::isLoggedIn() ) {
  displayAccessDenied();
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
if ( $cmFetch !== false | $bmFetch !== false | $saFetch !== false ) {
  $isEmployee = true;
}
else {
  $isEmployee = false;
}

// Create and hydrate person object
if ( $cmFetch !== false ) {
  $person = new CompanyManager;
  $person->setSortCode( $cmFetch['SortCode'] );
  $person->setAccountNumber( $cmFetch['AccountNumber'] );
}
elseif ( $bmFetch !== false ) {
  $person = new BranchManager;
  $person->setSortCode( $bmFetch['SortCode'] );
  $person->setAccountNumber( $bmFetch['AccountNumber'] );
}
elseif ( $saFetch !== false ) {
  $person = new SalesAssistant;
  $person->setSortCode( $saFetch['SortCode'] );
  $person->setAccountNumber( $saFetch['AccountNumber'] );
}
else {
  $person = new Person;
}
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
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  if ( getPost( 'title' ) !== null ) {
    try {
      $person->setTitle( getPost( 'title' ) );
    }
    catch ( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'first-name' ) !== null ) {
    try {
      $person->setFirstName( getPost( 'first-name' ) );
    }
    catch ( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'last-name' ) !== null ) {
    try {
      $person->setLastName( getPost( 'last-name' ) );
    }
    catch ( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'address' ) !== null ) {
    try {
      $person->setAddress( getPost( 'address' ) );
    }
    catch ( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'postcode' ) !== null ) {
    try {
      $person->setPostcode( getPost( 'postcode' ) );
    }
    catch ( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'city' ) !== null ) {
    try {
      $person->setCity( getPost( 'city' ) );
    }
    catch ( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'telephone' ) !== null ) {
    try {
      $person->setTelephone( getPost( 'telephone' ) );
    }
    catch ( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  if ( getPost( 'email' ) !== null ) {
    try {
      $person->setEmail( getPost( 'email' ) );
    }
    catch ( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
    }
  }
  if ( $isEmployee ) {
    if ( getPost( 'account-number' ) !== null ) {
      try {
        $person->setAccountNumber( getPost( 'account-number' ) );
      }
      catch ( IllegalFormatException $e ) {
        $formErrors[] = $e->getMessage();
      }
    }
    if ( getPost( 'sort-code' ) !== null ) {
      try {
        $person->setSortCode( getPost( 'sort-code' ) );
      }
      catch ( IllegalFormatException $e ) {
        $formErrors[] = $e->getMessage();
      }
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
  if ( $isEmployee ) {
    if ( $cmFetch !== false ) {
      $updateEmployeeSql = '
        UPDATE CompanyManager
        SET    AccountNumber = ?,
               SortCode = ?
        WHERE  PersonId = ?;
      ';
    }
    elseif ( $bmFetch !== false ) {
      $updateEmployeeSql = '
        UPDATE BranchManager
        SET    AccountNumber = ?,
               SortCode = ?
        WHERE  PersonId = ?;
      ';
    }
    else  {
      $updateEmployeeSql = '
        UPDATE SalesAssistant
        SET    AccountNumber = ?,
               SortCode = ?
        WHERE  PersonId = ?;
      ';
    }
    $updateEmployeeParameters = array(
      $person->getAccountNumber(),
      $person->getSortCode(),
      $person->getPersonId() );
    Database::query( $updateEmployeeSql, $updateEmployeeParameters );
  }
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
}

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
            <input form="form" id="telephone" name="telephone"
            type="text"
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
        <?php if ( $isEmployee ) : ?>
        <tr>
          <td>
            <label for="account-number" form="form">Account Number
            </label>
          </td>
          <td>
            <input form="form" id="account-number"
            name="account-number" type="text"
            value="<?php echo( $person->getAccountNumber() ) ?>" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="sort-code" form="form">Sort Code</label>
          </td>
          <td>
            <input form="form" id="sort-code" name="sort-code"
            type="text"
            value="<?php echo( $person->getSortCode() ) ?>" />
          </td>
        </tr>
        <?php endif ?>
      </table>
      <form id="form" method="POST" action="#">
        <button type="submit">Update Details</button>
      </form>
    </main>
  </body>
</html>
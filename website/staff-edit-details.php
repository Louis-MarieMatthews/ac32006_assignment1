<?php
session_start();

require_once( 'classes/SessionLogin.php' );
require_once( 'classes/BranchManagerModel.php' );
require_once( 'classes/SalesAssistantModel.php' );
require_once( 'classes/stores/BranchManager.php' );
require_once( 'classes/stores/SalesAssistant.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

/**
 * This page is to allow shop assistants and managers
 * to manage their details.
 */

checkIfEmployee();

$isBranchManager = BranchManagerModel::isBranchManager( SessionLogin::getUsername() );
$isSalesAssistant = SalesAssistantModel::isSalesAssistant( SessionLogin::getUsername() );

if ( $isBranchManager ) {
  $user = new BranchManager();
}
else {
  $user = new SalesAssistant();
}
try {
  $user->setUsername( SessionLogin::getUsername() );
}
catch( DomainException $e ) {
  displayUnknownError();
}
if ( $isBranchManager ) {
$sql = '
  SELECT *
  FROM   BranchManager
  WHERE  PersonId = (SELECT PersonId FROM Person WHERE UserId = ? );
';
}
else {
$sql = '
  SELECT *
  FROM   SalesAssistant
  WHERE  PersonId = (SELECT PersonId FROM Person WHERE UserId = ? );
';
}
$parameters = array( SessionLogin::getUsername() );
$request = Database::query( $sql, $parameters )->fetchAll()[0];
$user->setPersonId( $request['PersonId'] );
$user->setBranchId( $request['BranchId'] );
$user->setWage( $request['Wage'] );
$user->setSortCode( $request['SortCode'] );
$user->setAccountNumber( $request['AccountNumber'] );

$formErrors = array();
$isValid = true;
if ( isset( $_POST['sort-code'] ) ) {
  try {
    $user->setSortCode( $_POST['sort-code'] );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
}
if ( isset( $_POST['account-number'] ) ) {
  try {
    $user->setAccountNumber( $_POST['account-number'] );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
}

if ( $isBranchManager ) {
  $sql = '
    UPDATE BranchManager
    SET    PersonId = ?,
           BranchId = ?,
           Wage = ?,
           SortCode = ?,
           AccountNumber = ?
    WHERE  PersonId = (SELECT PersonId FROM Person WHERE UserId = ? );
  ';
}
else {
  $sql = '
    UPDATE SalesAssistant
    SET    PersonId = ?,
           BranchId = ?,
           Wage = ?,
           SortCode = ?,
           AccountNumber = ?
    WHERE  PersonId = (SELECT PersonId FROM Person WHERE UserId = ? );
  ';
}
$parameters = array(
  $user->getPersonId(),
  $user->getBranchId(),
  $user->getWage(),
  $user->getSortCode(),
  $user->getAccountNumber(),
  SessionLogin::getUsername()
);
Database::query( $sql, $parameters );
?>
<!doctype html>
<html>
  <head>
    <?php displayHead(); ?>
    <title>Your Employee Details</title>
  </head>
  <body>
    <main>
      <h1>Your staff details</h1>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <tr>
          <td>Your branch: </td>
          <td><?php echo( $user->getBranchId() ) ?></td>
        </tr>
        <tr>
          <td>Your wage: </td>
          <td><?php echo( $user->getWage() ) ?></td>
        </tr>
        <tr>
          <td><label for="sort-code" form="form">Your sort code: </label></td>
          <!-- HTML pattern from nhahtdh at http://stackoverflow.com/questions/11341957/uk-bank-sort-code-javascript-regular-expression -->
          <td>
              <input
                id="sort-code"
                form="form"
                <?php // TODO: To remove maxlength="8" ?>
                name="sort-code"
                <?php // TODO: To remove pattern="^(?!(?:0{6}|00-00-00))(?:\d{6}|\d\d-\d\d-\d\d)$" ?>
                type="text"
                value="<?php echo( $user->getSortCode() ) ?>"
              />
          </td>
        </tr>
        <tr>
          <td><label for="account-number" form="form">Your account number: </label></td>
          <td>
            <input
              id="account-number"
              form="form"
              <?php // TODO: To remove maxlength="8" ?>
              name="account-number"
              type="text"
              value="<?php echo( $user->getAccountNumber() ) ?>"
            />
          </td>
        </tr>
      </table>
      <form action="staff-edit-details.php" id="form" method="POST">
        <button type="submit">Update your details</button>
      </form>
    </main>
  </body>
</html>
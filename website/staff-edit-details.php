<?php

session_start();

require_once( 'classes/BranchManagerUserModel.php' );
require_once( 'classes/SalesAssistantUserModel.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

/**
 * This page is to allow shop assistants and managers
 * to manage their details.
 */

checkIfEmployee();

$isBranchManager = BranchManagerUserModel::isBranchManager( SessionLogin::getUsername() );
$isSalesAssistant = SalesAssistantUserModel::isSalesAssistant( SessionLogin::getUsername() );

if ( $isBranchManager ) {
  $user = new BranchManagerUserModel();
}
else {
  $user = new SalesAssistantUserModel();
}
$user->setUsername( SessionLogin::getUsername() );
$user->pull();

if ( isset( $_POST['sort-code'] ) ) {
  $user->setSortCode( $_POST['sort-code'] );
}
if ( isset( $_POST['account-number'] ) ) {
  $user->setAccountNumber( $_POST['account-number'] );
}
$user->push();
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
                maxlength="8"
                name="sort-code"
                pattern="^(?!(?:0{6}|00-00-00))(?:\d{6}|\d\d-\d\d-\d\d)$"
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
              maxlength="8"
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
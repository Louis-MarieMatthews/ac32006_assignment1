<?php
session_start();

require_once( 'classes/SessionLogin.php' );
require_once( 'classes/UserModel.php' );
require_once( 'functions/html.php' );
?>
<!doctype html>
<html>
  <head>
    <?php displayHead(); ?>
    <title>Login</title>
  </head>
  <body>
    <main>
      <?php
      if ( SessionLogin::isLoggedIn() ) {
        if ( isset( $_POST['log-out'] ) ) {
          SessionLogin::init();
          ?>
          <!-- Attributes -->
          <p>You have been logged out. <a href="login.php">Log in.</a></p>
          <?php
        }
        else {
          ?>
          <p>You are already logged in.</p>
          <?php
          displayLogOutForm();
        }
      }
      else if ( isset( $_POST['username'] ) & isset( $_POST['password'] ) ) {
        if ( ! UserModel::areCredentialsCorrect( $_POST['username'], $_POST['password'] ) ) {
        ?>
      <p>The details you entered are incorrect. <a href="login.php">Log in.</a></p>
      <?php
          }
          else {
            SessionLogin::setUsername( $_POST['username'] );
      ?>
      <p>Connected as <?php echo( SessionLogin::getUsername() ) ?>.</p>
      <?php displayLogOutForm() ?>
      <?php
          }
        }
        else {
      ?>
      <!-- TODO: check all necessary fields are defined for each input / button -->
      <table>
        <tr>
          <td><label for="username" form="form">Username: </label></td>
          <td><input form="form" id="username" name="username" type="text" /></td>
        </tr>
        <tr>
          <td><label for="password" form="form">Password: </label></td>
          <td><input form="form" id="password" name="password" type="password" /></td>
        </tr>
      </table>
      <form action="login.php" id="form" method="POST">
        <button type="submit">Login</button>
      </form>
      <?php
        }
      ?>
    </main>
  </body>
</html>
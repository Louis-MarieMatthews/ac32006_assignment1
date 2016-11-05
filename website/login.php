<?php
require_once( 'classes/SessionLogin.php' );
require_once( 'classes/UserModel.php' );
require_once( 'functions/html.php' );
?>
<!doctype html>
<html>
  <head>
    <title>Login</title>
	<!-- TODO: replace head content with template -->
  </head>
  <body>
    <?php
      if ( SessionLogin::isLoggedIn() ) {
        if ( isset( $_POST['log-out'] ) ) {
          SessionLogin::resetLoginState();
    ?>
    <!-- Attributes -->
    <p>You have been logged out. <a href="login.php">Log in.</a></p>
    <?php
        }
        else {
    ?>
	  <p>You are already logged in.</p>
    <?php echologoutform() ?>
	  <?php
        }
      }
      else if ( isset( $_POST['username'] ) & isset( $_POST['password'] ) ) {
        if ( ! UserModel::areCredentialsCorrect( $_POST['username'], $_POST['password'] ) ) {
    ?>
    <p>The details you entered are incorrect. <a href="login.php">Log in.</a></p>
    <?php
        }
        else {
          SessionLogin::setLoginState( true, $_POST['username'] );
    ?>
    <p>Connected as <?php echo( SessionLogin::getUsername() ) ?>.</p>
    <?php echologoutform() ?>
    <?php
        }
      }
      else {
    ?>
    <form method="post" action="login.php">
	<!-- TODO: check all necessary fields are defined for each input / button -->
      <ul>
        <li>
          <label for="username">Username: </label>
          <input type="text" name="username" id="username" />
        </li>
        <li>
          <label for="password">Password: </label>
          <input type="password" name="password" id="password" />
        </li>
        <li>
          <button type="submit">Submit</button>
        </li>
      </ul>
    </form>
    <?php
      }
    ?>
  </body>
</html>
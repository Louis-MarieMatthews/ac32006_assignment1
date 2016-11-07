<?php

/**
 * This method displays the head elements common to most pages.
 * It has to be called before the <title> element as it sets the charset.
 * 
 * @author Louis-Marie Matthews
 */
function displayHead() {
  ?>
  <meta charset="utf-8" />
  <link href="style.css" rel="stylesheet" type="text/css" />
  <?php
}



function echologoutform() {
?>
<form method="post" action="login.php">
  <input type="hidden" name="log-out" value="true" />
  <button type="submit">Log out</button>
</form>
<?php
}



/**
 * This method displays in a table the persons contained within the array given inside the
 * parameters.
 *
 * @author Louis-Marie Matthews
 */
function displayPersons( array $persons, string $title ) {
  ?>
  <table class="bordered-table" >
  <caption><?php echo( $title ) ?></caption>
  <thead>
    <tr>
      <td>Person Id</td>
      <td>Username</td>
      <td>Title</td>
      <td>First Name</td>
      <td>Last Name</td>
      <td>Address</td>
      <td>Postcode</td>
      <td>City</td>
      <td>Telephone</td>
      <td>Email</td>
    </tr>
  </thead>
  <?php
  foreach( $persons as $current ) {
    ?>
    <tr>
      <td><?php echo( $current['PersonId'] ) ?></td>
      <td><?php echo( $current['UserId'] ) ?></td>
      <td><?php echo( $current['Title'] ) ?></td>
      <td><?php echo( $current['FirstName'] ) ?></td>
      <td><?php echo( $current['LastName'] ) ?></td>
      <td><?php echo( $current['Address'] ) ?></td>
      <td><?php echo( $current['Postcode'] ) ?></td>
      <td><?php echo( $current['City'] ) ?></td>
      <td><?php echo( $current['Telephone'] ) ?></td>
      <td><?php echo( $current['Email'] ) ?></td>
    </tr>
    <?php
  }
  ?>
  </table>
  <?php
}



function displayAccessDenied( string $message = 'You can\'t access this page',
                            string $title = 'Access Denied' )
{
  ?>
  <!doctype html>
  <html>
    <head>
      <?php displayHead() ?>
      <title><?php echo( $title ) ?></title>
    </head>
    <body>
      <main>
        <h1><?php echo ( $title ) ?></h1>
        <p><?php echo( $message ) ?></p>
      </main>
    </body>
  </html>
  <?php
}



/**
 * This method displays a number-indexed array of strings as a list of errors.
 */
function displayErrors( array $errors ) {
  if ( sizeof( $errors) !==0 ) {
    foreach ( $errors as $error ) {
      ?>
      <p class="error"><?php echo( $error ) ?></p>
      <?php
    }
  }
}
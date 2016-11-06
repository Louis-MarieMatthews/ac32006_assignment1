<?php
function echologoutform() {
?>
<form method="post" action="login.php">
  <input type="hidden" name="log-out" value="true" />
  <button type="submit">Log out</button>
</form>
<?php
}

/**
 * Display in a table the persons contained within the array given inside the parameters.
 *
 * @author Louis-Marie Matthews
 */
function displayPersons( array $persons, string $title ) {
  // TODO: remblace style="…" by class="…"
  ?>
  <table style="margin-bottom: 20px;">
  <caption style="font-weight: bold; font-size: 2em; text-align: left;"><?php echo( $title ) ?></caption>
  <thead style="font-weight: bold;" >
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
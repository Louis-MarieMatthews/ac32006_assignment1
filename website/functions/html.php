<?php
function echologoutform() {
?>
<form method="post" action="login.php">
  <input type="hidden" name="log-out" value="true" />
  <button type="submit">Log out</button>
</form>
<?php
}
<?php

declare( STRICT_TYPES = 1 );

/**
 * Use this class to access / manage user related data stored in the database.
 *
 * @author Louis-Marie Matthews
 */
class UserModel {
  public static function areCredentialsCorrect( string $username, string $password ) : bool {
    $db = Database::getConnection();
    $request = $db->prepare( 'SELECT Password FROM User WHERE UserId = ?;' );
    $request->execute( array( $username ) );
    if ( $request->columnCount() === 0 | $request->fetch()['Password'] !== $password ) {
      return false;
    }
    else {
      return true;
    }
  }
}
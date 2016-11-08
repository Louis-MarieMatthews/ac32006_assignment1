<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/Database.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Password.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Username.php' );

/**
 * Use this class to access / manage user related data stored in the database.
 * Password are not stored in clear, but instead as SHA512 hashes. This class takes care of hashing
 * passords and inserting them in the database.
 * Add here any function related to updating / maintaining users.
 *
 * @author Louis-Marie Matthews
 */
class UserModel
{
  private $username;
  private $password;
  
  /**
   * Tell if the given credentials are correct.
   * 
   * @param $username the username of the user (stored as UserId in the database)
   * @param $password the corresponding non-hashed password of the user (the method takes care of hashing it)
   */
  public static function areCredentialsCorrect( string $username, string $password ) : bool {
    $hashed_password = hash( 'sha512', $password );
    $request = Database::query( 'SELECT Password FROM User WHERE UserId = ?;', array( $username) );
    if ( $request->rowCount() === 0 | $request->fetch()['Password'] !== $hashed_password ) {
      return false;
    }
    else {
      return true;
    }
  }
  
  
  
  /**
   * Update the password of the specified user.
   * 
   * @param $username the username of the user (stored as UserId in the database)
   * @param $password the non-hashed password of the user (the method takes care of hashing it)
   */
  public static function updatePassword( string $username, string $password ) {
    $hashed_password = hash( 'sha512', $password );
    $request = Database::query( 'UPDATE User SET Password = ? WHERE UserId = ?;', array( $hashed_password, $username ) );
  }
  
  
  
  public function insert() {
    if ( $this->password == null | $this->username == null ) {
      throw new Exception( 'password or username not set' );
    }
    $query = '
      INSERT INTO User ( UserId, Password)
      VALUES ( ?, ? );
    ';
    $parameters = array( $this->getUsername(), $this->getHashedPassword() );
    Database::query( $query, $parameters );
  }
  
  
  
  public function getHashedPassword() {
    return hash( 'sha512', (string) $this->password );
  }
  
  
  
  public function getPassword() {
    return $this->password;
  }
  
  
  
  public function getUsername() {
    return $this->username;
  }
  
  
  
  public function setPassword( $password ) {
    if ( $password == null ) {
      $this->password = null;
    }
    else {
      $this->password = new Password( $password );
    }
  }
  
  
  
  public function setUsername( $username ) {
    if ( $username == null ) {
      $this->username = null;
    }
    else {
      $this->username = new Username( $username );
    }
  }
}
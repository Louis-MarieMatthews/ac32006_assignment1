<?php

require_once( '/classes/stores/Password.php' );
require_once( '/classes/stores/Username.php' );
/**
 * @author Louis-Marie Matthews
 **/

class User
{
  private $username;
  private $password;
  
  
  
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
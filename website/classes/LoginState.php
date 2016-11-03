<?php

declare( STRICT_TYPES = 1 );

/**
 * Class to store login information.
 * 
 * @author Louis-Marie Matthews
 */
class LoginState {
  private $isLoggedIn;
  private $username;
  
  
  
  public function __construct() {
    $this->isLoggedIn = false;
    $this->username = null;
  }
  
  
  
  public function init( bool $isLoggedIn, string $username ) {
    $this->isLoggedIn = $isLoggedIn;
    $this->username = $username;
  }
  
  
  
  public function isLoggedIn() : bool { // boolean doesn't work
    return $this->isLoggedIn;
  }
  
  
  
  public function getUsername() : string {
    return $this->username;
  }
}
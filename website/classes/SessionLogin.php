<?php

declare( STRICT_TYPES = 1 );

/**
 * Class providing static methods to manage the current user login state.
 * 
 * @author Louis-Marie Matthews
 */
class SessionLogin {
  
  
  
  /**
   * Call this method to disconnect the user.
   */
  public static function init() {
    $_SESSION['username'] = null;
  }
  
  
  
  /**
   * Return true if the user is logged-in, false otherwise.
   */
  public static function isLoggedIn() : bool {
    self::checkIfInitialized();
    if ( $_SESSION['username'] === null ) {
      return false;
    }
    else {
      return true;
    }
  }
  
  
  
  /**
   * Return the username of the currently logged-in user, or null if they're not logged in.
   */
  public static function getUsername() : string {
    self::checkIfInitialized();
    return $_SESSION['username'];
  }
  
  
  
  /**
   * Call this function (SessionLogin::setUsername("Louis")) to set the user as logged-in and set 
   * their username as well.
   */
  public static function setUsername( string $username ) {
    $_SESSION['username'] = $username;
  }
  
  
  
  private static function checkIfInitialized() {
    if ( ! isset( $_SESSION['username'] ) ) {
      self::init();
    }
  }
}
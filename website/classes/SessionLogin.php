<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/LoginState.php' );

/**
 * Class providing static methods to manage and make sense of the 
 * LoginState session variable.
 * 
 * @author Louis-Marie Matthews
 */
class SessionLogin {
  
  
  
  public static function init() {
    if ( session_status() === PHP_SESSION_NONE )
      session_start();
    $_SESSION['login_state'] = new LoginState;
  }
  
  
  
  public static function setLoginState( bool $isLoggedIn, string $username ) {
    self::checkIfInitialised();
    $_SESSION['login_state']->init( $isLoggedIn, $username );
  }
  
  
  
  public static function resetLoginState() {
    self::checkIfInitialised();
    $_SESSION['login_state'] = new LoginState;
  }
  
  
  
  public static function isLoggedIn() : bool {
    self::checkIfInitialised();
    return $_SESSION['login_state']->isLoggedIn();
  }
  
  
  
  public static function getUsername() : string {
    return $_SESSION['login_state']->getUsername();
  }
  
  
  
  private static function checkIfInitialised() {
    if ( ! isset( $_SESSION['login_state'] ) )
      self::init();
  }
}
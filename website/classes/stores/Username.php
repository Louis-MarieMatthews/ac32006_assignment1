<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );

class Username
{
  private $username;
  
  
  
  public final function __construct( $username ) {
    $this->set( $username );
  }
  
  
  
  public final function set( $username ) {
    if ( self::isValid( $username ) ) {
      $this->username = $username;
    }
    else {
      throw new IllegalFormatException( 'invalid username' );
    }
  }
  
  
  
  public final static function isValid( $string ) {
    if ( strlen( $string ) <= 255 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->username;
  }
}
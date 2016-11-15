<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );

class Password
{
  private $password;
  
  
  
  public final function __construct( $password ) {
    $this->set( $password );
  }
  
  
  
  public final function set( $password ) {
    if ( self::isValid( $password ) ) {
      $this->password = $password;
    }
    else {
      throw new IllegalFormatException( 'invalid password' );
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
    return $this->password;
  }
}
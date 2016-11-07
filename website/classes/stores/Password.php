<?php

declare( STRICT_TYPES = 1 );

class Password
{
  private $password;
  
  
  
  public final function __construct( string $password ) {
    $this->set( $password );
  }
  
  
  
  public final function set( string $password ) {
    if ( self::isValid( $password ) ) {
      $this->password = $password;
    }
    else {
      throw new DomainException( 'invalid password' );
    }
  }
  
  
  
  public final static function isValid( string $string ) : bool {
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
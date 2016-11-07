<?php

declare( STRICT_TYPES = 1 );

class Username
{
  private $username;
  
  
  
  public final function __construct( string $username ) {
    $this->set( $username );
  }
  
  
  
  public final function set( string $username ) {
    if ( self::isValid( $username ) ) {
      $this->username = $username;
    }
    else {
      throw new DomainException( 'invalid username' );
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
    return $this->username;
  }
}
<?php

declare( STRICT_TYPES = 1 );

class Address
{
  private $address;
  
  
  
  public final function __construct( string $address ) {
    $this->set( $address );
  }
  
  
  
  public final function set( string $address ) {
    if ( self::isValid( $address ) ) {
      $this->address = $address;
    }
    else {
      throw new DomainException( 'invalid address' );
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
    return $this->address;
  }
}
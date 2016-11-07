<?php

declare( STRICT_TYPES = 1 );

class City
{
  private $city;
  
  
  
  public final function __construct( string $city ) {
    $this->set( $city );
  }
  
  
  
  public final function set( string $city ) {
    if ( self::isValid( $city ) ) {
      $this->city = $city;
    }
    else {
      throw new DomainException( 'invalid city' );
    }
  }
  
  
  
  public final static function isValid( string $string ) : bool {
    if ( strlen( $string ) <= 85 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->city;
  }
}
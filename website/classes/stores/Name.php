<?php

declare( STRICT_TYPES = 1 );

class Name
{
  private $name;
  
  
  
  public final function __construct( string $name ) {
    $this->set( $name );
  }
  
  
  
  public final function set( string $name ) {
    if ( self::isValid( $name ) ) {
      $this->name = $name;
    }
    else {
      throw new DomainException( 'invalid name' );
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
    return $this->name;
  }
}
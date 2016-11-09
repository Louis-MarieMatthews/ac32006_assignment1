<?php

declare( STRICT_TYPES = 1 );

class Telephone
{
  private $telephone;
  
  
  
  public final function __construct( string $telephone ) {
    $this->set( $telephone );
  }
  
  
  
  public final function set( string $telephone ) {
    if ( self::isValid( $telephone ) ) {
      $this->telephone = $telephone;
    }
    else {
      throw new DomainException( 'invalid telephone' );
    }
  }
  
  
  
  public final static function isValid( string $string ) : bool {
    // TODO: improve
    $withoutSpaces = str_replace( ' ', '', $string );
    if ( ctype_digit( $withoutSpaces ) & strlen( $withoutSpaces ) < 20 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->telephone;
  }
}
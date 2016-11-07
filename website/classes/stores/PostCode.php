<?php

declare( STRICT_TYPES = 1 );

class PostCode
{
  private $postCode;
  
  
  
  public final function __construct( string $postCode ) {
    $this->set( $postCode );
  }
  
  
  
  public final function set( string $postCode ) {
    if ( self::isValid( $postCode ) ) {
      $this->postCode = $postCode;
    }
    else {
      throw new DomainException( 'invalid post code' );
    }
  }
  
  
  
  public final static function isValid( string $string ) : bool {
    // From Brian Campbell at http://stackoverflow.com/questions/164979/uk-postcode-regex-comprehensive
    $regex = '/(GIR 0AA)|((([A-Z-[QVX]][0-9][0-9]?)|(([A-Z-[QVX]][A-Z-[IJZ]][0-9][0-9]?)|(([A-Z-[QVX]][0-9][A-HJKPSTUW])|([A-Z-[QVX]][A-Z-[IJZ]][0-9][ABEHMNPRVWXY])))) [0-9][A-Z-[CIKMOV]]{2})/';
    if ( preg_match( $regex, $string ) ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->postCode;
  }
}
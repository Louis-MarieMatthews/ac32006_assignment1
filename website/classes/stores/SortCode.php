<?php

declare( STRICT_TYPES = 1 );

class SortCode
{
  private $sortCode;
  
  
  
  public final function __construct( string $sortCode ) {
    $this->setSortCode( $sortCode );
  }
  
  
  
  /**
   * TODO: accept sort codes with digits separated by spaces
   */
  public final static function isValidSortCode( string $candidate ) : bool {
    $regex = '/^(?!(?:0{6}|00-00-00))(?:\d{6}|\d\d-\d\d-\d\d)$/';
    if ( preg_match( $regex, $candidate ) === 1 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function setSortCode( string $sortCode ) {
    if ( self::isValidSortCode( $sortCode ) ) {
      $this->sortCode = $sortCode;
    }
    else {
      throw new DomainException( 'invalid sort code', 9587 );
    }
  }
  
  
  
  public final function __toString() {
    return $this->sortCode;
  }
}
<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );

class Email
{
  private $email;
  
  
  
  public final function __construct( $email ) {
    $this->set( $email );
  }
  
  
  
  public final function set( $email ) {
    if ( self::isValid( $email ) ) {
      $this->email = $email;
    }
    else {
      throw new IllegalFormatException( 'invalid email' );
    }
  }
  
  
  
  public final static function isValid( $string ) {
    // By tom at https://disqus.com/home/discussion/emailregex/email_address_regular_expression_that_999_works/#comment-1941545513
    $regex = '/.+@.+/';
    if ( preg_match( $regex, $string ) === 1 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->email;
  }
}
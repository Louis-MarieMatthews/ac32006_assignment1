<?php

require_once( '/classes/exceptions/IllegalFormatException.php' );
require_once( '/classes/stores/Person.php' );

class Customer extends Person
{
  private $notes;
  
  
  
  public function getNotes() {
    return $this->notes;
  }
}
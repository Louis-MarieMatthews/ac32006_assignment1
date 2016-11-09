<?php

declare( STRICT_TYPES = 1 );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/ac32006_assignment1/website/classes/stores/Person.php' );

class Customer extends Person
{
  private $notes;
  
  
  
  public function getNotes() {
    return $this->notes;
  }
}
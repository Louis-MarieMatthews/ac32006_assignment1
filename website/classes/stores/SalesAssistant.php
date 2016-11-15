<?php

require_once( 'classes/exceptions/IllegalFormatException.php' );

require_once( 'classes/stores/AccountNumber.php' );
require_once( 'classes/stores/Person.php' );
require_once( 'classes/stores/SortCode.php' );

class SalesAssistant extends Person
{
  private $accountNumber;
  private $branchId;
  private $salesAssistantId;
  private $sortCode;
  private $wage;
  
  
  
  public function getAccountNumber() {
    return (string) $this->accountNumber;
  }
  
  
  
  public function getBranchId() {
    return $this->branchId;
  }
  
  
  
  public function getSalesAssistantId() {
	  return $this->salesAssistantId;
  }
  
  
  
  public function getSortCode() {
    return (string) $this->sortCode;
  }
  
  
  
  public function getWage() {
    return $this->wage;
  }
  
  
  
  public function setAccountNumber( $accountNumber ) {
    if ( $accountNumber == null ) {
      $this->accountNumber = null;
    }
    else {
      $this->accountNumber = new AccountNumber( $accountNumber );
    }
  }
  
  
  
  public function setBranchId( $branchId ) {
    if ( $branchId == null ) {
      $this->branchId = null;
    }
    else {
      $this->branchId = $branchId;
    }
  }
  
  
  
  public function setSalesAssistant( $salesAssistantId ) {
    if ( $salesAssistantId == null ) {
      $this->salesAssistantId = null;
    }
    else {
      $this->salesAssistantId = (int) $salesAssistantId;
    }
  }
  
  
  
  public function setSortCode( $sortCode ) {
    if ( $sortCode == null ) {
      $this->sortCode = null;
    }
    else {
      $this->sortCode = new SortCode( $sortCode );
    }
  }
  
  
  
  public function setWage( $wage ) {
    if ( $wage == null ) {
      $this->wage = null;
    }
    else {
      $this->wage = $wage;
    }
  }
}
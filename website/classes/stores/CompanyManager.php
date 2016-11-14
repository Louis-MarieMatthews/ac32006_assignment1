<?php

require_once( '/classes/stores/AccountNumber.php' );
require_once( '/classes/stores/Person.php' );
require_once( '/classes/stores/SortCode.php' );

class CompanyManager extends Person
{
  private $accountNumber;
  private $companyManagerId;
  private $sortCode;
  private $wage;
  
  
  
  public function getAccountNumber() {
    return (string) $this->accountNumber;
  }
  
  
  
  public function getCompanyManagerId() {
	  return $this->companyManagerId;
  }
  
  
  
  public function getSortCode() {
    return (string) $this->sortCode;
  }
  
  
  
  public function setAccountNumber( $accountNumber ) {
    if ( $accountNumber == null ) {
      $this->accountNumber = null;
    }
    else {
      $this->accountNumber = new AccountNumber( $accountNumber );
    }
  }
  
  
  
  public function setCompanyManagerId( $companyManagerId ) {
    if ( $companyManagerId == null ) {
      $this->companyManagerId = null;
    }
    else {
      $this->companyManagerId = (int) $companyManagerId;
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
<?php

session_start();

require_once( 'classes/BranchManagerUserModel.php' );
require_once( 'classes/CompanyManagerUserModel.php' );
require_once( 'classes/SalesAssistantUserModel.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

checkIfCompanyManager();

$branchManagers = BranchManagerUserModel::getAllBranchManagers();
displayPersons( $branchManagers, 'Branch Managers' );

$salesAssistants = SalesAssistantUserModel::getAllSalesAssistants();
displayPersons( $salesAssistants, 'Sales Assistants' );

$companyManagers = CompanyManagerUserModel::getAllCompanyManagers();
displayPersons( $companyManagers, 'Company Managers' );
<?php
session_start();

require_once( 'classes/BranchManagerUserModel.php' );
require_once( 'classes/CompanyManagerUserModel.php' );
require_once( 'classes/SalesAssistantUserModel.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

checkIfCompanyManager();
?>
<!doctype html>
<html>
  <head>
    <?php displayHead(); ?>
    <title>Employees of SportsScotland</title>
  </head>
  <body>
    <main>
      <?php
        $branchManagers = BranchManagerUserModel::getAllBranchManagers();
        displayPersons( $branchManagers, 'Branch Managers' );

        $salesAssistants = SalesAssistantUserModel::getAllSalesAssistants();
        displayPersons( $salesAssistants, 'Sales Assistants' );

        $companyManagers = CompanyManagerUserModel::getAllCompanyManagers();
        displayPersons( $companyManagers, 'Company Managers' );
      ?>
    </main>
  </body>
</html>
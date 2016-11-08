<?php
session_start();

require_once( 'classes/BranchManagerModel.php' );
require_once( 'classes/CompanyManagerModel.php' );
require_once( 'classes/SalesAssistantModel.php' );
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
        $branchManagers = BranchManagerModel::getAllBranchManagers();
        displayPersons( $branchManagers, 'Branch Managers' );

        $salesAssistants = SalesAssistantModel::getAllSalesAssistants();
        displayPersons( $salesAssistants, 'Sales Assistants' );

        $companyManagers = CompanyManagerModel::getAllCompanyManagers();
        displayPersons( $companyManagers, 'Company Managers' );
      ?>
    </main>
  </body>
</html>
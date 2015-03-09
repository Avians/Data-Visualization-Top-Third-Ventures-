<?php

//THIS CODE IS WRITTEN BY:
          //1. ATHIAS AVIANS (MATHEW JUMA), THE CHIEF AND CORE DEVELOPER OF ZILAS FRAMEWORK PROJECT.
          

/*
 * ---------------------------------------------------------------------
 * |                                                                   |
 * |  This the Index Model which is responsible responsible for        |
 * |  handling all logics that are related to the template Controller  |
 * |                                                                   |
 * ---------------------------------------------------------------------
 */

class Overview_statistics_Model extends Zf_Model {
    

   /*
    * --------------------------------------------------------------------------------------
    * |                                                                                    |
    * |  The is the main class constructor. It runs automatically within any class object  |
    * |                                                                                    |
    * --------------------------------------------------------------------------------------
    */
    public function __construct() {
        
         parent::__construct();
         
         
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO DASH CLIENTS.
     * 
     * =========================================================================
     */
    public function ClientInformation($accounts_filter = NULL){
        
        $selectColumn = array('accountType');
        
        if($accounts_filter == 'real_accounts'){
            
            $realAccount['accountType']  = Zf_QueryGenerator::SQLValue('Real');

            $getRealAccounts  = Zf_QueryGenerator::BuildSQLSelect('ttv_clientCompanies', $realAccount, $selectColumn);

            $executeRealAccounts   = $this->Zf_AdoDB->Execute($getRealAccounts);

            if (!$executeRealAccounts){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $realAccounts = $executeRealAccounts->RecordCount();

            }
            
            return $realAccounts;
            
            exit();
            
        }
        
        else if($accounts_filter == 'trial_accounts'){

            $trialAccount['accountType'] = Zf_QueryGenerator::SQLValue('Trial');

            $getTrialAccounts = Zf_QueryGenerator::BuildSQLSelect('ttv_clientCompanies', $trialAccount, $selectColumn);

            $executeTrialAccounts  = $this->Zf_AdoDB->Execute($getTrialAccounts);


            if (!$executeTrialAccounts){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $trialAccounts = $executeTrialAccounts->RecordCount();

            }
            
            return $trialAccounts;
            
            exit();
            
        }
        
        else{
            
            $selectColumn = array('id');
            
            $getAllAccounts = Zf_QueryGenerator::BuildSQLSelect('ttv_clientCompanies','',$selectColumn);

            $executeAllAccounts  = $this->Zf_AdoDB->Execute($getAllAccounts);


            if (!$executeAllAccounts){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $allAccounts = $executeAllAccounts->RecordCount();

            }
            
            return $allAccounts;
            
            exit();
            
        }
 
        
    }
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO DASH CLIENTS.
     * 
     * =========================================================================
     */
    public function MailingList($mail_list_filter = NULL){
        
        $selectColumn = array('confirmed');
        
        //Confirmed Mails
        if($mail_list_filter == 'confirmed'){
            
            $confirmedMails['confirmed']  = Zf_QueryGenerator::SQLValue(1);

            $getConfirmedMails  = Zf_QueryGenerator::BuildSQLSelect('ttv_newsLetterSubscriptions', $confirmedMails, $selectColumn);

            $executeConfirmedMails   = $this->Zf_AdoDB->Execute($getConfirmedMails);

            if (!$executeConfirmedMails){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $confirmedMails = $executeConfirmedMails->RecordCount();

            }
            
            return $confirmedMails;
            
            exit();
            
        }
        
        //Unconfirmed Mails
        else if($mail_list_filter == 'unconfirmed'){

            $unConfirmedMails['confirmed']  = Zf_QueryGenerator::SQLValue(0);

            $getUnConfirmedMails  = Zf_QueryGenerator::BuildSQLSelect('ttv_newsLetterSubscriptions', $unConfirmedMails, $selectColumn);

            $executeUnConfirmedMails   = $this->Zf_AdoDB->Execute($getUnConfirmedMails);

            if (!$executeUnConfirmedMails){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $unConfirmedMails = $executeUnConfirmedMails->RecordCount();

            }
            
            return $unConfirmedMails;
            
            exit();
            
        }
        
        //All Mails
        else{
            
            $selectColumn = array('id');
            
            $getAllMails = Zf_QueryGenerator::BuildSQLSelect('ttv_newsLetterSubscriptions','',$selectColumn);
            
            
            $executeAllMails  = $this->Zf_AdoDB->Execute($getAllMails);


            if (!$executeAllMails){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $allMails = $executeAllMails->RecordCount();

            }
            
            return $allMails;
            
            exit();
            
        }
 
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO DASH CLIENTS.
     * 
     * =========================================================================
     */
    public function DataRecords(){
        
        $selectColumn = array('id');
            
        $getAllCustomerRecords = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData','',$selectColumn);


        $executeAllCustomerRecords  = $this->Zf_AdoDB->Execute($getAllCustomerRecords);


        if (!$executeAllCustomerRecords){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $allRecords = $executeAllCustomerRecords->RecordCount();

        }

        return $allRecords;

        exit();

    }
    
}

?>


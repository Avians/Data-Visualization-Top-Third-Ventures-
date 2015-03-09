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

class Session_User_Details_Model extends Zf_Model {
    

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
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO USER COMPANY.
     * 
     * =========================================================================
     */
    public function ActiveCompanyInformation($info_filter = NULL){
        
       $identificationCodeArray = Zf_Core_Functions::Zf_DecodeIdentificationCode(Zf_SessionHandler::zf_getSessionVariable('ttv_identificationCode'));
        
       $companySerial = $identificationCodeArray[1];
       
       $zf_valueCompanySerial['companySerial'] = Zf_QueryGenerator::SQLValue($companySerial); 
       $zf_columnCompanyName = array('companyName', 'accountType');
       $zf_sqlSelectCompanyInformation = Zf_QueryGenerator::BuildSQLSelect('ttv_clientCompanies', $zf_valueCompanySerial, $zf_columnCompanyName);
       $zf_executeSelectCompanyInformation = $this->Zf_AdoDB->Execute($zf_sqlSelectCompanyInformation); 

       if(!$zf_executeSelectCompanyInformation){

           echo "<strong>Query Execution Failed:</strong> <code>".$this->Zf_AdoDB->ErrorMsg()."</code>";

       }else{
           
           if($info_filter == 'companyName'){

            return $zf_executeSelectCompanyInformation->fields['companyName']; exit();
            
           }
           
           if($info_filter == 'accountType'){

            return $zf_executeSelectCompanyInformation->fields['accountType']; exit();
            
           }

       }
          
 
    }
    
    
    
}

?>


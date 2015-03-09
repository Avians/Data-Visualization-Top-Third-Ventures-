<?php

//THIS CODE IS WRITTEN BY:
          //1. ATHIAS AVIANS (MATHEW JUMA), THE CHIEF AND CORE DEVELOPER OF ZILAS FRAMEWORK PROJECT.
          //2. ALLAN KIBET, DEVELOPMENT AND IMPLEMENTATION HEAD AT ZILAS FRAMEWORK PROJECT.

/*
 * ---------------------------------------------------------------------
 * |                                                                   |
 * |  This the Index Model which is responsible responsible for        |
 * |  handling all logics that are related to the template Controller  |
 * |                                                                   |
 * ---------------------------------------------------------------------
 */

class ActivateSign_up_Model extends Zf_Model {
    
   
    private $_errorResult = array();
    private $_validResult = array();

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
    
    
    
    public function processConfirmActivation($confirm_email){
        
        $zf_valueUserEmail['email'] = Zf_QueryGenerator::SQLValue($confirm_email); 
        $zf_columnIdentificationCode = array('identificationCode');
        $zf_sqlSelectIdentificationCode = Zf_QueryGenerator::BuildSQLSelect('ttv_applicationUsers', $zf_valueUserEmail, $zf_columnIdentificationCode);
        

        $zf_executeSelectIdentificationCode = $this->Zf_AdoDB->Execute($zf_sqlSelectIdentificationCode);


       // print "<pre>";print_r($zf_executeQuery->GetRows()); print "</pre>"; //This is strictly for debugging purpose.


        if (!$zf_executeSelectIdentificationCode){

            echo "<strong>Query Execution Failed:</strong> <code>".$this->Zf_AdoDB->ErrorMsg()."</code>";

        } else{
            
            $identificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($zf_executeSelectIdentificationCode->fields['identificationCode']);
            
            $zf_valueUserStatus['userStatus'] = Zf_QueryGenerator::SQLValue(1); 
            $zf_columnEmail['email'] = Zf_QueryGenerator::SQLValue($confirm_email);
            $zf_sqlConfirmUser = Zf_QueryGenerator::BuildSQLUpdate('ttv_applicationUsers', $zf_valueUserStatus, $zf_columnEmail);
            $zf_executeConfirmUser = $this->Zf_AdoDB->Execute($zf_sqlConfirmUser);
            
            $zf_valueCompanyStatus['companyStatus'] = Zf_QueryGenerator::SQLValue(1); 
            $zf_columnCompanySerial['companySerial'] = Zf_QueryGenerator::SQLValue($identificationCode[1]);
            $zf_sqlConfirmCompany = Zf_QueryGenerator::BuildSQLUpdate('ttv_clientCompanies', $zf_valueCompanyStatus, $zf_columnCompanySerial);
            $zf_executeConfirmCompany = $this->Zf_AdoDB->Execute($zf_sqlConfirmCompany);
            
            $zf_valueCountryStatus['countryStatus'] = Zf_QueryGenerator::SQLValue(1); 
            $zf_columnCountryCode['countryCode'] = Zf_QueryGenerator::SQLValue($identificationCode[0]);
            $zf_sqlConfirmCountry = Zf_QueryGenerator::BuildSQLUpdate('ttv_countries', $zf_valueCountryStatus, $zf_columnCountryCode);
            $zf_executeConfirmCountry = $this->Zf_AdoDB->Execute($zf_sqlConfirmCountry);
            
            $zf_valueCountryCode['countryCode'] = Zf_QueryGenerator::SQLValue($identificationCode[0]); 
            $zf_columnRegionName = array('regionName');
            $zf_sqlSelectRegionName = Zf_QueryGenerator::BuildSQLSelect('ttv_regions', $zf_valueCountryCode, $zf_columnRegionName);
            $zf_executeSelectRegionName = $this->Zf_AdoDB->Execute($zf_sqlSelectRegionName); 
            
            if(!$zf_executeSelectRegionName){
                
                echo "<strong>Query Execution Failed:</strong> <code>".$this->Zf_AdoDB->ErrorMsg()."</code>";
                
            }else{
                
                $regionName = $zf_executeSelectRegionName->fields['regionName'];
                
            }
            
            $zf_valueRegionStatus['regionStatus'] = Zf_QueryGenerator::SQLValue(1); 
            $zf_RegionName['regionName'] = Zf_QueryGenerator::SQLValue($regionName);
            $zf_sqlConfirmRegion = Zf_QueryGenerator::BuildSQLUpdate('ttv_regions', $zf_valueRegionStatus, $zf_RegionName);
            $zf_executeConfirmRegion = $this->Zf_AdoDB->Execute($zf_sqlConfirmRegion);
            
            
            if(!$zf_executeConfirmUser || !$zf_executeConfirmCompany || !$zf_executeConfirmCountry || !$zf_executeConfirmRegion){
                
                echo "<strong>Query Execution Failed:</strong> <code>".$this->Zf_AdoDB->ErrorMsg()."</code>";
                
            }else{
                
                Zf_SessionHandler::zf_setSessionVariable("Account_Sign_Up", "confirmed_email");
                Zf_GenerateLinks::zf_header_location("index", "sign_up");
                
            }         

        }
        
    }

}

?>

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

class General_statistics_Model extends Zf_Model {
    
    //This holds the session user details.
    private $sessionUser;
    

   /*
    * --------------------------------------------------------------------------------------
    * |                                                                                    |
    * |  The is the main class constructor. It runs automatically within any class object  |
    * |                                                                                    |
    * --------------------------------------------------------------------------------------
    */
    public function __construct() {
        
         parent::__construct();
         
         $this->sessionUser = Zf_SessionHandler::zf_getSessionVariable("ttv_identificationCode");
         
         
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO ALL HOUSEHOLDS.
     * 
     * =========================================================================
     */
    public function HouseHolds($dataFilter){
        
        $dataFilter = explode('_', $dataFilter);
        
        //$dataFilter[0] is the column name, while $dataFilter[1] is the target dataset
        $columnName = $dataFilter[0]; $dataSet = $dataFilter[1];
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $identificationCodeArray = Zf_Core_Functions::Zf_DecodeIdentificationCode($userIdentificationCode);
        
        //We now fetch all the relevant data based on the above selections.
        $selectColumn = array('id');
        
        if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
            
            $whereData[$columnName] = Zf_QueryGenerator::SQLValue($dataSet);
            $getAllCustomerRecords = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $whereData, $selectColumn);
            
        }else if($identificationCodeArray[4] == COMPANY_ADMIN){
            
            //If the data is being viewed by a company admin. (Normally determined by the company serial)
            $whereData[$columnName] = Zf_QueryGenerator::SQLValue($dataSet);
            $whereData['companySerial'] = Zf_QueryGenerator::SQLValue($identificationCodeArray[1]);
            
            $getAllCustomerRecords = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $whereData, $selectColumn);
            
        }else if($identificationCodeArray[4] == REGIONAL_MANAGER){
            
            //If the data is being viewed by a regional manager. (Normally determined by the regional_id).
            
        }else if($identificationCodeArray[4] == SHOP_MANAGER || $identificationCodeArray[4] == ASSISTANT_SHOP_MANAGER){
         
            //If the data is being viewed by Shop manager or assistant shop manager.(Normally,they share a shop_id)
         
        }else if($identificationCodeArray[4] == SALES_REPRESENTATIVE){
         
            //If the data is being viewed by a particular sales rep.(Normally, determined by the sales_rep_id)
            
        }
        

        $executeAllCustomerRecords  = $this->Zf_AdoDB->Execute($getAllCustomerRecords);


        if (!$executeAllCustomerRecords){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $allRecords = $executeAllCustomerRecords->RecordCount();

        }

        return $allRecords;

        exit();
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO ALL HOUSEHOLDS.
     * 
     * =========================================================================
     */
    public function AllChildren($dataFilter){
        
        $dataFilter = explode('_', $dataFilter);
        
        //$dataFilter[0] is the column name, while $dataFilter[1] is the target dataset
        $columnName = $dataFilter[0]; $dataSet = $dataFilter[1];
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $identificationCodeArray = Zf_Core_Functions::Zf_DecodeIdentificationCode($userIdentificationCode);
        
        if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
            
            $getAllChildren   = "SELECT SUM(totalChildren) AS allchildren FROM ttv_customerData WHERE $columnName = '$dataSet' ";
            
        }else if($identificationCodeArray[4] == COMPANY_ADMIN){
            
            //If the data is being viewed by a company admin. (Normally determined by the company serial)
            $getAllChildren   = "SELECT SUM(totalChildren) AS allchildren FROM ttv_customerData WHERE $columnName = '$dataSet' AND companySerial = '$identificationCodeArray[1]' ";
            
        }else if($identificationCodeArray[4] == REGIONAL_MANAGER){
            
            //If the data is being viewed by a regional manager. (Normally determined by the regional_id).
            
        }else if($identificationCodeArray[4] == SHOP_MANAGER || $identificationCodeArray[4] == ASSISTANT_SHOP_MANAGER){
         
            //If the data is being viewed by Shop manager or assistant shop manager.(Normally,they share a shop_id)
         
        }else if($identificationCodeArray[4] == SALES_REPRESENTATIVE){
         
            //If the data is being viewed by a particular sales rep.(Normally, determined by the sales_rep_id)
            
        }

        $executeAllChildren  = $this->Zf_AdoDB->Execute($getAllChildren);


        if (!$executeAllChildren){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $allChildren = $executeAllChildren->fields['allchildren'];

        }

        return $allChildren;

        exit();
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO ALL HOUSEHOLDS.
     * 
     * =========================================================================
     */
    public function ChildrenUnderFive($dataFilter){
        
        $dataFilter = explode('_', $dataFilter);
        
        //$dataFilter[0] is the column name, while $dataFilter[1] is the target dataset
        $columnName = $dataFilter[0]; $dataSet = $dataFilter[1];
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $identificationCodeArray = Zf_Core_Functions::Zf_DecodeIdentificationCode($userIdentificationCode);
        
        
        if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
            
            $getChildrenUnderFive = "SELECT SUM(childrenUnderFive) AS childrenUnderFive FROM ttv_customerData WHERE $columnName = '$dataSet'";
            
        }else if($identificationCodeArray[4] == COMPANY_ADMIN){
            
            //If the data is being viewed by a company admin. (Normally determined by the company serial)
            $getChildrenUnderFive = "SELECT SUM(childrenUnderFive) AS childrenUnderFive FROM ttv_customerData WHERE $columnName = '$dataSet' AND companySerial = '$identificationCodeArray[1]' ";
            
        }else if($identificationCodeArray[4] == REGIONAL_MANAGER){
            
            //If the data is being viewed by a regional manager. (Normally determined by the regional_id).
            
        }else if($identificationCodeArray[4] == SHOP_MANAGER || $identificationCodeArray[4] == ASSISTANT_SHOP_MANAGER){
         
            //If the data is being viewed by Shop manager or assistant shop manager.(Normally,they share a shop_id)
         
        }else if($identificationCodeArray[4] == SALES_REPRESENTATIVE){
         
            //If the data is being viewed by a particular sales rep.(Normally, determined by the sales_rep_id)
            
        }

        $executeChildrenUnderFive  = $this->Zf_AdoDB->Execute($getChildrenUnderFive );


        if (!$executeChildrenUnderFive){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $childrenUnderFive = $executeChildrenUnderFive->fields['childrenUnderFive'];

        }

        return $childrenUnderFive;

        exit();
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO ALL HOUSEHOLDS.
     * 
     * =========================================================================
     */
    public function AllBenefactors($dataFilter){
        
        $dataFilter = explode('_', $dataFilter);
        
        //$dataFilter[0] is the column name, while $dataFilter[1] is the target dataset
        $columnName = $dataFilter[0]; $dataSet = $dataFilter[1];
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $identificationCodeArray = Zf_Core_Functions::Zf_DecodeIdentificationCode($userIdentificationCode);
        
        
        if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
            
            $getAllBenefactors = "SELECT SUM(totalBenefactors) AS allBenefactors FROM ttv_customerData WHERE $columnName = '$dataSet'";
            
        }else if($identificationCodeArray[4] == COMPANY_ADMIN){
            
            //If the data is being viewed by a company admin. (Normally determined by the company serial)
            $getAllBenefactors = "SELECT SUM(totalBenefactors) AS allBenefactors FROM ttv_customerData WHERE $columnName = '$dataSet' AND companySerial = '$identificationCodeArray[1]' ";
            
        }else if($identificationCodeArray[4] == REGIONAL_MANAGER){
            
            //If the data is being viewed by a regional manager. (Normally determined by the regional_id).
            
        }else if($identificationCodeArray[4] == SHOP_MANAGER || $identificationCodeArray[4] == ASSISTANT_SHOP_MANAGER){
         
            //If the data is being viewed by Shop manager or assistant shop manager.(Normally,they share a shop_id)
         
        }else if($identificationCodeArray[4] == SALES_REPRESENTATIVE){
         
            //If the data is being viewed by a particular sales rep.(Normally, determined by the sales_rep_id)
            
        }
        
        $executeAllBenefactors  = $this->Zf_AdoDB->Execute($getAllBenefactors );


        if (!$executeAllBenefactors){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $allBenefactors = $executeAllBenefactors->fields['allBenefactors'];

        }

        return $allBenefactors;

        exit();
        
    }
    
    
    
}

?>


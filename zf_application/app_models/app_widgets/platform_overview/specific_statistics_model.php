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

class Specific_statistics_Model extends Zf_Model {
    

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
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO ALL HOUSEHOLDS.
     * 
     * =========================================================================
     */
    public function HouseHolds($identificationCodeArray){
        
        //print_r($identificationCodeArray); exit(); //This is specifically for debugging purpose.
        
        $selectColumn = array('id');
        
        if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
            
            $getAllCustomerRecords = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData','',$selectColumn);
            
        }else if($identificationCodeArray[4] == COMPANY_ADMIN){
            
            //If the data is being viewed by a company admin. (Normally determined by the company serial)
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
    public function AllChildren($identificationCodeArray){

        
        if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
            
            $getAllChildren   = "SELECT SUM(totalChildren) AS allchildren FROM ttv_customerData";
            
        }else if($identificationCodeArray[4] == COMPANY_ADMIN){
            
            //If the data is being viewed by a company admin. (Normally determined by the company serial)
            $getAllChildren   = "SELECT SUM(totalChildren) AS allchildren FROM ttv_customerData WHERE companySerial = '$identificationCodeArray[1]' ";
            
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
    public function ChildrenUnderFive($identificationCodeArray){
        
        if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
            
            $getChildrenUnderFive = "SELECT SUM(childrenUnderFive) AS childrenUnderFive FROM ttv_customerData";
            
        }else if($identificationCodeArray[4] == COMPANY_ADMIN){
            
            //If the data is being viewed by a company admin. (Normally determined by the company serial)
            $getChildrenUnderFive = "SELECT SUM(childrenUnderFive) AS childrenUnderFive FROM ttv_customerData WHERE companySerial = '$identificationCodeArray[1]' ";
            
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
    public function AllBenefactors($identificationCodeArray){
        
        if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
            
            $getAllBenefactors = "SELECT SUM(totalBenefactors) AS allBenefactors FROM ttv_customerData";
            
        }else if($identificationCodeArray[4] == COMPANY_ADMIN){
            
            //If the data is being viewed by a company admin. (Normally determined by the company serial)
            $getAllBenefactors = "SELECT SUM(totalBenefactors) AS allBenefactors FROM ttv_customerData WHERE companySerial = '$identificationCodeArray[1]' ";
            
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


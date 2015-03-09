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

class IncomeInformationProcessor_Model extends Zf_Model {
    
    
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
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO AGE DISTRIBUTION.
     * =========================================================================
     */
    public function AnnualIncome(){
        
        $dataRange = $_POST['ageRange'];
        
        //echo $dataRange; exit();
        
        $ageRange = explode(";", $dataRange);
        
        $table = "ttv_customerData";
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
       
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getIncome5000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='0-5000' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome10000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='5001-10000' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome20000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='10001-20000' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='20001-50000' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50001 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='50001+' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){
            
            $getIncome5000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='0-5000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome10000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='5001-10000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome20000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='10001-20000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='20001-50000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50001 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='50001 +' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){
            
            $getIncome5000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='0-5000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome10000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='5001-10000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome20000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='10001-20000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50000 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='20001-50000' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getIncome50001 = "SELECT * FROM " . $table . " WHERE monthlyIncome ='50001 +' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $executeIncome5000  = $this->Zf_AdoDB->Execute($getIncome5000);
        $executeIncome10000 = $this->Zf_AdoDB->Execute($getIncome10000);
        $executeIncome20000 = $this->Zf_AdoDB->Execute($getIncome20000);
        $executeIncome50000 = $this->Zf_AdoDB->Execute($getIncome50000);
        $executeIncome50001 = $this->Zf_AdoDB->Execute($getIncome50001);
        
        //echo $executeIncome50001; exit();
        
        if (!$executeIncome5000){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income5000Count = $executeIncome5000->RecordCount();
            
        }
 
        if (!$executeIncome10000){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income10000Count = $executeIncome10000->RecordCount();
            
        }
 
        if (!$executeIncome20000){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income20000Count = $executeIncome20000->RecordCount();
            
        }
 
        if (!$executeIncome50000){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income50000Count = $executeIncome50000->RecordCount();
            
        }
 
        if (!$executeIncome50001){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $income50001Count = $executeIncome50001->RecordCount();
            
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
                canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='Annual Income' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM' >";
        $strXML .= "<set label='0 - 60K' value=' ".$income5000Count." ' tooltext='Annual salary below 60,001 (Kshs){br}Total count:  ".$income5000Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/0-5000/'.$dataRange)." '/>";
        $strXML .= "<set label='60K - 120K' value=' ".$income10000Count." ' tooltext=' Annual salary between 60,001 - 120,000 (Kshs){br}Total count:  ".$income10000Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/5001-10000/'.$dataRange)." '/>";
        $strXML .= "<set label='120K - 240K' value=' ".$income20000Count." ' tooltext=' Annual salary between 120,001 - 240,000 (Kshs){br}Total count:  ".$income20000Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/10001-20000/'.$dataRange)." '/>";
        $strXML .= "<set label='240K - 600K' value=' ".$income50000Count." ' tooltext=' Annual salary between 240,001 - 600,000 (Kshs){br}Total count:  ".$income50000Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/20001-50000/'.$dataRange)." '/>";
        $strXML .= "<set label='Above 600K' value=' ".$income50001Count." ' tooltext=' Annual salary above 600,001 (Kshs){br}Total count:  ".$income50001Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/50001 +/'.$dataRange)." '/>";
        $strXML .= "
                    <styles>
                        <definition>
                              <style name='myToolTipFont' type='font' font='ProximaNova-Light' size='11' color='87b6d9'/>
                        </definition>
                        <application>
                              <apply toObject='ToolTip' styles='myToolTipFont' />
                        </application>
                    </styles> 

                   ";
        $strXML .= "</chart>";

        $zf_chartData = array(

            "chartData"         => "$strXML",
            "chartType"         => "Pie2D",
            "chartId"           => "customerAnnualIncome",
            "chartWidth"        => "100%",
            "chartHeight"       => 280,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
 
        
    }
    

}

?>


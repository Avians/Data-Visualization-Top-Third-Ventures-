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

class MaritalInformationProcessor_Model extends Zf_Model {
    
    
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
    public function MaritalStatus(){
        
        $dataRange = $_POST['ageRange'];
        
        $ageRange = explode(";", $dataRange);
        
        $table = "ttv_customerData";
        
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
       
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getSingle = "SELECT * FROM " . $table . " WHERE maritalStatus ='Single' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getMarried = "SELECT * FROM " . $table . " WHERE maritalStatus ='Married' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDivorced = "SELECT * FROM " . $table . " WHERE maritalStatus ='Divorced' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getWidowed = "SELECT * FROM " . $table . " WHERE maritalStatus ='Widowed' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){
            
            $getSingle = "SELECT * FROM " . $table . " WHERE maritalStatus ='Single' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getMarried = "SELECT * FROM " . $table . " WHERE maritalStatus ='Married' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDivorced = "SELECT * FROM " . $table . " WHERE maritalStatus ='Divorced'  AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getWidowed = "SELECT * FROM " . $table . " WHERE maritalStatus ='Widowed'  AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getSingle = "SELECT * FROM " . $table . " WHERE maritalStatus ='Single'  AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND  age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getMarried = "SELECT * FROM " . $table . " WHERE maritalStatus ='Married'  AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND  age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getDivorced = "SELECT * FROM " . $table . " WHERE maritalStatus ='Divorced'  AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND  age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getWidowed = "SELECT * FROM " . $table . " WHERE maritalStatus ='Widowed'  AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND  age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $executeSingle   = $this->Zf_AdoDB->Execute($getSingle);
        $executeMarried   = $this->Zf_AdoDB->Execute($getMarried);
        $executeDivorced   = $this->Zf_AdoDB->Execute($getDivorced);
        $executeWidowed   = $this->Zf_AdoDB->Execute($getWidowed);
        
        if (!$executeSingle){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $singleCount = $executeSingle->RecordCount();
            
        }
 
        if (!$executeMarried){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $marriedCount = $executeMarried->RecordCount();
            
        }
 
        if (!$executeDivorced){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $divorcedCount = $executeDivorced->RecordCount();
            
        }
 
        if (!$executeWidowed){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $widowedCount = $executeWidowed->RecordCount();
            
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM' >";
        $strXML .= "<set label='Single' value=' ".$singleCount." ' tooltext=' Singles count: ".$singleCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'marital_data/sinlge/'.$dataRange)." ' />";
        $strXML .= "<set label='Married' value=' ".$marriedCount." ' tooltext=' Married count: ".$marriedCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'marital_data/married/'.$dataRange)." ' />";
        $strXML .= "<set label='Divorced' value=' ".$divorcedCount." ' tooltext=' Divorced count: ".$divorcedCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'marital_data/divorced/'.$dataRange)." ' />";
        $strXML .= "<set label='Widowed' value=' ".$widowedCount." ' tooltext=' Widowed count: ".$widowedCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'marital_data/widowed/'.$dataRange)." ' />";
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
            "chartId"           => "customerMaritalStatus",
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


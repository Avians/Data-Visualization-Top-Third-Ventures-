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

class GenderInformationProcessor_Model extends Zf_Model {
    
    
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
    public function GenderRatio(){
        
        $dataRange = $_POST['ageRange'];
        
        $ageRange = explode(";", $dataRange);
        
        $table = "ttv_customerData";
        
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
       
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getMaleCustomers = "SELECT * FROM " . $table . " WHERE gender ='Male' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getFemaleCustomers = "SELECT * FROM " . $table . " WHERE gender ='Female' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){

            $getMaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='male' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getFemaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='female' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getMaleCustomers = "SELECT * FROM " . $table . " WHERE gender ='male' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();
            $getFemaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='female' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $executeMaleCustomers   = $this->Zf_AdoDB->Execute($getMaleCustomers);
        $executeFemaleCustomers = $this->Zf_AdoDB->Execute($getFemaleCustomers);
        
        if (!$executeMaleCustomers){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $maleCount = $executeMaleCustomers->RecordCount();
            
        }
        
        if (!$executeFemaleCustomers){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
            
            $femaleCount = $executeFemaleCustomers->RecordCount();
            
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='Gender' yAxisName='Total Count' showValues='1' formatNumberScale='0' palette='1'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM'
            paletteColors='ffb848,28b779' paletteThemeColor='ffb848' showToolTip='1' showToolTipShadow='1'>";
        $strXML .= "<set label='Male' value=' ".$maleCount." ' tooltext=' Total male count: ".$maleCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'gender_data/male/'.$dataRange)." ' />";
        $strXML .= "<set label='Female' value=' ".$femaleCount." ' tooltext='Total female count: ".$femaleCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'gender_data/female/'.$dataRange)." ' />";
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
            "chartId"           => "customerGender",
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


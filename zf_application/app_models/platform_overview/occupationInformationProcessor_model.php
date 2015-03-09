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

class OccupationInformationProcessor_Model extends Zf_Model {
    
    
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
    public function Occupation($genderFilter){
            
        $others['occupation']   = Zf_QueryGenerator::SQLValue("Others");
        $farmer['occupation']  = Zf_QueryGenerator::SQLValue("Farmer");
        $shopOwner['occupation'] = Zf_QueryGenerator::SQLValue("Shop Owner");
        $professional['occupation']  = Zf_QueryGenerator::SQLValue("Professional");
        
        if($genderFilter != "all"){
            $others['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
            $farmer['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
            $shopOwner['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
            $professional['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
        }
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        if($decodedIdentificationCode[4] == COMPANY_ADMIN){
        
                $others['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $farmer['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $shopOwner['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $professional['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER ||$decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){
 
                $others['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $others['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                
                $farmer['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $farmer['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                
                $shopOwner['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $shopOwner['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                
                $professional['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $professional['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

        }
        
        $selectColumns = array('occupation');
        
            
        $getOthers       = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $others, $selectColumns);
        $getFarmer       = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $farmer, $selectColumns);
        $getShopOwner    = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $shopOwner, $selectColumns);
        $getProfessional = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $professional, $selectColumns);
        
        $executeOthers       = $this->Zf_AdoDB->Execute($getOthers);
        $executeFarmer       = $this->Zf_AdoDB->Execute($getFarmer);
        $executeShopOwner    = $this->Zf_AdoDB->Execute($getShopOwner);
        $executeProfessional = $this->Zf_AdoDB->Execute($getProfessional);
        
        if (!$executeOthers){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $othersCount = $executeOthers->RecordCount();
            
        }
 
        if (!$executeFarmer){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $farmerCount = $executeFarmer->RecordCount();
            
        }
 
        if (!$executeShopOwner){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $shopOwnerCount = $executeShopOwner->RecordCount();
            
        }
 
        if (!$executeProfessional){
            
            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            
        }else{
                
            $professionalCount = $executeProfessional->RecordCount();
            
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM' >";
        $strXML .= "<set label='Others' value=' ".$othersCount." ' tooltext=' Others count: ".$othersCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'occupation_data/other/'.$genderFilter)." '/>";
        $strXML .= "<set label='Farmers' value=' ".$farmerCount." ' tooltext=' Farmers count: ".$farmerCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'occupation_data/farmer/'.$genderFilter)." '/>";
        $strXML .= "<set label='Shop Owners' value=' ".$shopOwnerCount." ' tooltext=' Shop owners count: ".$shopOwnerCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'occupation_data/shop owner/'.$genderFilter)." '/>";
        $strXML .= "<set label='Professional' value=' ".$professionalCount." ' tooltext=' Professionals count: ".$professionalCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'occupation_data/professional/'.$genderFilter)." '/>";
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
            "chartId"           => "customerOccupation",
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


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

class AgeInformationProcessor_Model extends Zf_Model {
    
    
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
    public function AgeDistribution($genderFilter){
            
            $age25['ageBracket'] = Zf_QueryGenerator::SQLValue("18-25");
            $age35['ageBracket'] = Zf_QueryGenerator::SQLValue("26-35");
            $age50['ageBracket'] = Zf_QueryGenerator::SQLValue("36-50");
            $age51['ageBracket'] = Zf_QueryGenerator::SQLValue("51 +");
            if($genderFilter != "all"){
                $age25['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
                $age35['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
                $age50['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
                $age51['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
            }


            //Here we explicitly specify the selection rule using the user session details
            $userIdentificationCode = $this->sessionUser;
            $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);

            if($decodedIdentificationCode[4] == COMPANY_ADMIN){

                    $age25['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                    $age35['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                    $age50['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                    $age51['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

            }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER ||$decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

                    $age25['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                    $age25['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                    $age35['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                    $age35['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                    $age50['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                    $age50['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                    $age51['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                    $age51['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

            }

            $selectColumns = array('ageBracket');


            $getAge25 = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $age25, $selectColumns);
            $getAge35 = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $age35, $selectColumns);
            $getAge50 = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $age50, $selectColumns);
            $getAge51 = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $age51, $selectColumns);

            //echo $getAge25; exit();

            $executeAge25   = $this->Zf_AdoDB->Execute($getAge25);
            $executeAge35   = $this->Zf_AdoDB->Execute($getAge35);
            $executeAge50   = $this->Zf_AdoDB->Execute($getAge50);
            $executeAge51   = $this->Zf_AdoDB->Execute($getAge51);

            if (!$executeAge25){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $age25Count = $executeAge25->RecordCount();

            }

            if (!$executeAge35){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $age35Count = $executeAge35->RecordCount();

            }

            if (!$executeAge50){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $age50Count = $executeAge50->RecordCount();

            }

            if (!$executeAge51){

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            }else{

                $age51Count = $executeAge51->RecordCount();

            }

            $strXML  = "";
            $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
                canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
                xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
                paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
                showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM' >";
            $strXML .= "<set label='18 - 25' value=' ".$age25Count." ' tooltext=' Age brackets 18 - 25 years{br}Total count: ".$age25Count." people,{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'age_data/18-25/'.$genderFilter)." ' />";
            $strXML .= "<set label='26 - 35' value=' ".$age35Count." ' tooltext=' Age brackets 26 - 35 years{br}Total count: ".$age35Count." people,{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'age_data/26-35/'.$genderFilter)." ' />";
            $strXML .= "<set label='36 - 50' value=' ".$age50Count." ' tooltext=' Age brackets 36 -50 years{br}Total count: ".$age50Count." people,{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'age_data/36-50/'.$genderFilter)." ' />";
            $strXML .= "<set label='51+' value=' ".$age51Count." ' tooltext=' Age brackets over 50 years{br}Total count: ".$age51Count." people,{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'age_data/51 +/'.$genderFilter)." ' />";
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
                "chartId"           => "customerAge",
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


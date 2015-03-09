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

class EducationInformationProcessor_Model extends Zf_Model {
    
    
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
    public function EducationLevel($genderFilter){
            
        $none['educationLevel']       = Zf_QueryGenerator::SQLValue("none");
        $primary['educationLevel']    = Zf_QueryGenerator::SQLValue("primary");
        $secondary['educationLevel']  = Zf_QueryGenerator::SQLValue("secondary");
        $diploma['educationLevel']    = Zf_QueryGenerator::SQLValue("diploma");
        $university['educationLevel'] = Zf_QueryGenerator::SQLValue("university");

        if($genderFilter != "all"){
            $none['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
            $primary['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
            $secondary['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
            $diploma['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
            $university['gender'] = Zf_QueryGenerator::SQLValue($genderFilter);
        }

        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);

        if($decodedIdentificationCode[4] == COMPANY_ADMIN){

                $none['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $primary['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $secondary['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $diploma['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $university['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER ||$decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

                $none['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $none['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                $primary['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $primary['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                $secondary['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $secondary['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                $diploma['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $diploma['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                $university['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $university['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
        }

        $selectColumns = array('educationLevel');

        $getNone       = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $none, $selectColumns);
        $getPrimary    = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $primary, $selectColumns);
        $getSecondary  = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $secondary, $selectColumns);
        $getDiploma    = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $diploma, $selectColumns);
        $getUniversity = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $university, $selectColumns);

        $executeNone         = $this->Zf_AdoDB->Execute($getNone);
        $executePrimary      = $this->Zf_AdoDB->Execute($getPrimary);
        $executeSecondary    = $this->Zf_AdoDB->Execute($getSecondary);
        $executeDiploma      = $this->Zf_AdoDB->Execute($getDiploma);
        $executeUniversity   = $this->Zf_AdoDB->Execute($getUniversity);

        if (!$executeNone){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $noneCount = $executeNone->RecordCount();

        }


        if (!$executePrimary){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $primaryCount = $executePrimary->RecordCount();

        }


        if (!$executeSecondary){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $secondaryCount = $executeSecondary->RecordCount();

        }


        if (!$executeDiploma){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $diplomaCount = $executeDiploma->RecordCount();

        }


        if (!$executeUniversity){

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

        }else{

            $universityCount = $executeUniversity->RecordCount();

        }



        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM' >";
        $strXML .= "<set label='None' value=' ".$noneCount." ' tooltext=' None count: ".$noneCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/none/'.$genderFilter)." ' />";
        $strXML .= "<set label='Primary' value=' ".$primaryCount." ' tooltext=' Primary count: ".$primaryCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/primary/'.$genderFilter)." '/>";
        $strXML .= "<set label='Secondary' value=' ".$secondaryCount." '  tooltext=' Secondary count: ".$secondaryCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/secondary/'.$genderFilter)." '/>";
        $strXML .= "<set label='Diploma' value=' ".$diplomaCount." '  tooltext=' Diploma count: ".$diplomaCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/diploma/'.$genderFilter)." ' />";
        $strXML .= "<set label='University' value=' ".$universityCount." '  tooltext=' University count: ".$universityCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/university/'.$genderFilter)." '/>";
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
            "chartId"           => "customerEducation",
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


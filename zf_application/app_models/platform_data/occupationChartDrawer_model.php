<?php

//THIS CODE IS WRITTEN BY:
          //1. ATHIAS AVIANS (MATHEW JUMA), THE CHIEF AND CORE DEVELOPER OF ZILAS FRAMEWORK PROJECT.
          

/*
 * ---------------------------------------------------------------------
 * |                                                                   |
 * |  This the Index Model which is responsible responsible for        |
 * |  hANDling all logics that are related to the template Controller  |
 * |                                                                   |
 * ---------------------------------------------------------------------
 */

class OccupationChartDrawer_Model extends Zf_Model {
    
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
    public function GenderRatio($dataFilter){
        
        $dataRange = explode("_", $dataFilter);
        
        $occupation = $dataRange[0]; $gender = ucfirst($dataRange[1]);
        
        
        if($gender == "All"){
            
            $maleCustomers['gender'] = Zf_QueryGenerator::SQLValue("Male");
            $maleCustomers['occupation'] = Zf_QueryGenerator::SQLValue($occupation);
            
            $femaleCustomers['gender'] = Zf_QueryGenerator::SQLValue("Female");
            $femaleCustomers['occupation'] = Zf_QueryGenerator::SQLValue($occupation);
                      
        }else if($gender == "Male"){
            
            $maleCustomers['gender'] = Zf_QueryGenerator::SQLValue($gender);
            $maleCustomers['occupation'] = Zf_QueryGenerator::SQLValue($occupation);
                      
        }else if($gender == "Female"){
            
            $femaleCustomers['gender'] = Zf_QueryGenerator::SQLValue($gender);
            $femaleCustomers['occupation'] = Zf_QueryGenerator::SQLValue($occupation);
            
        }
        
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        if($decodedIdentificationCode[4] == COMPANY_ADMIN){
        
                $maleCustomers['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $femaleCustomers['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER ||$decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){
 
                $maleCustomers['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $maleCustomers['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                $femaleCustomers['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $femaleCustomers['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
            
        }
        
        $selectColumns = array('gender');
        
        
        if($gender == "All"){
            
            $getMaleCustomers   = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $maleCustomers, $selectColumns);
            $getFemaleCustomers = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $femaleCustomers, $selectColumns);
            
            $executeMaleCustomers = $this->Zf_AdoDB->Execute($getMaleCustomers);
            $executeFemaleCustomers = $this->Zf_AdoDB->Execute($getFemaleCustomers);

            if (!$executeMaleCustomers) {

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            } else {

                $maleCount = $executeMaleCustomers->RecordCount();
            }

            if (!$executeFemaleCustomers) {

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
            } else {

                $femaleCount = $executeFemaleCustomers->RecordCount();
            }

            if ($maleCount == 0 && $femaleCount == 0) {

                echo "<div class='no-loading-data'>No matching data to load</div>";
                exit();
            }

            $strXML = "";
            $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='Gender' yAxisName='Total Count' showValues='1' formatNumberScale='0' palette='1'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM'
            paletteColors='ffb848,28b779' paletteThemeColor='ffb848' showToolTip='1' showToolTipShadow='1'>";
            $strXML .= "<set label='Male' value=' " . $maleCount . " ' tooltext=' Total male count: " . $maleCount . ",{br}Click for a detailed{br}information '  link=' ' />";
            $strXML .= "<set label='Female' value=' " . $femaleCount . " ' tooltext='Total female count: " . $femaleCount . ",{br}Click for a detailed{br}information '  link=' ' />";
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
                "chartData" => "$strXML",
                "chartType" => "Pie2D",
                "chartId" => "customerGender",
                "chartWidth" => "100%",
                "chartHeight" => 280,
                "chartDebug" => "false",
                "registerJavacript" => "true",
                "chartTransparency" => ""
            );
            
        }else if($gender == "Male"){
            
            $getMaleCustomers   = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $maleCustomers, $selectColumns);
            
            $executeMaleCustomers = $this->Zf_AdoDB->Execute($getMaleCustomers);

            if (!$executeMaleCustomers) {

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
                
            } else {

                $maleCount = $executeMaleCustomers->RecordCount();
            }

            if ($maleCount == 0 ) {

                echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
                
            }

            $strXML = "";
            $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='Gender' yAxisName='Total Count' showValues='1' formatNumberScale='0' palette='1'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM'
            paletteColors='ffb848,28b779' paletteThemeColor='ffb848' showToolTip='1' showToolTipShadow='1'>";
            $strXML .= "<set label='Male' value=' " . $maleCount . " ' tooltext=' Total male count: " . $maleCount . ",{br}Click for a detailed{br}information '  link=' ' />";
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
                "chartData" => "$strXML",
                "chartType" => "Pie2D",
                "chartId" => "customerGender",
                "chartWidth" => "100%",
                "chartHeight" => 280,
                "chartDebug" => "false",
                "registerJavacript" => "true",
                "chartTransparency" => ""
            );
            
        }else if($gender == "Female"){
            
            $getFemaleCustomers = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $femaleCustomers, $selectColumns);
            
            $executeFemaleCustomers = $this->Zf_AdoDB->Execute($getFemaleCustomers);

            if (!$executeFemaleCustomers) {

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
                
            } else {

                $femaleCount = $executeFemaleCustomers->RecordCount();
            }

            $strXML = "";
            $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='Gender' yAxisName='Total Count' showValues='1' formatNumberScale='0' palette='1'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM'
            paletteColors='ffb848,28b779' paletteThemeColor='ffb848' showToolTip='1' showToolTipShadow='1'>";
            $strXML .= "<set label='Female' value=' " . $femaleCount . " ' tooltext='Total female count: " . $femaleCount . ",{br}Click for a detailed{br}information '  link=' ' />";
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
                "chartData" => "$strXML",
                "chartType" => "Pie2D",
                "chartId" => "customerGender",
                "chartWidth" => "100%",
                "chartHeight" => 280,
                "chartDebug" => "false",
                "registerJavacript" => "true",
                "chartTransparency" => ""
            );
            
        }
        
        

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
 
        
    }
    
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO AGE DISTRIBUTION.
     * =========================================================================
     */
    public function AgeDistribution($dataFilter){
        
        $dataRange = explode("_", $dataFilter);
        
        $occupation = $dataRange[0]; $gender = ucfirst($dataRange[1]);
        
        $age25['ageBracket'] = Zf_QueryGenerator::SQLValue("18-25");
        $age35['ageBracket'] = Zf_QueryGenerator::SQLValue("26-35");
        $age50['ageBracket'] = Zf_QueryGenerator::SQLValue("36-50");
        $age51['ageBracket'] = Zf_QueryGenerator::SQLValue("51 +");
        
        if ($gender == "All") {
            
            $age25['occupation'] = Zf_QueryGenerator::SQLValue($occupation);
            $age35['occupation'] = Zf_QueryGenerator::SQLValue($occupation);
            $age50['occupation'] = Zf_QueryGenerator::SQLValue($occupation);
            $age51['occupation'] = Zf_QueryGenerator::SQLValue($occupation);
            
        }else if($gender == "Male" || $gender == "Female"){
            
            $age25['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $age25['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $age35['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $age35['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $age50['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $age50['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $age51['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $age51['gender']   = Zf_QueryGenerator::SQLValue($gender);
                      
        }


        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);

        if ($decodedIdentificationCode[4] == COMPANY_ADMIN) {

            $age25['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
            $age35['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
            $age50['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
            $age51['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
        } else if ($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER) {

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

        $executeAge25 = $this->Zf_AdoDB->Execute($getAge25);
        $executeAge35 = $this->Zf_AdoDB->Execute($getAge35);
        $executeAge50 = $this->Zf_AdoDB->Execute($getAge50);
        $executeAge51 = $this->Zf_AdoDB->Execute($getAge51);

        if (!$executeAge25) {

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
        } else {

            $age25Count = $executeAge25->RecordCount();
        }

        if (!$executeAge35) {

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
        } else {

            $age35Count = $executeAge35->RecordCount();
        }

        if (!$executeAge50) {

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
        } else {

            $age50Count = $executeAge50->RecordCount();
        }

        if (!$executeAge51) {

            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
        } else {

            $age51Count = $executeAge51->RecordCount();
        }

        $strXML = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
                canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
                xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
                paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
                showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='BOTTOM' >";
        $strXML .= "<set label='18 - 25' value=' " . $age25Count . " ' tooltext=' Age brackets 18 - 25 years{br}Total count: " . $age25Count . " people,{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='26 - 35' value=' " . $age35Count . " ' tooltext=' Age brackets 26 - 35 years{br}Total count: " . $age35Count . " people,{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='36 - 50' value=' " . $age50Count . " ' tooltext=' Age brackets 36 -50 years{br}Total count: " . $age50Count . " people,{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='51+' value=' " . $age51Count . " ' tooltext=' Age brackets over 50 years{br}Total count: " . $age51Count . " people,{br}Click for a detailed{br}information '  link=' ' />";
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
            "chartData" => "$strXML",
            "chartType" => "Pie2D",
            "chartId" => "customerAge",
            "chartWidth" => "100%",
            "chartHeight" => 280,
            "chartDebug" => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""
        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
        
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO EDUCATION LEVEL.
     * =========================================================================
     */
    public function EducationLevel($dataFilter){
        
        $dataRange = explode("_", $dataFilter);
        
        $occupation = $dataRange[0]; $gender = ucfirst($dataRange[1]);
        
        $none['educationLevel']       = Zf_QueryGenerator::SQLValue("none");
        $primary['educationLevel']    = Zf_QueryGenerator::SQLValue("primary");
        $secondary['educationLevel']  = Zf_QueryGenerator::SQLValue("secondary");
        $diploma['educationLevel']    = Zf_QueryGenerator::SQLValue("diploma");
        $university['educationLevel'] = Zf_QueryGenerator::SQLValue("university");
        
        if($gender == "All"){
            
            $none['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $primary['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $secondary['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $diploma['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $university['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
                      
        }else if($gender == "Male" || $gender == "Female"){
            
            $none['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $none['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $primary['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $primary['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $secondary['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $secondary['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $diploma['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $diploma['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $university['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $university['gender']   = Zf_QueryGenerator::SQLValue($gender);
                      
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
 
        if($noneCount == 0 && $primaryCount == 0 && $secondaryCount == 0 && $diplomaCount == 0 && $universityCount ==0 ){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='80' legendPosition='BOTTOM' >";
        $strXML .= "<set label='None' value=' ".$noneCount." ' tooltext=' None count: ".$noneCount.",{br}Click for a detailed{br}information ' link=' ' />";
        $strXML .= "<set label='Primary' value=' ".$primaryCount." ' tooltext=' Primary count: ".$primaryCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Secondary' value=' ".$secondaryCount." '  tooltext=' Secondary count: ".$secondaryCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Diploma' value=' ".$diplomaCount." '  tooltext=' Diploma count: ".$diplomaCount.",{br}Click for a detailed{br}information ' link=' ' />";
        $strXML .= "<set label='University' value=' ".$universityCount." '  tooltext=' University count: ".$universityCount.",{br}Click for a detailed{br}information ' link=' '/>";
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
            "chartHeight"       => 240,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
 
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO MARITAL STATUS.
     * =========================================================================
     */
    public function MaritalStatus($dataFilter){
        
        $dataRange = explode("_", $dataFilter);
        
        $occupation = $dataRange[0]; $gender = ucfirst($dataRange[1]);
        
        
        $single['maritalStatus']   = Zf_QueryGenerator::SQLValue("Single");
        $married['maritalStatus']  = Zf_QueryGenerator::SQLValue("Married");
        $divorced['maritalStatus'] = Zf_QueryGenerator::SQLValue("Divorced");
        $widowed['maritalStatus']  = Zf_QueryGenerator::SQLValue("Widowed");
        
        if($gender == "All"){
            
            $single['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $married['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $divorced['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $widowed['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
                      
        }else if($gender == "Male" || $gender == "Female"){
            
            $single['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $single['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $married['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $married['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $divorced['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $divorced['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $widowed['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $widowed['gender']   = Zf_QueryGenerator::SQLValue($gender);
                      
        }
       
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        if($decodedIdentificationCode[4] == COMPANY_ADMIN){
        
                $single['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $married['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $divorced['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $widowed['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER ||$decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){
 
                $single['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $single['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                $married['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $married['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                $divorced['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $divorced['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

                $widowed['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $widowed['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
            
        }
        
        $selectColumns = array('maritalStatus');
        
            
        $getSingle   = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $single, $selectColumns);
        $getMarried  = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $married, $selectColumns);
        $getDivorced = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $divorced, $selectColumns);
        $getWidowed  = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $widowed, $selectColumns);
        
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
        
        if($singleCount == 0 && $marriedCount == 0 && $divorcedCount ==0 && $widowedCount ==0 ){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
            
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='80' legendPosition='BOTTOM' >";
        $strXML .= "<set label='Single' value=' ".$singleCount." ' tooltext=' Singles count: ".$singleCount.",{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='Married' value=' ".$marriedCount." ' tooltext=' Married count: ".$marriedCount.",{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='Divorced' value=' ".$divorcedCount." ' tooltext=' Divorced count: ".$divorcedCount.",{br}Click for a detailed{br}information '  link=' ' />";
        $strXML .= "<set label='Widowed' value=' ".$widowedCount." ' tooltext=' Widowed count: ".$widowedCount.",{br}Click for a detailed{br}information '  link=' ' />";
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
            "chartHeight"       => 240,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO ANNUAL INCOME.
     * =========================================================================
     */
    public function AnnualIncome($dataFilter){
        
        $dataRange = explode("_", $dataFilter);
        
        $occupation = $dataRange[0]; $gender = ucfirst($dataRange[1]);
 
        $income5000['monthlyIncome']   = Zf_QueryGenerator::SQLValue("0-5000");
        $income10000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("5001-10000");
        $income20000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("10001-20000");
        $income50000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("20001-50000");
        $income50001['monthlyIncome']  = Zf_QueryGenerator::SQLValue("50001+");
        
        if($gender == "All"){
            
            $income5000['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income10000['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income20000['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income50000['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income50001['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
                      
        }else if($gender == "Male" || $gender == "Female"){
            
            $income5000['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income5000['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $income10000['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income10000['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $income20000['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income20000['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $income50000['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income50000['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $income50001['occupation']   = Zf_QueryGenerator::SQLValue($occupation);
            $income50001['gender']   = Zf_QueryGenerator::SQLValue($gender);
                      
        }
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        if($decodedIdentificationCode[4] == COMPANY_ADMIN){
        
                $income5000['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $income10000['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $income20000['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $income50000['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                $income50001['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER ||$decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){
 
                $income5000['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $income5000['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                
                $income10000['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $income10000['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                
                $income20000['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $income20000['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                
                $income50000['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $income50000['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                
                $income50001['identificationCode'] = Zf_QueryGenerator::SQLValue($userIdentificationCode);
                $income50001['companySerial'] = Zf_QueryGenerator::SQLValue($decodedIdentificationCode[1]);
                
            
        }
        
        $selectColumns = array('monthlyIncome');
        
            
        $getIncome5000  = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $income5000, $selectColumns);
        $getIncome10000 = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $income10000, $selectColumns);
        $getIncome20000 = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $income20000, $selectColumns);
        $getIncome50000 = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $income50000, $selectColumns);
        $getIncome50001 = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $income50001, $selectColumns);
        
        $executeIncome5000  = $this->Zf_AdoDB->Execute($getIncome5000);
        $executeIncome10000 = $this->Zf_AdoDB->Execute($getIncome10000);
        $executeIncome20000 = $this->Zf_AdoDB->Execute($getIncome20000);
        $executeIncome50000 = $this->Zf_AdoDB->Execute($getIncome50000);
        $executeIncome50001 = $this->Zf_AdoDB->Execute($getIncome50001);
        
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
        
        if($income5000Count == 0 && $income10000Count == 0 && $income20000Count == 0 && $income50000Count == 0 && $income50001Count ==0 ){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='80' legendPosition='BOTTOM' >";
        $strXML .= "<set label='0 - 60K' value=' ".$income5000Count." ' tooltext='Annual salary below 60,001 (Kshs){br}Total count:  ".$income5000Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "<set label='60K - 120K' value=' ".$income10000Count." ' tooltext=' Annual salary between 60,001 - 120,000 (Kshs){br}Total count:  ".$income10000Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "<set label='120K - 240K' value=' ".$income20000Count." ' tooltext=' Annual salary between 120,001 - 240,000 (Kshs){br}Total count:  ".$income20000Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "<set label='240K - 600K' value=' ".$income50000Count." ' tooltext=' Annual salary between 240,001 - 600,000 (Kshs){br}Total count:  ".$income50000Count." people,{br}Click for a detailed information '  link=' '/>";
        $strXML .= "<set label='Above 600K' value=' ".$income50001Count." ' tooltext=' Annual salary above 600,001 (Kshs){br}Total count:  ".$income50001Count." people,{br}Click for a detailed information '  link=' '/>";
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
            "chartHeight"       => 240,
            "chartDebug"        => "false",
            "registerJavacript" => "true",
            "chartTransparency" => ""

        );

        Zf_GenerateCharts::zf_generate_chart($zf_chartData, $chartPosition = "inline");
 
        
    }
    

}

?>


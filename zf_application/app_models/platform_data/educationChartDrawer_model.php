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

class EducationChartDrawer_Model extends Zf_Model {
    
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
        
        $educationLevel = $dataRange[0]; $gender = ucfirst($dataRange[1]);
        
        
        if($gender == "All"){
            
            $maleCustomers['gender'] = Zf_QueryGenerator::SQLValue("Male");
            $maleCustomers['educationLevel'] = Zf_QueryGenerator::SQLValue($educationLevel);
            
            $femaleCustomers['gender'] = Zf_QueryGenerator::SQLValue("Female");
            $femaleCustomers['educationLevel'] = Zf_QueryGenerator::SQLValue($educationLevel);
                      
        }else if($gender == "Male"){
            
            $maleCustomers['gender'] = Zf_QueryGenerator::SQLValue($gender);
            $maleCustomers['educationLevel'] = Zf_QueryGenerator::SQLValue($educationLevel);
                      
        }else if($gender == "Female"){
            
            $femaleCustomers['gender'] = Zf_QueryGenerator::SQLValue($gender);
            $femaleCustomers['educationLevel'] = Zf_QueryGenerator::SQLValue($educationLevel);
            
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
        
        $educationLevel = $dataRange[0]; $gender = ucfirst($dataRange[1]);
        
        $age25['ageBracket'] = Zf_QueryGenerator::SQLValue("18-25");
        $age35['ageBracket'] = Zf_QueryGenerator::SQLValue("26-35");
        $age50['ageBracket'] = Zf_QueryGenerator::SQLValue("36-50");
        $age51['ageBracket'] = Zf_QueryGenerator::SQLValue("51 +");
        
        if ($gender == "All") {
            
            $age25['educationLevel'] = Zf_QueryGenerator::SQLValue($educationLevel);
            $age35['educationLevel'] = Zf_QueryGenerator::SQLValue($educationLevel);
            $age50['educationLevel'] = Zf_QueryGenerator::SQLValue($educationLevel);
            $age51['educationLevel'] = Zf_QueryGenerator::SQLValue($educationLevel);
            
        }else if($gender == "Male" || $gender == "Female"){
            
            $age25['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $age25['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $age35['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $age35['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $age50['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $age50['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $age51['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
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
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO MARITAL STATUS.
     * =========================================================================
     */
    public function MaritalStatus($dataFilter){
        
        $dataRange = explode("_", $dataFilter);
        
        $educationLevel = $dataRange[0]; $gender = ucfirst($dataRange[1]);
        
        $single['maritalStatus']   = Zf_QueryGenerator::SQLValue("Single");
        $married['maritalStatus']  = Zf_QueryGenerator::SQLValue("Married");
        $divorced['maritalStatus'] = Zf_QueryGenerator::SQLValue("Divorced");
        $widowed['maritalStatus']  = Zf_QueryGenerator::SQLValue("Widowed");
        
        if($gender == "All"){
            
            $single['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $married['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $divorced['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $widowed['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
                      
        }else if($gender == "Male" || $gender == "Female"){
            
            $single['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $single['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $married['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $married['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $divorced['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $divorced['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $widowed['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
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
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO OCCUPATION.
     * =========================================================================
     */
    public function Occupation($dataFilter){
        
        $dataRange = explode("_", $dataFilter);
        
        $educationLevel = $dataRange[0]; $gender = ucfirst($dataRange[1]);
 
        $others['occupation']   = Zf_QueryGenerator::SQLValue("Others");
        $farmer['occupation']  = Zf_QueryGenerator::SQLValue("Farmer");
        $shopOwner['occupation'] = Zf_QueryGenerator::SQLValue("Shop Owner");
        $professional['occupation']  = Zf_QueryGenerator::SQLValue("Professional");
        
        if($gender == "All"){
            
            $others['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $farmer['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $shopOwner['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $professional['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
                      
        }else if($gender == "Male" || $gender == "Female"){
            
            $others['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $others['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $farmer['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $farmer['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $shopOwner['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $shopOwner['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $professional['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $professional['gender']   = Zf_QueryGenerator::SQLValue($gender);
                      
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
        
        if($othersCount == 0 && $farmerCount == 0 && $shopOwnerCount == 0 && $professionalCount ==0 ){
            
            echo "<div class='no-loading-data'>No matching data to load</div>"; exit();
        }
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='80' legendPosition='BOTTOM' >";
        $strXML .= "<set label='Others' value=' ".$othersCount." ' tooltext=' Others count: ".$othersCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Farmers' value=' ".$farmerCount." ' tooltext=' Farmers count: ".$farmerCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Shop Owners' value=' ".$shopOwnerCount." ' tooltext=' Shop owners count: ".$shopOwnerCount.",{br}Click for a detailed{br}information ' link=' '/>";
        $strXML .= "<set label='Professional' value=' ".$professionalCount." ' tooltext=' Professionals count: ".$professionalCount.",{br}Click for a detailed{br}information ' link=' '/>";
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
        
        $educationLevel = $dataRange[0]; $gender = ucfirst($dataRange[1]);
 
        $income5000['monthlyIncome']   = Zf_QueryGenerator::SQLValue("0-5000");
        $income10000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("5001-10000");
        $income20000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("10001-20000");
        $income50000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("20001-50000");
        $income50001['monthlyIncome']  = Zf_QueryGenerator::SQLValue("50001+");
        
        if($gender == "All"){
            
            $income5000['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $income10000['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $income20000['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $income50000['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $income50001['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
                      
        }else if($gender == "Male" || $gender == "Female"){
            
            $income5000['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $income5000['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $income10000['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $income10000['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $income20000['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $income20000['gender']   = Zf_QueryGenerator::SQLValue($gender);

            $income50000['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
            $income50000['gender']   = Zf_QueryGenerator::SQLValue($gender);
            
            $income50001['educationLevel']   = Zf_QueryGenerator::SQLValue($educationLevel);
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


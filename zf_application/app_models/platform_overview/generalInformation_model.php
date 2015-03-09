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

class GeneralInformation_Model extends Zf_Model {
    
    
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
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO AREAS OF ACTIVE PROJECTS.
     * =========================================================================
     */
    public function ProjectAreas(){
        
        //An instance of the ZF_MAPBUILDER CLASS.
        $zf_map = new Zf_MapBuilder();
        
        // Set map's center position by latitude and longitude coordinates. 
        $zf_map->setCenter(-1.2921,36.8219);

        // Set the default map type.
        $zf_map->setMapTypeId(Zf_MapBuilder::MAP_TYPE_ID_TERRAIN);

        // Set width and height of the map.
        $zf_map->setSize(730, 310);

        // Set default zoom level.
        $zf_map->setZoom(2);

        // Make zoom control compact.
        $zf_map->setZoomControlStyle(Zf_MapBuilder::ZOOM_CONTROL_STYLE_DEFAULT);

        // Define locations and add markers with custom icons and attached info windows.
        $column = array('country_name','latitude','longitude');
            
        $getProjectCountries = Zf_QueryGenerator::BuildSQLSelect('ttv_projectCountries','', $column);
        //echo $getProjectCountries; exit(); //This is strictly for debugging purpose.
        
        //Fetch all the results related to the query above.
        $result = mysql_query("$getProjectCountries") or die(mysql_error());
        while ($row = mysql_fetch_assoc($result)) {

            $zf_map->addMarker($row['latitude'], $row['longitude'], array(
                'title' => $row['country_name'],
                'html' => '<div style="width: 120px; height: 160px;">Counrty: '. $row['country_name'] .'</div><b></b>', 
                'infoCloseOthers' => true
            ));
        }

        // Display the map.
        $zf_map->show();
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO GENDER RATIO.
     * =========================================================================
     */
    public function GenderRation(){
 
        $maleCustomers['gender'] = Zf_QueryGenerator::SQLValue("Male");
        $femaleCustomers['gender'] = Zf_QueryGenerator::SQLValue("Female");
        
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
        
        
            
        $getMaleCustomers   = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $maleCustomers, $selectColumns);
        $getFemaleCustomers = Zf_QueryGenerator::BuildSQLSelect('ttv_customerData', $femaleCustomers, $selectColumns);
        
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
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='100' legendPosition='RIGHT'
            paletteColors='ffb848,28b779' paletteThemeColor='ffb848' showToolTip='1' showToolTipShadow='1'>";
        $strXML .= "<set label='Male' value=' ".$maleCount." ' tooltext=' Total male count: ".$maleCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'gender_data/male')." ' />";
        $strXML .= "<set label='Female' value=' ".$femaleCount." ' tooltext='Total female count: ".$femaleCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'gender_data/female')." ' />";
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

        return $strXML;
 
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO AGE DISTRIBUTION.
     * =========================================================================
     */
    public function AgeDistribution1(){
        
        $age25['ageBracket'] = Zf_QueryGenerator::SQLValue("18-25");
        $age35['ageBracket'] = Zf_QueryGenerator::SQLValue("26-35");
        $age50['ageBracket'] = Zf_QueryGenerator::SQLValue("36-50");
        $age51['ageBracket'] = Zf_QueryGenerator::SQLValue("51 +");
        
        
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
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='120' legendPosition='BOTTOM' >";
        $strXML .= "<set label='18 - 25' value=' ".$age25Count." ' tooltext=' Age brackets 18 - 25 years{br}Total count: ".$age25Count." people,{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'age_data/18-25')." ' />";
        $strXML .= "<set label='26 - 35' value=' ".$age35Count." ' tooltext=' Age brackets 26 - 35 years{br}Total count: ".$age35Count." people,{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'age_data/26-35')." ' />";
        $strXML .= "<set label='36 - 50' value=' ".$age50Count." ' tooltext=' Age brackets 36 -50 years{br}Total count: ".$age50Count." people,{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'age_data/36-50')." ' />";
        $strXML .= "<set label='51+' value=' ".$age51Count." ' tooltext=' Age brackets over 50 years{br}Total count: ".$age51Count." people,{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'age_data/51 +')." ' />";
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

        return $strXML;
 
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO EDUCATION LEVEL.
     * =========================================================================
     */
    public function EducationLevel(){
        
        $none['educationLevel']       = Zf_QueryGenerator::SQLValue("none");
        $primary['educationLevel']    = Zf_QueryGenerator::SQLValue("primary");
        $secondary['educationLevel']  = Zf_QueryGenerator::SQLValue("secondary");
        $diploma['educationLevel']    = Zf_QueryGenerator::SQLValue("diploma");
        $university['educationLevel'] = Zf_QueryGenerator::SQLValue("university");
        
        
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
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='120' legendPosition='BOTTOM' >";
        $strXML .= "<set label='None' value=' ".$noneCount." ' tooltext=' None count: ".$noneCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/none')." ' />";
        $strXML .= "<set label='Primary' value=' ".$primaryCount." ' tooltext=' Primary count: ".$primaryCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/primary')." '/>";
        $strXML .= "<set label='Secondary' value=' ".$secondaryCount." '  tooltext=' Secondary count: ".$secondaryCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/secondary')." '/>";
        $strXML .= "<set label='Diploma' value=' ".$diplomaCount." '  tooltext=' Diploma count: ".$diplomaCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/diploma')." ' />";
        $strXML .= "<set label='University' value=' ".$universityCount." '  tooltext=' University count: ".$universityCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'education_data/university')." '/>";
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

        return $strXML;
 
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO MARITAL STATUS.
     * =========================================================================
     */
    public function MaritalStatus(){
        
        $single['maritalStatus']   = Zf_QueryGenerator::SQLValue("Single");
        $married['maritalStatus']  = Zf_QueryGenerator::SQLValue("Married");
        $divorced['maritalStatus'] = Zf_QueryGenerator::SQLValue("Divorced");
        $widowed['maritalStatus']  = Zf_QueryGenerator::SQLValue("Widowed");
        
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
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='120' legendPosition='BOTTOM' >";
        $strXML .= "<set label='Single' value=' ".$singleCount." ' tooltext=' Singles count: ".$singleCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'marital_data/sinlge')." ' />";
        $strXML .= "<set label='Married' value=' ".$marriedCount." ' tooltext=' Married count: ".$marriedCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'marital_data/married')." ' />";
        $strXML .= "<set label='Divorced' value=' ".$divorcedCount." ' tooltext=' Divorced count: ".$divorcedCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'marital_data/divorced')." ' />";
        $strXML .= "<set label='Widowed' value=' ".$widowedCount." ' tooltext=' Widowed count: ".$widowedCount.",{br}Click for a detailed{br}information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'marital_data/widowed')." ' />";
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

        return $strXML;
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO OCCUPATION.
     * =========================================================================
     */
    public function Occupation(){
 
        $others['occupation']   = Zf_QueryGenerator::SQLValue("Others");
        $farmer['occupation']  = Zf_QueryGenerator::SQLValue("Farmer");
        $shopOwner['occupation'] = Zf_QueryGenerator::SQLValue("Shop Owner");
        $professional['occupation']  = Zf_QueryGenerator::SQLValue("Professional");
        
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
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='120' legendPosition='BOTTOM' >";
        $strXML .= "<set label='Others' value=' ".$othersCount." ' tooltext=' Others count: ".$othersCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'occupation_data/other')." '/>";
        $strXML .= "<set label='Farmers' value=' ".$farmerCount." ' tooltext=' Farmers count: ".$farmerCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'occupation_data/farmer')." '/>";
        $strXML .= "<set label='Shop Owners' value=' ".$shopOwnerCount." ' tooltext=' Shop owners count: ".$shopOwnerCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'occupation_data/shop owner')." '/>";
        $strXML .= "<set label='Professional' value=' ".$professionalCount." ' tooltext=' Professionals count: ".$professionalCount.",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'occupation_data/professional')." '/>";
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

        return $strXML;
        
    }
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO ANNUAL INCOME.
     * =========================================================================
     */
    public function AnnualIncome(){
        
        $income5000['monthlyIncome']   = Zf_QueryGenerator::SQLValue("0-5000");
        $income10000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("5001-10000");
        $income20000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("10001-20000");
        $income50000['monthlyIncome']  = Zf_QueryGenerator::SQLValue("20001-50000");
        $income50001['monthlyIncome']  = Zf_QueryGenerator::SQLValue("50001 +");
        
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
        
        $strXML  = "";
        $strXML .= "<chart bgColor='transparent' bgAlpha='50' showBorder='0' canvasBgColor='transparent'
            canvasBorderColor='efefef' canvasBorderThickness='1' canvasBorderAlpha='80' canvasBorder='0'
            xAxisName='' yAxisName='No. of Customers' showValues='1' formatNumberScale='0'
            paletteColors='ffb848, 28b779, 27a9e3, e7191b, 852b99' paletteThemeColor='ffb848'
            showlegend='1' enablesmartlabels='0' showlabels='0' showpercentvalues='1' pieRadius='120' legendPosition='BOTTOM' >";
        $strXML .= "<set label='0 - 60K' value=' ".$income5000Count." ' tooltext='Annual salary below 60,001 (Kshs){br}Total count:  ".$income5000Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/0-5000')." '/>";
        $strXML .= "<set label='60K - 120K' value=' ".$income10000Count." ' tooltext=' Annual salary between 60,001 - 120,000 (Kshs){br}Total count:  ".$income10000Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/5001-10000')." '/>";
        $strXML .= "<set label='120K - 240K' value=' ".$income20000Count." ' tooltext=' Annual salary between 120,001 - 240,000 (Kshs){br}Total count:  ".$income20000Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/10001-20000')." '/>";
        $strXML .= "<set label='240K - 600K' value=' ".$income50000Count." ' tooltext=' Annual salary between 240,001 - 600,000 (Kshs){br}Total count:  ".$income50000Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/20001-50000')." '/>";
        $strXML .= "<set label='Above 600K' value=' ".$income50001Count." ' tooltext=' Annual salary above 600,001 (Kshs){br}Total count:  ".$income50001Count." people,{br}Click for a detailed information '  link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'income_data/50001 +')." '/>";
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

        return $strXML;
 
        
    }
    
    
    
    public function GenderRatio(){
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        $userIdentity['identificationCode'] = $userIdentificationCode;
        $userIdentity['companySerial'] = $decodedIdentificationCode[1];
        $userIdentity['userRole'] = $decodedIdentificationCode[4];
        
        
        $chart = new Zf_Chart_Plotter('Pie2D', 'customerData', '100%', '300px');
        
        //These are the chart parameters
        $chartOptions = array(
            "bgColor"=>"transparent",
            "bgAlpha"=>"50",
            "showBorder"=>"0",
            "canvasBgColor"=>"transparent",
            "canvasBorderColor"=>"efefef",
            "canvasBorderThickness"=>"1",
            "canvasBorderAlpha"=>"80",
            "paletteColors"=>"ffb848, 28b779, 27a9e3, e7191b, 852b99",
            "paletteThemeColor"=>"ffb848",
            "showlegend"=>"1", 
            "enablesmartlabels"=>"0",
            "showlabels"=>"0", 
            "showpercentvalues"=>"1", 
            "pieRadius"=>"100", 
            "legendPosition"=>"BOTTOM",
            "canvasBorder"=>"0",
            //"caption" => "Male Female",
            "showValues" => "1", 
            "useRoundEdges" => "1", 
            "palette" => "3"
        );
        
        //This has been posted by jquery ajax.
        $dataRange = $_POST['ageRange'];
        
        //Here we build the table entities for querying.
        $gender = array("gender" => array("male", "female"));
        
        $chart->plotChart('ttv_customerData', $gender, $dataRange, $userIdentity ,$chartOptions);
        
    }
    

}

?>


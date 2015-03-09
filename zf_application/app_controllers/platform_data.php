<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE INDEX CONTROLLER, ESSENTIAL FOR ROUTING AND EXECUTING ALL ACTIONS
 * THAT RELATE TO INDEX MODELS AND VIEWS.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  14th/August/2013  Time: 11:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013 (sunday)
 * 
 */

class Platform_dataController extends Zf_Controller {
   
    
    public $zf_defaultAction = "index";
    
    
    //This holds the current URL
    private $currentUrl;
    
    //This holds the session user details.
    private $sessionUser;



    public function __construct() {
        
        /**
         * CALL THE CONSTRUCTOR OF THE PARENT CLASS.
         */
        parent::__construct();
        
        $this->currentUrl = Zf_Core_Functions::Zf_URLSanitize();
        
        $this->sessionUser = Zf_SessionHandler::zf_getSessionVariable("ttv_identificationCode");
        
    }

    
    /**
     * This is the index action for the controller
     */
    public function actionIndex(){
        
        Zf_View::zf_displayView('index');
        
    }
    
    
    /**
     * This is the index action for the controller
     */
    public function actionData_overview(){
        
        Zf_View::zf_displayView('data_overview');
        
    }
    
    
    /**
     * This is the customer data action for the controller
     */
    public function actionCustomer_data($dataFilter = NULL){
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        //echo Zf_SecureData::zf_decode_url($dataFilter); exit(); //This is strictly for decoding purposes.
        
        $customerDataFilter = explode('/', Zf_SecureData::zf_decode_url($dataFilter));
        
        $dataFilter = $customerDataFilter[1]; $dataRange  = $customerDataFilter[2];
        
        if($customerDataFilter[0] == 'gender_data'){
            
            $this->actionGenderDataTable($dataFilter, $dataRange); exit();
            
        }
        else if($customerDataFilter[0] == 'age_data'){
            
            $this->actionAgeDataTable($dataFilter, $dataRange); exit();
            
        }
        else if($customerDataFilter[0] == 'education_data'){
            
            $this->actionEducationDataTable($dataFilter, $dataRange); exit();
            
        }
        else if($customerDataFilter[0] == 'marital_data'){
            
            $this->actionMaritalDataTable($dataFilter, $dataRange); exit();
            
        }
        else if($customerDataFilter[0] == 'occupation_data'){
            
            $this->actionOccupationDataTable($dataFilter, $dataRange); exit();
            
        }
        else if($customerDataFilter[0] == 'income_data'){
            
            $this->actionIncomeDataTable($dataFilter, $dataRange); exit();
            
        }
        
        
    }
    
    
    /**
     * =========================================================================
     * IN  THIS SECTION WE GENERATE ALL THE TABLES GRIDS THAT ARE RELATED TO ALL
     * THE DATA CLICKED ON A PIE SECTOR.
     * =========================================================================
     * 
     */
    
    /**
     * This is the public method that analyses the gender data
     */
    public function actionGenderDataTable($dataFilter, $dataRange){
        
        //echo $_POST['gender']."-".$_POST['ageBracket']; exit();
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
       //print_r($decodedIdentificationCode); exit();
        $ttv_customerGender = ucfirst($dataFilter);
        
        $ageRange = explode(';' , $dataRange);
        
        //This holds the name of the database table that is being accessed.
        $zf_phpGridSettings['zf_tableName'] = 'ttv_customerData'; 
        
        $tableTitle = $ttv_customerGender." Customer Data";
        //This holds all the grid setting e.g. title, width, height e.t.c
        $zf_phpGridSettings['zf_gridSettings'] = zf_phpGridConfigurations::Zf_PhpGridSettings($tableTitle);

        //This holds all the grid actions e.g exporting data, editing data e.t.c
        $zf_phpGridSettings['zf_gridActions'] = zf_phpGridConfigurations::Zf_PhpGridActions();

        //This array holds all the data related to required grid columns
        $zf_gridColumns = array();

        $nationalId = array("title"=>"National ID", "name"=>"nationalId", "width"=>15, "editable"=>true, "edithidden"=>true, "export"=>false); 
        $zf_gridColumns[] = $nationalId;

        $firstName = array("title"=>"Firstname", "name"=>"firstName", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $firstName;

        $lastName = array("title"=>"Lastname", "name"=>"lastName", "width"=>15, "editable"=>true);
        $zf_gridColumns []= $lastName;

        //$gender = array("title"=>"Gender", "name"=>"gender", "width"=>10, "editable"=>true, "search"=>true, "sortable"=>true);
        //$zf_gridColumns[] = $gender;
        
        $mobileNo = array("title"=>"Mobile No.", "name"=>"mobileNo", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $mobileNo;
        
        $ageBracket = array("title"=>"Age Bracket", "name"=>"ageBracket", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $ageBracket;
        
        $occupation = array("title"=>"Occupation", "name"=>"occupation", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $occupation;
        
        $location = array("title"=>"Location", "name"=>"location", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $location;
        
        
        $customerInfoPath = ZF_ROOT_PATH.APP_VIEWS. $this->currentUrl[0].DS."fullcustomerinfo.php?id={national_id}"; 
        $personal_data    = array("title"=>"More Information", "name"=>"more_options", "width"=>20, "export"=>true, "link"=>$customerInfoPath, "align"=>"center", "search"=>false, "sortable"=>false, "editable"=>false, "default"=>"Personal Data");
        $zf_gridColumns[] = $personal_data;
        
        $action = array("title"=>"Actions", "name"=>"act", "align"=>"center", "width"=>20, "export"=>false, "hidden"=>false );
        $zf_gridColumns[] = $action;

        $zf_phpGridSettings['zf_gridColumns'] = $zf_gridColumns;
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getCustomersGenderData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE gender = '".$ttv_customerGender."' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){

            $getCustomersGenderData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE  gender = '".$ttv_customerGender."' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();$getFemaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='female' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getCustomersGenderData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE gender = '".$ttv_customerGender."' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $tableQuery = $getCustomersGenderData;
        
        //echo $tableQuery; exit();

        $zf_phpGridSettings['zf_gridQuery'] = $tableQuery;
        
        $zf_actionData = $ttv_customerGender."_".$dataRange;

        Zf_View::zf_displayView('genderAnalysis', $zf_actionData, $zf_phpGridSettings); exit();
        
    }
    
    
    /**
     * This is the public method that analyses the age bracket data
     */
    public function actionAgeDataTable($dataFilter, $dataRange){
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        $ttv_customerAge = $dataFilter;
        
        //This holds the name of the database table that is being accessed.
        $zf_phpGridSettings['zf_tableName'] = 'ttv_customerData'; 
        
        $tableTitle = "Age Set ".$ttv_customerAge." Years - Customer Data";
        //This holds all the grid setting e.g. title, width, height e.t.c
        $zf_phpGridSettings['zf_gridSettings'] = zf_phpGridConfigurations::Zf_PhpGridSettings($tableTitle);

        //This holds all the grid actions e.g exporting data, editing data e.t.c
        $zf_phpGridSettings['zf_gridActions'] = zf_phpGridConfigurations::Zf_PhpGridActions();

        //This array holds all the data related to required grid columns
        $zf_gridColumns = array();

        $nationalId = array("title"=>"National ID", "name"=>"nationalId", "width"=>15, "editable"=>true, "edithidden"=>true, "export"=>false); 
        $zf_gridColumns[] = $nationalId;

        $firstName = array("title"=>"Firstname", "name"=>"firstName", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $firstName;

        $lastName = array("title"=>"Lastname", "name"=>"lastName", "width"=>15, "editable"=>true);
        $zf_gridColumns []= $lastName;

        $mobileNo = array("title"=>"Mobile No.", "name"=>"mobileNo", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $mobileNo;
        
        $gender = array("title"=>"Gender", "name"=>"gender", "width"=>15, "editable"=>true, "search"=>true, "sortable"=>true);
        $zf_gridColumns[] = $gender;
        
        //$ageBracket = array("title"=>"Age Bracket", "name"=>"ageBracket", "width"=>15, "editable"=>true);
        //$zf_gridColumns[] = $ageBracket;
        
        $occupation = array("title"=>"Occupation", "name"=>"occupation", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $occupation;
        
        $location = array("title"=>"Location", "name"=>"location", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $location;
        
        
        $customerInfoPath = ZF_ROOT_PATH.APP_VIEWS. $this->currentUrl[0].DS."fullcustomerinfo.php?id={national_id}"; 
        $personal_data    = array("title"=>"More Information", "name"=>"more_options", "width"=>20, "export"=>true, "link"=>$customerInfoPath, "align"=>"center", "search"=>false, "sortable"=>false, "editable"=>false, "default"=>"Personal Data");
        $zf_gridColumns[] = $personal_data;
        
        $action = array("title"=>"Actions", "name"=>"act", "align"=>"center", "width"=>20, "export"=>false);
        $zf_gridColumns[] = $action;

        $zf_phpGridSettings['zf_gridColumns'] = $zf_gridColumns;
        
        if($dataRange == "all"){
            
            $genderData = "'";
            
        }else{
            
            $genderData = "' AND gender = '{$dataRange}' ";
            
        }
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){
 
            $getCustomersAgeData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE ageBracket = '".$ttv_customerAge.$genderData; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){

            $getCustomersAgeData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE ageBracket = '".$ttv_customerAge.$genderData." AND companySerial = '" .$decodedIdentificationCode[1]. " ' "; //die();$getFemaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='female' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getCustomersAgeData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE ageBracket = '".$ttv_customerAge.$genderData." AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $tableQuery = $getCustomersAgeData;
        
        //echo $tableQuery; exit();

        $zf_phpGridSettings['zf_gridQuery'] = $tableQuery;
        
        $zf_actionData = $ttv_customerAge."_".$dataRange;

        Zf_View::zf_displayView('ageAnalysis', $zf_actionData, $zf_phpGridSettings); exit();
        
    }
    
    
    /**
     * This is the public method that analyses the education data
     */
    public function actionEducationDataTable($dataFilter, $dataRange){
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        $ttv_customerEducation = ucfirst($dataFilter);
        
        //This holds the name of the database table that is being accessed.
        $zf_phpGridSettings['zf_tableName'] = 'ttv_customerData'; 
        
        $tableTitle = $ttv_customerEducation." Level - Customer Data";
        //This holds all the grid setting e.g. title, width, height e.t.c
        $zf_phpGridSettings['zf_gridSettings'] = zf_phpGridConfigurations::Zf_PhpGridSettings($tableTitle);

        //This holds all the grid actions e.g exporting data, editing data e.t.c
        $zf_phpGridSettings['zf_gridActions'] = zf_phpGridConfigurations::Zf_PhpGridActions();

        //This array holds all the data related to required grid columns
        $zf_gridColumns = array();

        $nationalId = array("title"=>"National ID", "name"=>"nationalId", "width"=>15, "editable"=>true, "edithidden"=>true, "export"=>false); 
        $zf_gridColumns[] = $nationalId;

        $firstName = array("title"=>"Firstname", "name"=>"firstName", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $firstName;

        $lastName = array("title"=>"Lastname", "name"=>"lastName", "width"=>15, "editable"=>true);
        $zf_gridColumns []= $lastName;

        $mobileNo = array("title"=>"Mobile No.", "name"=>"mobileNo", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $mobileNo;
        
        $gender = array("title"=>"Gender", "name"=>"gender", "width"=>15, "editable"=>true, "search"=>true, "sortable"=>true);
        $zf_gridColumns[] = $gender;
        
        //$ageBracket = array("title"=>"Age Bracket", "name"=>"ageBracket", "width"=>15, "editable"=>true);
        //$zf_gridColumns[] = $ageBracket;
        
        $occupation = array("title"=>"Occupation", "name"=>"occupation", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $occupation;
        
        $location = array("title"=>"Location", "name"=>"location", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $location;
        
        
        $customerInfoPath = ZF_ROOT_PATH.APP_VIEWS. $this->currentUrl[0].DS."fullcustomerinfo.php?id={national_id}"; 
        $personal_data    = array("title"=>"More Information", "name"=>"more_options", "width"=>20, "export"=>true, "link"=>$customerInfoPath, "align"=>"center", "search"=>false, "sortable"=>false, "editable"=>false, "default"=>"Personal Data");
        $zf_gridColumns[] = $personal_data;
        
        $action = array("title"=>"Actions", "name"=>"act", "align"=>"center", "width"=>20, "export"=>false);
        $zf_gridColumns[] = $action;

        $zf_phpGridSettings['zf_gridColumns'] = $zf_gridColumns;
        
        if($dataRange == "all"){
            
            $genderData = "'";
            
        }else{
            
            $genderData = "' AND gender = '{$dataRange}' ";
            
        }
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){
 
            $getCustomersEducationData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE educationLevel = '".$ttv_customerEducation.$genderData; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){

            $getCustomersEducationData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE educationLevel = '".$ttv_customerEducation.$genderData." AND companySerial = '" .$decodedIdentificationCode[1]. " ' "; //die();$getFemaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='female' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getCustomersEducationData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE educationLevel = '".$ttv_customerEducation.$genderData." AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $tableQuery = $getCustomersEducationData;
        
        //echo $tableQuery; exit();

        $zf_phpGridSettings['zf_gridQuery'] = $tableQuery;
        
        $zf_actionData = $ttv_customerEducation."_".$dataRange;
        
        Zf_View::zf_displayView('educationAnalysis', $zf_actionData, $zf_phpGridSettings); exit();
        
    }
    
    
    /**
     * This is the public method that analyses the marital data
     */
    public function actionMaritalDataTable($dataFilter, $dataRange){
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        $ttv_customerMarital = ucfirst($dataFilter);
        
        $ageRange = explode(';' , $dataRange);
        
        //This holds the name of the database table that is being accessed.
        $zf_phpGridSettings['zf_tableName'] = 'ttv_customerData'; 
        
        $tableTitle = $ttv_customerMarital." - Customer Data";
        //This holds all the grid setting e.g. title, width, height e.t.c
        $zf_phpGridSettings['zf_gridSettings'] = zf_phpGridConfigurations::Zf_PhpGridSettings($tableTitle);

        //This holds all the grid actions e.g exporting data, editing data e.t.c
        $zf_phpGridSettings['zf_gridActions'] = zf_phpGridConfigurations::Zf_PhpGridActions();

        //This array holds all the data related to required grid columns
        $zf_gridColumns = array();

        $nationalId = array("title"=>"National ID", "name"=>"nationalId", "width"=>15, "editable"=>true, "edithidden"=>true, "export"=>false); 
        $zf_gridColumns[] = $nationalId;

        $firstName = array("title"=>"Firstname", "name"=>"firstName", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $firstName;

        $lastName = array("title"=>"Lastname", "name"=>"lastName", "width"=>15, "editable"=>true);
        $zf_gridColumns []= $lastName;

        $mobileNo = array("title"=>"Mobile No.", "name"=>"mobileNo", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $mobileNo;
        
        $gender = array("title"=>"Gender", "name"=>"gender", "width"=>15, "editable"=>true, "search"=>true, "sortable"=>true);
        $zf_gridColumns[] = $gender;
        
        //$ageBracket = array("title"=>"Age Bracket", "name"=>"ageBracket", "width"=>15, "editable"=>true);
        //$zf_gridColumns[] = $ageBracket;
        
        $occupation = array("title"=>"Occupation", "name"=>"occupation", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $occupation;
        
        $location = array("title"=>"Location", "name"=>"location", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $location;
        
        
        $customerInfoPath = ZF_ROOT_PATH.APP_VIEWS. $this->currentUrl[0].DS."fullcustomerinfo.php?id={national_id}"; 
        $personal_data    = array("title"=>"More Information", "name"=>"more_options", "width"=>20, "export"=>true, "link"=>$customerInfoPath, "align"=>"center", "search"=>false, "sortable"=>false, "editable"=>false, "default"=>"Personal Data");
        $zf_gridColumns[] = $personal_data;
        
        $action = array("title"=>"Actions", "name"=>"act", "align"=>"center", "width"=>20, "export"=>false);
        $zf_gridColumns[] = $action;

        $zf_phpGridSettings['zf_gridColumns'] = $zf_gridColumns;
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getCustomersMaritalData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE maritalStatus = '".$ttv_customerMarital."' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){

            $getCustomersMaritalData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE maritalStatus = '".$ttv_customerMarital."' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();$getFemaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='female' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getCustomersMaritalData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE maritalStatus = '".$ttv_customerMarital."' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $tableQuery = $getCustomersMaritalData;

        $zf_phpGridSettings['zf_gridQuery'] = $tableQuery;
        
        $zf_actionData = $ttv_customerMarital."_".$dataRange;

        Zf_View::zf_displayView('maritalAnalysis', $zf_actionData, $zf_phpGridSettings); exit();
        
    }
    
    
    /**
     * This is the public method that analyses the occupation data
     */
    public function actionOccupationDataTable($dataFilter, $dataRange){
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        $ttv_customerOccupation = ucwords($dataFilter);
        
        //This holds the name of the database table that is being accessed.
        $zf_phpGridSettings['zf_tableName'] = 'ttv_customerData'; 
        
        $tableTitle = $ttv_customerOccupation."s - Customer Data";
        //This holds all the grid setting e.g. title, width, height e.t.c
        $zf_phpGridSettings['zf_gridSettings'] = zf_phpGridConfigurations::Zf_PhpGridSettings($tableTitle);

        //This holds all the grid actions e.g exporting data, editing data e.t.c
        $zf_phpGridSettings['zf_gridActions'] = zf_phpGridConfigurations::Zf_PhpGridActions();

        //This array holds all the data related to required grid columns
        $zf_gridColumns = array();

        $nationalId = array("title"=>"National ID", "name"=>"nationalId", "width"=>15, "editable"=>true, "edithidden"=>true, "export"=>false); 
        $zf_gridColumns[] = $nationalId;

        $firstName = array("title"=>"Firstname", "name"=>"firstName", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $firstName;

        $lastName = array("title"=>"Lastname", "name"=>"lastName", "width"=>15, "editable"=>true);
        $zf_gridColumns []= $lastName;
        
        $mobileNo = array("title"=>"Mobile No.", "name"=>"mobileNo", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $mobileNo;

        $gender = array("title"=>"Gender", "name"=>"gender", "width"=>15, "editable"=>true, "search"=>true, "sortable"=>true);
        $zf_gridColumns[] = $gender;
        
        $ageBracket = array("title"=>"Age Bracket", "name"=>"ageBracket", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $ageBracket;
        
        //$occupation = array("title"=>"Occupation", "name"=>"occupation", "width"=>15, "editable"=>true);
        //$zf_gridColumns[] = $occupation;
        
        $location = array("title"=>"Location", "name"=>"location", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $location;
        
        
        $customerInfoPath = ZF_ROOT_PATH.APP_VIEWS. $this->currentUrl[0].DS."fullcustomerinfo.php?id={national_id}"; 
        $personal_data    = array("title"=>"More Information", "name"=>"more_options", "width"=>20, "export"=>true, "link"=>$customerInfoPath, "align"=>"center", "search"=>false, "sortable"=>false, "editable"=>false, "default"=>"Personal Data");
        $zf_gridColumns[] = $personal_data;
        
        $action = array("title"=>"Actions", "name"=>"act", "align"=>"center", "width"=>20, "export"=>false);
        $zf_gridColumns[] = $action;

        $zf_phpGridSettings['zf_gridColumns'] = $zf_gridColumns;
        
        if($dataRange == "all"){
            
            $genderData = "'";
            
        }else{
            
            $genderData = "' AND gender = '{$dataRange}' ";
            
        }
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){
 
            $getCustomersOccupationData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE occupation = '".$ttv_customerOccupation.$genderData; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){

            $getCustomersOccupationData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE occupation = '".$ttv_customerOccupation.$genderData." AND companySerial = '" .$decodedIdentificationCode[1]. " ' "; //die();$getFemaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='female' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getCustomersOccupationData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE occupation = '".$ttv_customerOccupation.$genderData." AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $tableQuery = $getCustomersOccupationData;
        
        //echo $tableQuery; exit();

        $zf_phpGridSettings['zf_gridQuery'] = $tableQuery;
        
        $zf_actionData = $ttv_customerOccupation."_".$dataRange;

        Zf_View::zf_displayView('occupationAnalysis', $zf_actionData, $zf_phpGridSettings); exit();
        
    }
    
    
    /**
     * This is the public method that analyses the gender data
     */
    public function actionIncomeDataTable($dataFilter, $dataRange){
        
        //Here we explicitly specify the selection rule using the user session details
        $userIdentificationCode = $this->sessionUser;
        $decodedIdentificationCode = Zf_Core_Functions::Zf_DecodeIdentificationCode($this->sessionUser);
        
        $ttv_customerIncome = $dataFilter;
        
        $ageRange = explode(';' , $dataRange);
        
        //This holds the name of the database table that is being accessed.
        $zf_phpGridSettings['zf_tableName'] = 'ttv_customerData'; 
        if($ttv_customerIncome == "0-5000"){ $income = "0-60,000"; }
        else if($ttv_customerIncome == "5001-10000"){ $income = "60,001-120,000"; }
        else if($ttv_customerIncome == "10001-20000"){ $income = "120,001-240,000"; }
        else if($ttv_customerIncome == "20001-50000"){ $income = "240,001-600,000"; }
        else if($ttv_customerIncome == "50001 +"){ $income = "600,001 and Above"; }
        
        $tableTitle = $income." Annual Income";
        
        
        //This holds all the grid setting e.g. title, width, height e.t.c
        $zf_phpGridSettings['zf_gridSettings'] = zf_phpGridConfigurations::Zf_PhpGridSettings($tableTitle);

        //This holds all the grid actions e.g exporting data, editing data e.t.c
        $zf_phpGridSettings['zf_gridActions'] = zf_phpGridConfigurations::Zf_PhpGridActions();

        //This array holds all the data related to required grid columns
        $zf_gridColumns = array();

        $nationalId = array("title"=>"National ID", "name"=>"nationalId", "width"=>15, "editable"=>true, "edithidden"=>true, "export"=>false); 
        $zf_gridColumns[] = $nationalId;

        $firstName = array("title"=>"Firstname", "name"=>"firstName", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $firstName;

        $lastName = array("title"=>"Lastname", "name"=>"lastName", "width"=>15, "editable"=>true);
        $zf_gridColumns []= $lastName;

        //$gender = array("title"=>"Gender", "name"=>"gender", "width"=>10, "editable"=>true, "search"=>true, "sortable"=>true);
        //$zf_gridColumns[] = $gender;
        
        $mobileNo = array("title"=>"Mobile No.", "name"=>"mobileNo", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $mobileNo;
        
        $ageBracket = array("title"=>"Age Bracket", "name"=>"ageBracket", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $ageBracket;
        
        $occupation = array("title"=>"Occupation", "name"=>"occupation", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $occupation;
        
        $location = array("title"=>"Location", "name"=>"location", "width"=>15, "editable"=>true);
        $zf_gridColumns[] = $location;
        
        
        $customerInfoPath = ZF_ROOT_PATH.APP_VIEWS. $this->currentUrl[0].DS."fullcustomerinfo.php?id={national_id}"; 
        $personal_data    = array("title"=>"More Information", "name"=>"more_options", "width"=>20, "export"=>true, "link"=>$customerInfoPath, "align"=>"center", "search"=>false, "sortable"=>false, "editable"=>false, "default"=>"Personal Data");
        $zf_gridColumns[] = $personal_data;
        
        $action = array("title"=>"Actions", "name"=>"act", "align"=>"center", "width"=>20, "export"=>false, "hidden"=>true);
        $zf_gridColumns[] = $action;

        $zf_phpGridSettings['zf_gridColumns'] = $zf_gridColumns;
        
        if($decodedIdentificationCode[4] == PLATFORM_SUPER_ADMIN || $decodedIdentificationCode[4] == TOP_THIRD_ADMIN ){

            $getCustomersMaritalData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE monthlyIncome = '".$ttv_customerIncome."' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == COMPANY_ADMIN){

            $getCustomersMaritalData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE monthlyIncome = '".$ttv_customerIncome."' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();$getFemaleCustomers = "SELECT * FROM " . $table . " WHERE  gender ='female' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }else if($decodedIdentificationCode[4] == REGIONAL_MANAGER || $decodedIdentificationCode[4] == SHOP_MANAGER || $decodedIdentificationCode[4] == ASSISTANT_SHOP_MANAGER){

            $getCustomersMaritalData = "SELECT * FROM " . $zf_phpGridSettings['zf_tableName'] . " WHERE monthlyIncome = '".$ttv_customerIncome."' AND companySerial = '" .$decodedIdentificationCode[1]. "' AND identificationCode = '" .$userIdentificationCode. "' AND age BETWEEN " . $ageRange[0] . " AND " . $ageRange[1]; //die();

        }
        
        $tableQuery = $getCustomersMaritalData;

        $zf_phpGridSettings['zf_gridQuery'] = $tableQuery;
        
        $zf_actionData = $ttv_customerIncome."_".$dataRange;

        Zf_View::zf_displayView('incomeAnalysis', $zf_actionData, $zf_phpGridSettings); exit();
        
    }
    
    
    /**
     * =========================================================================
     * IN  THIS SECTION WE GENERATE ALL THE CHARTS THAT FOLLOW-UP THE DATA
     * TABLES.
     * =========================================================================
     * 
     */
    
    //1. THIS SECTION GENERATES THE CHARTS RELATED TO GENDER RATIO ANALYSIS
    
    /**
     * This is the public method that analyses the gender age chart
     */
    public function actionGenderChartDrawer($selectionFilter){
        
         $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
         
         $dataFilter = $_POST['gender']."_".$_POST['ageBracket'];
         
         if($rangeFilter == 'ageDistribution'){
             
             $this->zf_targetModel->AgeDistribution($dataFilter); exit();
             
         }else if($rangeFilter == 'maritalStatus'){
             
             $this->zf_targetModel->MaritalStatus($dataFilter); exit();
             
         }else if($rangeFilter == 'educationLevel'){
             
             $this->zf_targetModel->EducationLevel($dataFilter); exit();
             
         }else if($rangeFilter == 'occupation'){
             
             $this->zf_targetModel->Occupation($dataFilter); exit();
             
         }else if($rangeFilter == 'annualIncome'){
             
             $this->zf_targetModel->AnnualIncome($dataFilter); exit();
             
         }
        
    }
    
    
    //2. THIS SECTION GENERATES THE CHARTS RELATED TO AGE BRACKET ANALYSIS
    
    /**
     * This is the public method that analyses the gender age chart
     */
    public function actionAgeChartDrawer($selectionFilter){
        
         $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
         $selectors = explode("_", $rangeFilter);
         
         if(isset($_POST['dataFilter'])){
             
             $sectionSelector = $_POST['dataFilter'];
             
         }else{
             
              $sectionSelector = $selectors[2];
             
         }
         
         $dataFilter = $selectors[0]."_".$selectors[1];
         
         if($sectionSelector == 'genderRatio'){
             
             $this->zf_targetModel->GenderRatio($dataFilter); exit();
             
         }else if($sectionSelector == 'maritalStatus'){
             
             $this->zf_targetModel->MaritalStatus($dataFilter); exit();
             
         }else if($sectionSelector == 'educationLevel'){
             
             $this->zf_targetModel->EducationLevel($dataFilter); exit();
             
         }else if($sectionSelector == 'occupation'){
             
             $this->zf_targetModel->Occupation($dataFilter); exit();
             
         }else if($sectionSelector == 'annualIncome'){
             
             $this->zf_targetModel->AnnualIncome($dataFilter); exit();
             
         }
        
    }
    
    
    //3. THIS SECTION GENERATES THE CHARTS RELATED TO MARITAL STATUS ANALYSIS
    
    /**
     * This is the public method that analyses the marital status charts
     */
    public function actionMaritalChartDrawer($selectionFilter){
        
         $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
         
         $dataFilter = $_POST['gender']."_".$_POST['ageBracket'];
         
         if($rangeFilter == 'genderRatio'){
             
             $this->zf_targetModel->GenderRatio($dataFilter); exit();
             
         }else if($rangeFilter == 'ageDistribution'){
             
             $this->zf_targetModel->AgeDistribution($dataFilter); exit();
             
         }else if($rangeFilter == 'educationLevel'){
             
             $this->zf_targetModel->EducationLevel($dataFilter); exit();
             
         }else if($rangeFilter == 'occupation'){
             
             $this->zf_targetModel->Occupation($dataFilter); exit();
             
         }else if($rangeFilter == 'annualIncome'){
             
             $this->zf_targetModel->AnnualIncome($dataFilter); exit();
             
         }
        
    }
    
    
    //4. THIS SECTION GENERATES THE CHARTS RELATED TO EDUCATION LEVEL ANALYSIS
    
    /**
     * This is the public method that analyses the education level chart
     */
    public function actionEducationChartDrawer($selectionFilter){
        
         $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
         $selectors = explode("_", $rangeFilter);
         
         if(isset($_POST['dataFilter'])){
             
             $sectionSelector = $_POST['dataFilter'];
             
         }else{
             
              $sectionSelector = $selectors[2];
             
         }
         
         $dataFilter = $selectors[0]."_".$selectors[1];
         
         if($sectionSelector == 'genderRatio'){
             
             $this->zf_targetModel->GenderRatio($dataFilter); exit();
             
         }else if($sectionSelector == 'ageDistribution'){
             
             $this->zf_targetModel->AgeDistribution($dataFilter); exit();
             
         }else if($sectionSelector == 'maritalStatus'){
             
             $this->zf_targetModel->MaritalStatus($dataFilter); exit();
             
         }else if($sectionSelector == 'occupation'){
             
             $this->zf_targetModel->Occupation($dataFilter); exit();
             
         }else if($sectionSelector == 'annualIncome'){
             
             $this->zf_targetModel->AnnualIncome($dataFilter); exit();
             
         }
        
    }
    
    
    //5. THIS SECTION GENERATES THE CHARTS RELATED TO OCCUPATION ANALYSIS
    
    /**
     * This is the public method that analyses the education level chart
     */
    public function actionOccupationChartDrawer($selectionFilter){
        
         $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
         $selectors = explode("_", $rangeFilter);
         
         if(isset($_POST['dataFilter'])){
             
             $sectionSelector = $_POST['dataFilter'];
             
         }else{
             
              $sectionSelector = $selectors[2];
             
         }
         
         $dataFilter = $selectors[0]."_".$selectors[1];
         
         
         if($sectionSelector == 'genderRatio'){
             
             $this->zf_targetModel->GenderRatio($dataFilter); exit();
             
         }else if($sectionSelector == 'ageDistribution'){
             
             $this->zf_targetModel->AgeDistribution($dataFilter); exit();
             
         }else if($sectionSelector == 'educationLevel'){
             
             $this->zf_targetModel->EducationLevel($dataFilter); exit();
             
         }else if($sectionSelector == 'maritalStatus'){
             
             $this->zf_targetModel->MaritalStatus($dataFilter); exit();
             
         }else if($sectionSelector == 'annualIncome'){
             
             $this->zf_targetModel->AnnualIncome($dataFilter); exit();
             
         }
        
    }

  
    //6. THIS SECTION GENERATES THE CHARTS RELATED TO ANNUAL INCOME ANALYSIS
    
    /**
     * This is the public method that analyses the annual income chart
     */
    public function actionIncomeChartDrawer($selectionFilter){
        
         $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
         
         $dataFilter = $_POST['gender']."_".$_POST['ageBracket'];
         
         if($rangeFilter == 'genderRatio'){
             
             $this->zf_targetModel->GenderRatio($dataFilter); exit();
             
         }else if($rangeFilter == 'ageDistribution'){
             
             $this->zf_targetModel->AgeDistribution($dataFilter); exit();
             
         }else if($rangeFilter == 'maritalStatus'){
             
             $this->zf_targetModel->MaritalStatus($dataFilter); exit();
             
         }else if($rangeFilter == 'educationLevel'){
             
             $this->zf_targetModel->EducationLevel($dataFilter); exit();
             
         }else if($rangeFilter == 'occupation'){
             
             $this->zf_targetModel->Occupation($dataFilter); exit();
             
         }
        
    }
  
}
?>

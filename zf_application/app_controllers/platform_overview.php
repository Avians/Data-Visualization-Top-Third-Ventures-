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

class Platform_overviewController extends Zf_Controller {
   
    
    public $zf_defaultAction = "index";



    public function __construct() {
        
        /**
         * CALL THE CONSTRUCTOR OF THE PARENT CLASS.
         */
        parent::__construct();
        
    }

    
    /**
     * This is the index action for the controller
     */
    public function actionIndex($identificationCode){
        
        $identificationCode = Zf_SecureData::zf_decode_url($identificationCode);
        //echo "<pre>".$identificationCode."</pre>"; exit(); //This is strictly for debugging purposes
        
        //First the code the secure url, then decode the identification code to get back the array.
        $identificationCodeArray = Zf_Core_Functions::Zf_DecodeIdentificationCode($identificationCode);
        //echo "<pre>"; print_r($identificationCodeArray); echo "</pre>"; exit(); //This is strictly for debugging purposes
        
        if(Zf_SessionHandler::zf_getSessionVariable("LoggedIn") == true){
            
            $zf_actionData = $identificationCodeArray;
        
            Zf_View::zf_displayView('index', $zf_actionData);
            
        }else{
            
            Zf_GenerateLinks::zf_header_location('index', 'logout'); exit();
            
        }
  
    }
    
    
    /**
     * This is the action for executing various chart views.
     */
    public function actionGenderInformationProcessor($selectionFilter){
        
        $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
        
        if($rangeFilter == "ageBracket"){
            
            $this->zf_targetModel->GenderRatio(); exit();
            
        }
        
        
    }
    
    
    /**
     * This is the action for executing age distribution chart.
     */
    public function actionAgeInformationProcessor($selectionFilter){
        
        $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
        
        $rangeFilter = explode("_", $rangeFilter);
        
        $this->zf_targetModel->AgeDistribution($rangeFilter[1]);
        
    }
    
    
    /**
     * This is the action for executing education chart.
     */
    public function actionEducationInformationProcessor($selectionFilter){
        
        $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
        
        $rangeFilter = explode("_", $rangeFilter);
        
        $this->zf_targetModel->EducationLevel($rangeFilter[1]);    
        
    }
    
    /**
     * This is the action for executing marital status chart views.
     */
    public function actionMaritalInformationProcessor($selectionFilter){
        
        $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
        
        if($rangeFilter == "ageBracket"){
            
            $this->zf_targetModel->MaritalStatus(); exit();
            
        }
        
        
    }
    
    /**
     * This is the action for executing occupation chart.
     */
    public function actionOccupationInformationProcessor($selectionFilter){
        
        $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
        
        $rangeFilter = explode("_", $rangeFilter);
        
        $this->zf_targetModel->Occupation($rangeFilter[1]);
        
    }
    
    /**
     * This is the action for executing income chart views.
     */
    public function actionIncomeInformationProcessor($selectionFilter){
        
        $rangeFilter = Zf_SecureData::zf_decode_data($selectionFilter);
        
        if($rangeFilter == "ageBracket"){
            
            $this->zf_targetModel->AnnualIncome(); exit();
            
        }
        
        
    }
    
    

}
?>

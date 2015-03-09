<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS CLASS THAT IS ESSENTIAL FOR THE VALIDATION OF ALL FORM FIELDS FOR ANY
 * FORM BEING PROCESSED BY ANY MODEL IN ZILAS PHP FRAMEWORK. THIS CLASS RETURNS
 * EITHER VALID FORM DATA OR FORM ERRORS.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  28th/November/2013  Time: 14:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_FormController {
    
    
    /**
     * This is property that is used to instantiate the Zf_FormValidator library for 
     * validating various form fields.
     * 
     * @var type private
     */
    private $zf_formValidators = array();
    
    
    /**
     * This is property that is used to instantiate the Zf_FormError library for 
     * handling various form errors.
     * 
     * @var type public
     */
    public $zf_formErrorClass;
    
    
    /**
     * This is property that is used for handling all form errors.
     * 
     * @var type private
     */
    private $zf_formErrors = array();
    
    
    /**
     * This is property that is used to hold the form data that is currently 
     * being processed.
     * 
     * @var type private
     */
    private $zf_currentFormData = null;
    
    
    /**
     * This is property that is used to hold all the data that have been posted
     * by a given form.
     * 
     * @var type private
     */
    private $zf_postedFormData = array();
    
   

    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct() {
        
        
        /**
         * This is the class that is essential for validating all the posted
         * form data.
         */
        $this->zf_formValidators = new Zf_FormValidators();
        
        
        /**
         * This is the class that is essential for handling all the errors
         * found in the form data.
         */
        $this->zf_formErrorClass = new Zf_FormErrors();
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR POSTING ALL THE FORM 
     * DATA FOR PROCESSING.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public function zf_postFormData($zf_fieldName) {
        
        /**
         * Here we are posting the submitted form data ready for processing.
         */
        $this->zf_postedFormData[$zf_fieldName] = $_POST[$zf_fieldName];
        
        
        /**
         * Here we are keeping record of the current form data being posted for
         * processing.
         */
        $this->zf_currentFormData = $zf_fieldName;
        
        
        /**
         * Here we are returning this particular method, within the same class
         * there-by enabling data chaining.
         */
        return $this;

        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR VALIDATING ALL THE FORM 
     * DATA DURING PROCESSING.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public function zf_validateFormData($zf_typeOfValidator, $zf_validationArgumentOne = NULL, $zf_validationArgumentTwo = NULL) {
        
        /**
         * Check to find out if the validation argument is empty.
         */
        if($zf_validationArgumentOne == NULL){
            
            $zf_errorResult = $this->zf_formValidators->{$zf_typeOfValidator}($this->zf_postedFormData[$this->zf_currentFormData]);
            
        }else{
            
            if($zf_validationArgumentTwo == NULL){
                
                $zf_errorResult = $this->zf_formValidators->{$zf_typeOfValidator}($this->zf_postedFormData[$this->zf_currentFormData], $zf_validationArgumentOne);
                
            }else{
                
                $zf_errorResult = $this->zf_formValidators->{$zf_typeOfValidator}($this->zf_postedFormData[$this->zf_currentFormData], $zf_validationArgumentOne, $zf_validationArgumentTwo);
                
            }
            
        }
        
        if($zf_errorResult){
            
            $this->zf_formErrors[$this->zf_currentFormData] = $zf_errorResult;
            
        }
        
        /**
         * Here we are returning this particular method, within the same class
         * there-by enabling data chaining.
         */
        return $this;

        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR FETCHING ALL THE FORM 
     * VALID DATA AFTER PROCESSING.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public function zf_fetchValidData($zf_fieldName = FALSE) {
        
        if($zf_fieldName){
            
            if(isset($this->zf_postedFormData[$zf_fieldName])){
                
                return $this->zf_postedFormData[$zf_fieldName];
                
            }else {
                
                return FALSE;
                
            }
            
        }else{
            
            return $this->zf_postedFormData;
            
        }
        
        /**
         * Here we are returning this particular method, within the same class
         * there-by enabling data chaining.
         */
        return $this;

        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR FETCHING ALL THE FORM 
     * ERROR DATA AFTER PROCESSING.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public function zf_fetchErrorData() {
        
        if(empty($this->zf_formErrors)){
            
            return "";
            
        }else{
            
            return $this->zf_formErrors;
            
        }

        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR GENERATING SPECIFIC FIELD 
     * OUTCOME INCASE OF ANY FIELD ERROR.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public static function zf_validateSpecificField($zf_validResult, $zf_errorResult) {
        
        /**
         * An instance of the same class within a static method
         */
        $zf_failedFormResult = new self;
  
        foreach ($zf_validResult as $zf_validField => $zf_validValue) {

            if ($zf_validField == $zf_errorResult['zf_fieldName']) {

                //echo $zf_validField." ==> ",$zf_validValue; exit(); //This is strictly for debugging purpose.
                $zf_failedFormResult->zf_formErrorClass->zf_setFormValue($zf_errorResult['zf_fieldName'], $zf_validValue);
                $zf_failedFormResult->zf_formErrorClass->zf_setFormError($zf_errorResult['zf_fieldName'], $zf_errorResult['zf_errorMessage']);

            } else {

                //echo "<br>".$zf_validField."=>".$zf_validValue."<br>"; //exit(); //This is strictly for debugging purposes.
                $zf_failedFormResult->zf_formErrorClass->zf_setFormValue($zf_validField, $zf_validValue);

            }

        }
        
        //print_r($zf_failedFormResult->zf_formErrorClass->zf_formErrorArray()); exit(); //This is strictly for debugging purposes.
        Zf_SessionHandler::zf_setSessionVariable("zf_valueArray", $_POST);
        Zf_SessionHandler::zf_setSessionVariable("zf_errorArray", $zf_failedFormResult->zf_formErrorClass->zf_formErrorArray());
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR GENERATING ALL THE FORM 
     * OUTCOME INCASE OF ANY FORM ERRORS. i.e THE GENERAL FORM
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public static function zf_validateGeneralForm($zf_validResult, $zf_errorResult) {
        
        /**
         * An instance of the same class within a static method
         */
        $zf_failedFormResult = new self;
            
        foreach ($zf_validResult as $zf_validField => $zf_validValue) {

            foreach ($zf_errorResult as $zf_errorField => $zf_errorValue) {

                if ($zf_errorField == $zf_validField) {

                    //echo "<br>".$zf_validField."=>".$zf_validValue.$zf_errorValue."<br>"; //exit(); //This is strictly for debugging purposes.
                    $zf_failedFormResult->zf_formErrorClass->zf_setFormValue($zf_validField, $zf_validValue);
                    $zf_failedFormResult->zf_formErrorClass->zf_setFormError($zf_validField, $zf_errorValue);

                } else {

                    //echo "<br>".$zf_validField."=>".$zf_validValue."<br>"; //exit(); //This is strictly for debugging purposes.
                    $zf_failedFormResult->zf_formErrorClass->zf_setFormValue($zf_validField, $zf_validValue);

                }

            }

        }
        
        //print_r($zf_failedFormResult->zf_formErrorClass->zf_formErrorArray()); exit(); //This is strictly for debugging purposes.
        Zf_SessionHandler::zf_setSessionVariable("zf_valueArray", $_POST);
        Zf_SessionHandler::zf_setSessionVariable("zf_errorArray", $zf_failedFormResult->zf_formErrorClass->zf_formErrorArray());
        
    }
    

}

?>

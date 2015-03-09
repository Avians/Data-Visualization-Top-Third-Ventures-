<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS CLASS THAT IS ESSENTIAL FOR REPORTING ALL THE NOTICED FORM ERRORS 
 * FROM THE FORM CURRENTLY BEING PROCESSED.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  28th/November/2013  Time: 15:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_FormErrors{
    
    /**
     * This is property that is used to hold all the values submitted within 
     * given form fields.
     * 
     * @var type private
     */
    private $zf_formValues = array();
    
    
    /**
     * This is property that is used to hold all the errors submitted from
     * given form fields.
     * 
     * @var type private
     */
    private $zf_formErrors = array();
    
    
    /**
     * This is property that is used to hold the total number of form errors 
     * encountered during the form processing.
     * 
     * @var type private
     */
    private $zf_numberOfErrors;
    
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
     public function __construct() {
     
         if(isset($_SESSION['zf_valueArray']) && isset($_SESSION['zf_errorArray'])){
             
             $this->zf_formValues = $_SESSION['zf_valueArray'];
             $this->zf_formErrors = $_SESSION['zf_errorArray'];
             $this->zf_numberOfErrors = count($this->zf_formErrors);

         }else{
             
             $this->zf_numberOfErrors = 0;
             
         }
         
     }
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS DESTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
     public function __destruct() {
         
         unset($this->zf_formValues);
         unset($this->zf_formErrors);
         
     }
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CONCATINATING A GIVEN 
     * FORM VALUE TO A RELATED FORM FIELD.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
     public function zf_setFormValue($zf_formField, $zf_formValue){
         
         $this->zf_formValues[$zf_formField] = $zf_formValue;
         
     } 
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CONCATINATING A GIVEN 
     * FORM ERROR MESSAGE TO A RELATED FORM FIELD.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
     public function zf_setFormError($zf_formField, $zf_errorMessage){
         
         $this->zf_formErrors[$zf_formField] = $zf_errorMessage;
         $this->zf_numberOfErrors = count($this->zf_formErrors);
         
     } 
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR RETURNING A FORM VALUE
     * RELATED TO A GIVEN FORM FIELD.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
     public function zf_getFormValue($zf_fieldName){
         
         if(array_key_exists($zf_fieldName, $this->zf_formValues)){
             
             return htmlspecialchars(stripslashes($this->zf_formValues[$zf_fieldName]));
             
         }else{
             
             return "";
             
         }
         
     } 
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR RETURNING A FORM ERROR
     * RELATED TO A GIVEN FORM FIELD. 
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
     public function zf_getFormError($zf_fieldName){
         
         if(array_key_exists($zf_fieldName, $this->zf_formValues)){
             
             return "<div class='errorimg'>".$this->zf_formErrors[$zf_fieldName]."</div>";
             
         }else{
             
             return "";
             
         }
         
     } 
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR RETURNING A FORM ERROR
     * RELATED TO A GIVEN FORM FIELD. 
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
     public function zf_formErrorValue($zf_fieldName){
         
         if(array_key_exists($zf_fieldName, $this->zf_formErrors)){
             
             return $this->zf_formErrors[$zf_fieldName];
             
         }else{
             
             return "";
             
         }
         
     } 
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR RETURNING THE ARRAY THAT
     * CARRIES ALL THE FORM ERRORS. 
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
     public function zf_formErrorArray(){
         
         return $this->zf_formErrors;
         
     } 
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR COUNTING THE NUMBER OF
     * ERRORS ENCOUNTERED IN A GIVEN FORM. 
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
     public function zf_countFormErrors(){
            
         return $this->zf_numberOfErrors;
         
     } 
     
     
}

?>

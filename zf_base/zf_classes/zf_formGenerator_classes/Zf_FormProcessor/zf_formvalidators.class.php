<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS CLASS THAT IS ESSENTIAL FOR THE VALIDATION OF ALL FORM FIELDS FOR ANY
 * FORM BEING PROCESSED AGAINST A SET OF FORM VALIDATION RULES SPECIFIED HERE-IN
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

class Zf_FormValidators{
    
    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
     public function __construct() {
     
         
         
     }
     
     /**
      * -------------------------------------------------------------------------
      * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CHECKING THAT A FORM 
      * FIELD IS NOT EMPTY.
      * -------------------------------------------------------------------------
      * @var method
      * @access public 
      */
     public function zf_fieldNotEmpty($zf_fieldData, $zf_fieldName){
         
         if($zf_fieldData == ""){
            
            return "* {$zf_fieldName} cannot be empty.";
            
        }
         
     }
     
     
     /**
      * -------------------------------------------------------------------------
      * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CHECKING THAT A FORM 
      * FIELD DATA MEETS THE MINIMUM CHARACTER LENGTH CONDITIONS.
      * -------------------------------------------------------------------------
      * @var method
      * @access public 
      */
     public function zf_minimumLength($zf_data, $zf_argument, $zf_fieldName){
        
        if(strlen($zf_data) < $zf_argument){
            
            $zf_fieldName = ucfirst($zf_fieldName);
            
            return "* {$zf_fieldName}, minimum {$zf_argument} characters long.";
            
        }
        
    }
    
    
    /**
      * -------------------------------------------------------------------------
      * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CHECKING THAT A FORM 
      * FIELD DATA MEETS THE MAXIMUM CHARACTER LENGTH CONDITIONS.
      * -------------------------------------------------------------------------
      * @var method
      * @access public 
      */
    public function zf_maximumLength($zf_data, $zf_argument, $zf_fieldName){
        
        if(strlen($zf_data) > $zf_argument){
            
            $zf_fieldName = ucfirst($zf_fieldName);
            
            return "* {$zf_fieldName}, maximum {$zf_argument} characters long.";
            
        }
        
    }
    
    
    /**
      * -------------------------------------------------------------------------
      * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CHECKING THAT A FORM 
      * FIELD PASSWORD DATA IS HAS A STRONG COMBINATION.
      * -------------------------------------------------------------------------
      * @var method
      * @access public 
      */
    public function zf_notStrongPassword($zf_data){
        
        if (!preg_match('/[a-z|A-Z]+[0-9]+/', $zf_data)){
            
            return "* Password MUST be alphanumeric.";
            
        }
        
    }
    
    
    /**
      * -------------------------------------------------------------------------
      * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CHECKING THAT A FORM 
      * FIELD DATA CONSISTS ONLY OF INTEGERS.
      * -------------------------------------------------------------------------
      * @var method
      * @access public 
      */
    public function zf_integerData($zf_data, $zf_fieldName){
        
        if(ctype_digit($zf_data) == false){
            
            return "* {$zf_fieldName} MUST only be digits.";
            
        }
        
    }
    
    
    /**
      * -------------------------------------------------------------------------
      * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CHECKING THAT A FORM 
      * FIELD DATA CONSISTS ONLY OF CHARACTERS.
      * -------------------------------------------------------------------------
      * @var method
      * @access public 
      */
    public function zf_characterData($zf_data, $zf_fieldName){
        
        if(ctype_alpha($zf_data) == false){
            
            return "* {$zf_fieldName} MUST only be alphabets.";
            
        }
        
    }
     
     
    /**
      * -------------------------------------------------------------------------
      * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR CHECKING THAT A FORM 
      * FIELD CONTAINS A VALID FORMAT FOR AN EMAIL ADDRESS.
      * -------------------------------------------------------------------------
      * @var method
      * @access public 
      */
    public function zf_checkEmail($zf_fieldData){
        
        $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"."\.([a-z]{2,}){1}$";
        
        if(!mb_eregi($regex, $zf_fieldData)){
            
            return "* The email format is invalid.";
            
        }
        
    }
     
     
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR THROWING AN EXCEPTION
     * WHEN AN INVALID VALIDATION RULE IS INVOKED AGAINST ANY FIELD DATA.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public function __call($zf_validationRule, $zf_validationArguments) {

        throw new Exception("{$zf_validationRule} does not exist inside of : " . __CLASS__);
        
    }
    
}

?>

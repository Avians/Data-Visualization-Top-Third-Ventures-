<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR ACCESSING ENCRYPTION AND DECRYPTION METHODS
 * FROM ENCRYPTION AND DECRYPTION CLASS. IT FIRST CHECKS IF THE ENCRYPTION KEY
 * HAS BEEN SET AND ALSO IF ENCRYPTION HAS BEEN ENABLED IN THE WHOLE FRAMEWORK.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  27th/September/2013  Time: 13:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_SecureData extends Zf_EncryptionDecryption {

    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct() {
        
        parent::__construct();
            
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS STATIC METHOD THAT CHECKS IF DATA ENCODING AND DECODING HAS BEEN 
     * ENABLED AND IF THE ENCRYPTION KEY HAS ALSO BEEN PASSED. 
     * -------------------------------------------------------------------------
     */
    private static function zf_encryption_checks(){
        
        $security_details = Zf_Configurations::Zf_ApplicationDefaults();
        
        /**
         * Here we check if the encryption/decryption key has been set or not.
         */
        if(empty($security_details['security_key'])){
            
            return 1; //You need to set security key first.
            
        }else{
            
            if($security_details['application_encryption'] == "enabled"){
                
                return 3; //You are free to encrypt your data.
                
            }else{
                
                return 2; // You are not allowed to encrypt your data.
                
            }
   
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR ENCODING ALL THE DATA AS 
     * LONG AS DATA DECODING AND DECODING HAS BEEN ENABLED AND THE ENCRYPTION 
     * KEY HAS BEEN SET. 
     * -------------------------------------------------------------------------
     */
    public static function zf_encode_data($zf_unsecure_data){
        
        $security_status = self::zf_encryption_checks();
        
        if($security_status === 1){
            
            echo "<code>You must set encryption/decryption key before you can encrypt or decrypt any data!!</code><br>";
            
        }else if($security_status === 2){
            
            echo "<code>To encrypt any data, you must enable application encryption.</code><br>";
            
        }else if($security_status === 3){
            
             return Zf_EncryptionDecryption::zf_data_encode($zf_unsecure_data);
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS STATIC METHOD THAT CHECKS IF DATA ENCODING AND DECODING HAS BEEN 
     * ENABLED AND IF THE ENCRYPTION KEY HAS ALSO BEEN PASSED. 
     * -------------------------------------------------------------------------
     */
    public static function zf_decryption_checks(){
        
        $security_details = Zf_Configurations::Zf_ApplicationDefaults();
        
        /**
         * Here we check if the encryption/decryption key has been set or not.
         */
        if(empty($security_details['security_key'])){
            
            return 1; //You need to set security key first.
            
        }else{
            
            if($security_details['application_decryption'] == "enabled"){
                
                return 3; //You are free to decrypt your data.
                
            }else{
                
                return 2; // You are not allowed to decrypt your data.
                
            }
   
        }
        
    }
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR DECODING ALL THE DATA AS 
     * LONG AS DATA DECODING AND DECODING HAS BEEN ENABLED AND THE ENCRYPTION 
     * KEY HAS BEEN SET. 
     * -------------------------------------------------------------------------
     */
    public static function zf_decode_data($zf_secure_data){
        
        $security_status = self::zf_decryption_checks();
        
        if($security_status === 1){
            
            echo "<code>You must set encryption/decryption key before you can encrypt or decrypt any data!!</code><br>";
            
        }else if($security_status === 2){
            
            echo "<code>To decrypt any data, you must enable application decryption.</code><br>";
            
        }else if($security_status === 3){
            
            return Zf_EncryptionDecryption::zf_data_decode($zf_secure_data);
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD SPECIFIC FOR DECODING ENCRYPTED URL. ITS CHECKS
     * THE CONSTANT FOR ENCRYTING URL HAS BEEN ENABLED.IF NO, AN ERROR IT THROWS
     * AN ERROR, ELSE IT DECODES THE URL INTO ITS READABLE FORM.
     * -------------------------------------------------------------------------
     */
    public static function zf_encode_url($zf_unsecure_url){
        
        $security_details = Zf_Configurations::Zf_ApplicationDefaults();
        
        //check if the ability to encrypt a URL has been enabled.
        if($security_details['application_urlencrypt'] == "enabled"){

            return self::zf_encode_data(self::zf_encode_data($zf_unsecure_url));

        }else{

            echo "<code><strong>Error:</strong>You are trying to encrypt a URL without enabling URL encryption.</code><br>";

        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD SPECIFIC FOR DECODING ENCRYPTED URL. ITS CHECKS
     * THE CONSTANT FOR ENCRYTING URL HAS BEEN ENABLED.IF NO, AN ERROR IT THROWS
     * AN ERROR, ELSE IT DECODES THE URL INTO ITS READABLE FORM.
     * -------------------------------------------------------------------------
     */
    public static function zf_decode_url($zf_secure_url){
        
        $security_details = Zf_Configurations::Zf_ApplicationDefaults();
        
        //check if the ability to encrypt a URL has been enabled.
        if($security_details['application_urlencrypt'] == "enabled"){

            return self::zf_decode_data(self::zf_decode_data($zf_secure_url));

        }else{

            echo "<code><strong>Error:</strong>You are trying to decrypt a URL that has not been encrypted.</code><br>";

        }
        
    }

}
?>

<?php
//THIS CODE IS WRITTEN AND MODIFIED BY ATHIAS AVIANS, THE CHIEF AND CORE DEVELOPER OF ZILAS PROJECT.
/*
 *This is the core session class for the whole framework. 
 * It does all the task necessary in ensuring that a session is tracked properly.
 */

/*
 * This class can be accessed from anywhere through its static methods within zilas framework.
 */
class Zf_SessionHandler{
    
    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct(){
	
        
    }
	
        
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC STATIC METHOD THAT IS ESSENTIAL FOR STARTING A GIVEN
     * SESSION WITHIN THE FRAMEWORK.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public static function zf_sessionInit() {

        @session_start(); //Here we ensure that the session is started whenever the method is called.
        
    }
    

    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR SETTING A SESSION
     * VARIABLE.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public static function zf_setSessionVariable($zf_sessionKey, $zf_sessionValue) {
        
        $_SESSION[$zf_sessionKey] = $zf_sessionValue; //This sets a given value to a particular session key.
        
    }
    

    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR RETRIEVING A SESSION 
     * VARIABLE.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public static function zf_getSessionVariable($zf_sessionKey) {
        
        if (isset($_SESSION[$zf_sessionKey])) {
            
            return $_SESSION[$zf_sessionKey]; //This returns the valid session key.
            
        }
        
    }
    

    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR UNSETTING SESSION
     * VARIABLE(S) THAT HAS BEEN SET.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public static function zf_unsetSessionVariable($zf_sessionKey) {
        
        unset($_SESSION[$zf_sessionKey]); //here we unset all the session that had been initially set.
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC METHOD THAT IS ESSENTIAL FOR DESTROYING A SESSION
     * THAT HAS BEEN HAS BEEN STARTED
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public static function zf_sessionDestroy() {
        
        @session_destroy(); //Here we destroy all the initally set session.
        
    }

}
?>

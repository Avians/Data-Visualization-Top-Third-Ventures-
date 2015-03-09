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

class IndexController extends Zf_Controller {
   
    
    public $zf_defaultAction = "login";



    public function __construct() {
        
        /**
         * CALL THE CONSTRUCTOR OF THE PARENT CLASS.
         */
        parent::__construct();
        
    }

    /**
     * =========================================================================
     * HERE WE RENDER THE VIEW FOR ALL THE FORMS
     * =========================================================================
     */
    
    /**
     * This is the index action for the controller
     */
    public function actionLogin(){
        
        Zf_View::zf_displayView('login'); exit();
        
    }
    
    /**
     * This is the reset password action for the controller
     */
    public function actionReset_password(){
        
        Zf_View::zf_displayView('reset_password'); exit();
        
    }
    
    /**
     * This is the sign-up action for the controller
     */
    public function actionSign_up(){
        
        Zf_View::zf_displayView('sign_up'); exit();
        
    }
    
    /**
     * This is the lock screen action for the controller
     */
    public function actionLock_screen(){
        
        Zf_View::zf_displayView('lock_screen');
        
    }


    /**
     * This is the logout action for the controller
     */
    public function actionLogout(){
        
        //unset all the set sessions, then redirect to the login page.
        Zf_SessionHandler::zf_unsetSessionVariable('LoggedIn');
        Zf_SessionHandler::zf_unsetSessionVariable('ttv_identificationCode');
        Zf_SessionHandler::zf_sessionDestroy();
        Zf_GenerateLinks::zf_header_location('index'); exit();
        
    }

        /**
     * =========================================================================
     * HERE WE PROCESSES THE FORMS IN THE RELATED MODELS
     * =========================================================================
     */
    
    public function actionProcessGuestUser($guestAction){
        
        $guestAction = Zf_SecureData::zf_decode_url($guestAction);
        
        if($guestAction === 'login'){
            
            $this->zf_targetModel->processLogin(); exit();
            
        }
        
        if($guestAction === 'reset_password'){
            
            $this->zf_targetModel->processReset_password(); exit();
            
        }
        
        if($guestAction === 'sign_up'){
            
            $this->zf_targetModel->processSign_up(); exit();
            
        }
        
        
    }
    
    
    /**
     * =========================================================================
     * HERE WE ACTIVATE THE SIGN-UPS BASED ON THE LIKN CLICKED ON THE EMAIL
     * =========================================================================
     */
    public function actionActivateSign_up($confirm_subscription = NULL){
        
        if($confirm_subscription != NULL && !empty($confirm_subscription)){
            
            $confirm_email = Zf_SecureData::zf_decode_url($confirm_subscription);
            
            $this->zf_targetModel->processConfirmActivation($confirm_email);
            exit();
            
        }
        
    }
    
    

}
?>

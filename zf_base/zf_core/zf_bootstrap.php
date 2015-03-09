<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS BOOTSTRAP FILE FOR ZILAS PHP FRAMEWORK. THE CLASS CAREFULLY ANALYISES
 * THE PASSED URL, CLEANS IT UP AND THEN EXECUTES THE RELATED CONTROLLER AND 
 * CONSEQUENTLY THE ACTIONS, BASED ON WHETHER A MODEL OR A VIEW IS REQUIRED OR
 * BOTH
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  12th/August/2013  Time: 09:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */


/**
 * -----------------------------------------------------------------------------
 * HERE WE REQUIRE THE APPLICATION CORE FUNCTIONS FILE, WHICH HOLDS ALL THE
 * MAJOR DEFAULT FUNCTIONS
 * -----------------------------------------------------------------------------
 * 
 */
require_once ZF_FUNCTIONS."zf_core_functions.php";

/**
 * -----------------------------------------------------------------------------
 * HERE WE REQUIRE THE APPLICATION CORE FUNCTIONS FILE, WHICH HOLDS ALL THE
 * MAJOR DEFAULT FUNCTIONS
 * -----------------------------------------------------------------------------
 * 
 */
require_once ZF_BASE."zf_assets/assets_settings.php";


/**
 * -----------------------------------------------------------------------------
 * HERE WE REQUIRE THE APPLICATION ERRORS CONSTANTS FILE, WHICH HOLDS ALL THE 
 * CONSTANTS USED TO PUBLISH VARIOUS ZILAS APPLICATION ERRORS.
 * -----------------------------------------------------------------------------
 * 
 */
require_once ZF_CONSTANTS."zf_error_constants.php";



class Zf_Bootstrap{
    
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
     * THIS IS THE MAIN STATIC METHOD FOR RUNNING THE WHOLE APPLICATION. THIS
     * CAREFULLY ANALYSES THE REQUESTS AND EXECUTES THE CONTROLLERS AND ACTIONS
     * AS REQUESTDED.
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_run(){
        
        /**
         * ---------------------------------------------------------------------
         * CHECKS IF THE INSTALLATION FILE EXISTS. IF YES, INSTALLATION IS DONE
         * AND THE INSTALLATION FILE GETS AUTOMATICALLY DELETED, ELSE, THE
         * ZILAS APPLICATION LOADS VIA THE REQUSTED CONTROLLER.
         * ---------------------------------------------------------------------
         */
        
        
        //echo "Our application is running from: <b>".__FILE__."</b><br>"; //THIS IS STRICTLY FOR DEBUGGING PURPOSES.
        //echo ZF_ROOT_PATH."<br>"; //THIS IS STRICTLY FOR DEBUGGING PURPOSES.
        
        /**
         * ---------------------------------------------------------------------
         * CHECK FOR THE EXISTANCE OF AN INSTALLATION FILE, IF THERE IS, THE
         * INSTALLATION PROCESS IS RAN, ELSE THE DEFAULT BOOTSTRAP ANALYTICAL 
         * PROCESS IS EXECUTED. 
         * ---------------------------------------------------------------------
         * 
         */
        if(file_exists(INSTALLATION_FILE)){
            
            echo "We are about to install Zilas PHP Framework."; //THIS IS STRICTLY FOR DEBUGGING PURPOSES.
            
            
            exit();
            
        }else{
           
            //echo "We are ready to run Our Zilas Framework Application."; //THIS IS STRICTLY FOR DEBUGGING PURPOSES.
            
            $zf_applicationStatus   = Zf_Configurations::Zf_ApplicationStatus();
     
            
            /**
             * SANITIZE THE PASSED URL TO OBTAIN AN ARRAY OF THE URL PARTS.
             */
            $zf_controllerURL = Zf_Core_Functions::Zf_URLSanitize();


            /**
             * This is a variable that holds the current controller executing. 
             */
            @$controllerURL = $zf_controllerURL[0];


            /**
             * This is a variable that holds the current action executing. 
             */
            @$actionURL = $zf_controllerURL[1];


            /**
             * This is a variable that holds the current parameter being passed into the executing action. 
             */
            @$parameterURL = $zf_controllerURL[2];


            /**
             * Loads the applications default controller from "app_configuration.php" file.
             */
            @$zf_default_controller = explode("-", $zf_applicationStatus['default_controller']);
            
            
            /**
             * -----------------------------------------------------------------
             * CHECK FOR THE APPLICATION STATUS AND SEE IF THA APPLICATION IS 
             * ENABLED OR DISABLED
             * -----------------------------------------------------------------
             * 
             */

            if($zf_applicationStatus['application_status'] === 'disabled'){ //APPLICATION IS IN CONSTRUCTION MODE, THUS DISABLED.
                
                
                if($zf_applicationStatus['construction_indicator'] == 'default'){ //CONSTRUCTION INDICATOR IS DEFAULT
                    
                    /**
                     * Require the default application construction contoller file from the system assets directory.
                     */
                    require_once ASSETS_CONTROLLERS."zf_default_construction.php";
                    
                    
                    /**
                     * Create an instance of the Zf_ApplicationConstructionController class
                     */
                    $zf_controller  = new Zf_Default_ConstructionController();
                    
                    
                    
                    /**
                     * Execute the actions within the system selected controller
                     */
                    $defaultAction = "action" . ucfirst($zf_controller->zf_defaultAction);

                    if (method_exists($zf_controller, $defaultAction)) {
                         
                        /**
                         * Execute the default action for the construction custom controller
                         */
                         $zf_controller->{$defaultAction}();
  
                    }
                    
                    /**
                     * Exit to stop execution of the code any further.
                     */
                    exit();
                    
                }else{ //CONSTRUCTION INDICATOR IS CUSTOM
                    
                    /**
                     * Require the default application construction contoller file from the system assets directory.
                     */
                    require_once APP_CONTROLLERS_ASSETS."zf_custom_construction.php";
                    
        
                    /**
                     * Create an instance of the Zf_ApplicationConstructionController class
                     */
                    $zf_controller  = new Zf_Custom_ConstructionController();
                    
                    
                    /**
                     * Execute the actions within the system selected controller
                     */
                     $defaultAction = "action" . ucfirst($zf_controller->zf_defaultAction);

                     if (method_exists($zf_controller, $defaultAction)) { 
                         
                        /**
                         * Execute the default action for the construction custom controller
                         */
                         $zf_controller->{$defaultAction}();
  
                    }
                    
                    /**
                     * Exit to stop execution of the code any further.
                     */
                    exit();
                
                }
                
                
            }else{ //THE APPLICATION IS IN PRODUCTION MODE.
               
               /**
                * THE APPLICATION CAN EITHER BE RUNNING ON A DEFAULT CONTROLLER 
                * OR ON A SYSTEM SPECIFIED CONTROLLER.
                * 
                */
                
                if(empty($controllerURL) || ($controllerURL == $zf_default_controller[0])){
                    
                    /**
                     * Require the default controller file.
                     */
                    $zf_controllerFile  =  APP_CONTROLLERS.$zf_default_controller[0].".php";
                    
                    if(file_exists($zf_controllerFile)){
                        
                        /**
                         * Require the system default controller file for usage.
                         */
                        require_once $zf_controllerFile;
                        
                        
                        /**
                         * Creates an instance of the default controller.
                         */
                        $zf_controllerInstance = ucfirst($zf_default_controller[0]) . "Controller";
                        $zf_controller = new $zf_controllerInstance;
                        
                        
                        /**
                         * Execute the actions within the system default controller
                         */
                        
                        if(empty($actionURL) || ($actionURL === $zf_controller->zf_defaultAction)){
                            
                            /**
                             * Load a related model if it exist.
                             */
                            $zf_controller->Zf_loadModel($zf_default_controller[0], $zf_controller->zf_defaultAction);
                            
                            /**
                             * Execute the default action of the default controller
                             */
                            self::zf_executeDefaultActions($zf_controller, $parameterURL);
                            
                            
                        }else{
                            
                            /**
                             * Load a related model if it exist.
                             */
                            $zf_controller->Zf_loadModel($zf_default_controller[0], $actionURL);
                            
                            /**
                             * Execute the selected action of the default controller
                             */
                            self::zf_executeSelectedActions($zf_controller, $actionURL, $parameterURL);
                            
                        }
                       
                    }else{
                        
                        /**
                         *ERROR REPORTING: Default controller not set or an invalid controller 
                         */
                        self::Zf_routingErrors(ERROR_INVALID_DEFAULT_CONTROLLER); 
                        
                    }
                    
                    /**
                     * Exit to stop execution of the code any further.
                     */
                    exit();
                    
                }else{
                    
                    /**
                     * We are constructing the Controller file.
                     */
                    $zf_controllerFile = APP_CONTROLLERS.$zf_controllerURL[0].".php";
                    
                    
                    /**
                     * We check if the constructed controller file exists and is
                     * valid.
                     */
                    if(file_exists($zf_controllerFile)){
                        
                        /**
                         * Require the system selected controller file for usage.
                         */
                        require_once $zf_controllerFile;
                        
                        
                        /**
                         * Creates an instance of the system selected controller.
                         */
                        $zf_controllerInstance = ucfirst($controllerURL)."Controller"; 
                        $zf_controller = new $zf_controllerInstance;
                        
                        
                        /**
                         * Execute the actions within the system selected controller
                         */
                        
                        if(empty($actionURL) || ($actionURL === $zf_controller->zf_defaultAction)){
                            
                            /**
                             * Load a related model if it exist.
                             */
                            $zf_controller->Zf_loadModel($controllerURL, $zf_controller->zf_defaultAction);
                            
                            /**
                             * Execute the default action of the selected controller
                             */
                            self::zf_executeDefaultActions($zf_controller, $parameterURL);
                            
                        }else{
                            
                            /**
                             * Load a related model if it exist.
                             */
                            $zf_controller->Zf_loadModel($controllerURL, $actionURL);
                            
                            /**
                             * Execute the selected action of the selected controller
                             */
                            self::zf_executeSelectedActions($zf_controller, $actionURL, $parameterURL);
                            
                        }
                        
                        
                    }else{
                        
                        /**
                         * ERROR REPORTING: Selected controller not set or an invalid controller 
                         */
                        self::Zf_routingErrors(ERROR_INVALID_SELECTED_CONTROLLER);
                        
                    }
                    
                }
                
            }
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT IS RESPONSIBLE FOR THE EXECUTION OF THE
     * DEFAULT ACTION SPECIFIED INSIDE ANY CONTROLLER.
     * 
     * -------------------------------------------------------------------------
     */
    
    public static function zf_executeDefaultActions($zf_controller,  $parameterURL){
        
        $zf_applicationDefaults = Zf_Configurations::Zf_ApplicationDefaults();
        
        /**
         * Check for the presence of a default action or it 
         * absence in the system defualt controller.
         */
        if (($zf_controller->zf_defaultAction != "")) {

            /**
             * Return all the methods in the system default controller and
             * check if the default action is one of them.
             */
            $defaultAction = "action" . ucfirst($zf_controller->zf_defaultAction);

            if (method_exists($zf_controller, $defaultAction)) {

                /**
                 * Check if a parameter has been passed into the default action
                 * or no parameter has been passed.
                 */
                if (isset($parameterURL)) {

                    /**
                     * check if the parameter passed in the URL needs to be
                     * ecrypted or does not need encryption.
                     */
                    if ($zf_applicationDefaults['application_urlencrypt'] == 'enabled') {

                        $zf_parameter = Zf_SecureData::zf_encode_data($parameterURL);
                        
                    } else {

                        $zf_parameter = $parameterURL;
                        
                    }

                    /**
                     * THERE IS A PARAMETER SO WE EXECUTE THE DEFAULT ACTION TOGETHER
                     * WITH THE PASSED PARAMETER.
                     * 
                     */
                    $zf_controller->{$defaultAction}($zf_parameter);
                    
                    
                } else {

                    /**
                     * THERE IS NOT A PARAMETER SO WE JUST EXECUTE THE DEFAULT ACTION
                     * 
                     */
                    $zf_controller->$defaultAction();
                    
                    
                }
            } else {

                /**
                 * ERROR REPORTING: Invalid Default Action Error
                 */
                self::Zf_routingErrors(ERROR_INVALID_DEFAULT_ACTION);
                
            }
        } else {

            /**
             * ERROR REPORTING: Default Action not set or wrong default action
             */
            self::Zf_routingErrors(ERROR_NOT_SET_DEFAULT_ACTION);
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT IS RESPONSIBLE FOR THE EXECUTION OF THE
     * SELECTED ACTION SPECIFIED INSIDE ANY CONTROLLER.
     * 
     * -------------------------------------------------------------------------
     */
    public static function zf_executeSelectedActions($zf_controller, $actionURL, $parameterURL){
        
        $zf_applicationDefaults = Zf_Configurations::Zf_ApplicationDefaults();
        
        /**
         * Check for the presence of a selected action or its 
         * absence in the system defualt controller.
         */
        $selectedAction = "action" . ucfirst($actionURL);

        if (method_exists($zf_controller, $selectedAction)) {

            /**
             * Check if a parameter has been passed into the default action
             * or no parameter has been passed.
             */
            if (isset($parameterURL)) {

                /**
                 * check if the parameter passed in the URL needs to be
                 * ecrypted or does not encryption.
                 */
                if ($zf_applicationDefaults['application_urlencrypt'] == 'enabled') {

                    $zf_parameter = Zf_SecureData::zf_encode_data($parameterURL);
                    
                } else {

                    $zf_parameter = $parameterURL;
                    
                }

                /**
                 * THERE IS A PARAMETER SO WE EXECUTE THE SELECTED ACTION TOGETHER
                 * WITH THE PASSED PARAMETER.
                 * 
                 */
                $zf_controller->{$selectedAction}($zf_parameter);
                
                
            } else {

                /**
                 * THERE IS NOT A PARAMETER SO WE JUST EXECUTE THE SELECTED ACTION
                 * 
                 */
                $zf_controller->$selectedAction();
                
            }
            
        } else {

            /**
             * ERROR REPORTING: Invalid Selected Action Error
             */
            self::Zf_routingErrors(ERROR_INVALID_SELECTED_ACTION);
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PRIVATE STATIC METHOD THAT IS RESPONSIBLE FOR THE ROUTING OF
     * ALL ZILAS FRAMEWORK BOUND ERROR THUS EXECUTING THE MOST RELEVANT VIEW.
     * -------------------------------------------------------------------------
     * 
     */
    private static function Zf_routingErrors($errorParameters){
        
        /**
         * Require the default application error contoller file from the system assets directory.
         */
        require_once ASSETS_CONTROLLERS . "zf_default_errors.php";
        
        
        /**
         * Create an instance of the Zf_ApplicationConstructionController class
         */
        $zf_errorController = new Zf_Default_ErrorsController();
        
        
        /**
         * We then execute the particular error  
         */
        $zf_errorController->zf_runErrors($errorParameters);
        
        return FALSE;
        
    }
    
    
}
?>

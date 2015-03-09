<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE CORE VIEW FOR ZILAS PHP FRAMEWORK. IT IS RESPONSIBLE FOR EXECUTION
 * OF ALL APPLICATION VIEWS.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  14th/August/2013  Time: 11:30 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013 (sunday)
 * 
 */


class Zf_View {
    
    /**
     * THIS IS PUBLIC PROPERTY IS USED TO HOLD AN INSTANCE OF THE FORM ERROR
     * CLASS.
     */
     public $zf_formErrorHandler;
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct() {
        
       /**
        * THIS IS AN INSTANCE OF THE FORM ERROR HANDLING CLASS.
        * It is essential for handling all the related form errors
        */
        $this->zf_formErrorHandler = new Zf_FormErrors();
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC PUBLIC METHOD RESPONSIBLE FOR THE RENDERING OF ALL THE
     * VIEWS TO THE BROWSER. ITS ACCEPTS TWO PARAMETERS I.E. THE VIEW NAME AND 
     * DATA THAT GOES INTO THE RENDERED VIEW. THE SECOND PARAMETER CAN BE AN 
     * VARIABLE OR AN A ARRAY.
     * -------------------------------------------------------------------------
     */
    //public static function zf_displayView($zf_targetView, $zf_actionData = NULL,  $zf_table = "zgb_guests", $zf_gridSettings = NULL, $zf_tableActions = NULL, $zf_tableColumns = NULL, $zf_tableQuery = NULL) {
    public static function zf_displayView($zf_targetView, $zf_actionData = NULL,  $zf_phpGridSettings = NULL) {
        
       $zf_applicationDefaults   = Zf_Configurations::Zf_ApplicationDefaults();
        
       if($zf_applicationDefaults['application_phpgrid'] == 'enabled'){ 
           
            @require_once ZF_PLUGINS.'zf_phpgrid'.DS.'grid_settings.php';
       
       }
       
       if($zf_applicationDefaults['application_fusioncharts'] == 'enabled'){ 
           
            @require_once ZF_PLUGINS.'zf_fusioncharts'.DS.'php'.DS.'FusionCharts.php';
       
       }
       
        
       $zf_view = new self;
        
       /**
        * THIS IS AN INSTANCE OF THE MAIN CONTROLLER CLASS.
        */
        $zf_controller = new Zf_Controller();
        
        
       /**
        * THIS IS AN INSTANCE OF THE FORM ERROR HANDLER LIBRARY.
        */
        $zf_formHandler = $zf_view->zf_formErrorHandler;
        
        
       /**
        * This retuns the framework's current executing controller
        * @type: varibale
        */
        $zf_currentController = Zf_Controller::zf_getCurrentController();
        
        
        /**
         * This returns an array that holds various settings, with regards to
         * system/ application status.
         */
        $zf_applicationStatus   = Zf_Configurations::Zf_ApplicationStatus();
        
        
        /**
         * Construct the absolute path for the view file and the actual name for
         * the view file.
         */
        $zf_currentViewPath = $zf_currentController.$zf_targetView;
        
        $zf_currentViewFile = $zf_currentViewPath.".php";
        
        
        //echo $zf_currentViewPath."<br><br>".$zf_currentViewFile; exit(); //THIS IS STRICTLY FOR DEBUGGING PURPOSES.
        
        
        /**
         * Process the data that has directly been passed into a view from a 
         * controller which can either be an array or just a variable.
         */
        if(is_array($zf_actionData)){
            
            extract($zf_actionData);
            
        }else{
            
            $zf_view = new self;
            $zf_view->zf_actionData = $zf_actionData;
            
        }
        
        /**
         * This checks if the default construction has been enabled or not. If 
         * yes, it is called for execution, else the normal sequence of the 
         * execution of a view is carried out.
         *  
         */
        
        if(($zf_applicationStatus['application_status'] === 'disabled') && ($zf_applicationStatus['construction_indicator'] == 'default')){
            
            require_once ASSETS_HEADERS.'default_header.php';
            require_once ASSETS_VIEWS . 'zf_default_construction' . DS . 'index.php';
            require_once ASSETS_FOOTERS.'default_footer.php';
            
            /**
             * Exit to stop execution of the code any further.
             */
            exit();
            
        }else{
        
            /**
             * This is the error executed for a non defined "default controller" or
             * if the defined "default controller" is invalid.
             */
            if($zf_targetView == "100"){

                $zf_currentController = 'zf_applicationerrorsdefault'.DS;

                require_once APPLICATION_HEADERS.'application_header.php';
                require_once ASSETS_VIEWS.'zf_default_errors'.DS.$zf_targetView.'.php';
                require_once APPLICATION_FOOTERS.'application_footer.php';
                
                /**
                 * Exit to stop execution of the code any further.
                 */
                exit();

            }

            /**
             * This is the error executed for a routing to an invalid 
             *  "selected controller" i.e if the "selected controller" is not the
             * "default controller" and also not existential.
             */
            else if($zf_targetView == "101"){
                
                $zf_currentController = 'zf_applicationerrorsdefault'.DS;

                require_once APPLICATION_HEADERS.'application_header.php';
                require_once ASSETS_VIEWS.'zf_default_errors'.DS.$zf_targetView.'.php';
                require_once APPLICATION_FOOTERS.'application_footer.php';
                
                /**
                 * Exit to stop execution of the code any further.
                 */
                exit();


            }

            /**
             * This is the error executed for an invalid "default action" within
             * controller or for a routing to a non existing "default action".
             */
            else if($zf_targetView == "200"){
                
                $zf_currentController = 'zf_applicationerrorsdefault'.DS;

                require_once APPLICATION_HEADERS.'application_header.php';
                require_once ASSETS_VIEWS.'zf_default_errors'.DS.$zf_targetView.'.php';
                require_once APPLICATION_FOOTERS.'application_footer.php';
                
                /**
                 * Exit to stop execution of the code any further.
                 */
                exit();


            }

            /**
             * This is the error executed for a non-defined "default action" within
             * a controller.
             */
            else if($zf_targetView == "201"){
                
                $zf_currentController = 'zf_applicationerrorsdefault'.DS;

                require_once APPLICATION_HEADERS.'application_header.php';
                require_once ASSETS_VIEWS.'zf_default_errors'.DS.$zf_targetView.'.php';
                require_once APPLICATION_FOOTERS.'application_footer.php';
                
                /**
                 * Exit to stop execution of the code any further.
                 */
                exit();


            }

            /**
             * This is the error executed for an invalid "selected action" within
             * controller or for a routing to a non existing "selected action".
             */
            else if($zf_targetView == "202"){
                
                $zf_currentController = 'zf_applicationerrorsdefault'.DS;

                require_once APPLICATION_HEADERS.'application_header.php';
                require_once ASSETS_VIEWS.'zf_default_errors'.DS.$zf_targetView.'.php';
                require_once APPLICATION_FOOTERS.'application_footer.php';
                
                /**
                 * Exit to stop execution of the code any further.
                 */
                exit();


            }

            /**
             * In this case there is not any routing error so we just render the
             * intended view.
             */
            else{
                
                require_once APPLICATION_HEADERS.'application_header.php';
                if(file_exists(APP_VIEWS.$zf_currentViewFile)){
                    
                    require_once APP_VIEWS.$zf_currentViewFile;
                    
                }else{
                    
                    $zf_targetView = 300;
                    require_once ASSETS_VIEWS.'zf_default_errors'.DS.$zf_targetView.'.php';
                    
                }
                
                require_once APPLICATION_FOOTERS.'application_footer.php';
                
                /**
                 * Exit to stop execution of the code any further.
                 */
                exit();

            }
        
        }
        
    }


}
?>

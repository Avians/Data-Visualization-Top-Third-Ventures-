<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE CORE CONTROLLER FOR ZILAS PHP FRAMEWORK. IT IS DOES THE ANALYSIS
 * OF ANY PASSED REQUEST AND THEN BUILDS THE LOGIC AND RELATIONS BETWEEN THE
 * MODELS AND THE VIEWS.
 * 
 * THIS CLASS MUST BE EXTENDED BY ALL THE OTHER CONTROLLERS WITHIN THE FRAMEWORK
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


class Zf_Controller {
    
    /**
     * A variable that holds an array of the URL passed
     * 
     * @var array
     * @access protected
     */
    protected $zf_controllerURL = array();
    
    
    /**
     * A variable that holds an array of the application status
     * 
     * @var array
     * @access private
     */
    private $zf_applicationStatus = array();
    
    
    /**
     * A variable that holds the current controller as passed in URL
     * 
     * @var string 
     * @access public
     */
    public $zf_currentController;
    
    
    /**
     * A variable that holds the application view object.
     * 
     * @var string 
     * @access public
     */
    public $zf_applicationView;
    
    
    /**
     * A variable that holds the target model as per the controller used.
     * 
     * @var string 
     * @access public
     */
    public $zf_targetModel;
    
    
    /**
     * A variable that holds an array of all the php grid settings
     * 
     * @var array
     * @access protected
     */
    protected $zf_phpGridSettings =array();
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct() {
        
        /**
         * A SESSION MUST BE STARTED FOR THE CORE CONTROLLER
         */
        Zf_SessionHandler::zf_sessionInit();
        
        
        /**
         * SANITIZE THE PASSED URL TO OBTAIN AN ARRAY OF THE URL PARTS.
         */
        $this->zf_controllerURL = Zf_Core_Functions::Zf_URLSanitize();
        
        
        /**
         * RETURN THE STATUS OF THE APPLICATION, WHETHER UNDER CONSTRUCTION OR
         * PRODUCTION.
         */
        $this->zf_applicationStatus = Zf_Configurations::Zf_ApplicationStatus();
        
        
        /**
         * INITIALIZE THE CORE VIEW CLASS WHICH PASSES ON TO THE ACTUAL VIEW
         * BEING RENDERED.
         */
        $this->zf_applicationView = new Zf_View();
        
        
        /**
         * DEVELOP THE VARIOUS PATHS / LINKS TO THE ACTUAL CURRENT VIEW BEING
         * RENDERED.
         */
        if((empty($this->zf_controllerURL[0]) && ($this->zf_applicationStatus['application_status'] == 'disabled')) || ($this->zf_applicationStatus['application_status'] == 'disabled')){
            
            /**
             * Check and return a path relevant to the  type of construction controller in use.
             */
            if($this->zf_applicationStatus['construction_indicator'] == 'default'){
                
                $this->zf_currentController = "../../zf_base".DS."zf_assets".DS."assets_controller".DS."zf_default_construction".DS;
                        
            }else{
                
                $this->zf_currentController= "app_assets".DS."zf_custom_construction".DS;
                        
            }
            
            
        }else if(($this->zf_applicationStatus['application_status'] != 'disabled') && (empty($this->zf_controllerURL[0]))){
            
            /**
             * In this case, returns the path to the default controller.  
             */
            @$zf_default_controller = explode("-", $this->zf_applicationStatus['default_controller']);
            
            $this->zf_currentController = $zf_default_controller[0].DS;
            
            
        }else{
            
            $this->zf_currentController = $this->zf_controllerURL[0].DS;
            
        }
        
        
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC STATIC METHOD THAT RETURNS THE CURRENT EXECUTING 
     * CONTROLLER.
     * -------------------------------------------------------------------------
     *  
     */
    public static function zf_getCurrentController(){
        
        $zf_controllerObject = new self;
        return $zf_controllerObject->zf_currentController;
        
    }

    

    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC STATIC METHOD THAT IS ESSENTIAL IN LOADING A MODEL
     * RELATED TO A PARTICULAR ACTION IN A RELATED CONTROLLER.
     * -------------------------------------------------------------------------
     * @var method
     * @access public 
     */
    public function Zf_loadModel($zf_controllerName, $zf_viewName) {
        
        /**
         * This is for indicating the Folder that contains the model files and 
         * the model file itself.
         */
        //THIS IS STRICTLY FOR DEBUGGING PURPOSES.
        //echo "Model Folder as: <b>". $zf_controllerName."</b> and Model File as: <b>".$zf_viewName."</b><br><br>";
        
        
        //create the path to the actual model file.
        
        $zf_model_file_path = APP_MODELS.$zf_controllerName.DS.lcfirst($zf_viewName)."_model.php";
        
        if(file_exists($zf_model_file_path)){
            
            //Load the existing model file and then  instantiate the model class
            require_once $zf_model_file_path;
            
            //Contruct the name of the actual model file
            $zf_model_class = ucfirst($zf_viewName)."_Model";
            
            $this->zf_targetModel = new $zf_model_class();
                 
            
            
        }else{
            
            return False;
            
        }  
        
        
    }

}
?>

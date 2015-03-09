<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR LOADING ALL THE APPLICATION WIDGETS. IT
 * CHECKS FOR THE RELATED "css" AND "scripts" AND BINDS THEM TOGETHER TO THE 
 * WIDGET AT LAOD TIME. 
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  25th/September/2013  Time: 13:40 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_ApplicationWidgets extends Zf_View{
    
    
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
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR LOADING ALL APPLICATION'S
     * SPECIFIED WIDGETS
     * -------------------------------------------------------------------------
     */
    public static function zf_load_widget($zf_widgetFolder, $zf_widgetFile, $zf_externalWidgetData = NULL){
        
        $zf_formErrorHandler = new self;
        
        $zf_formHandler = $zf_formErrorHandler->zf_formErrorHandler;
        
        
        /**
         * Here we load the "scripts" and the "css" files that are within the 
         * widget folder.
         */
        Zf_ClientAutoload::zf_applicationWidgets_global($zf_widgetFolder);
        Zf_ClientAutoload::zf_applicationWidgets($zf_widgetFolder);
        
        
        /**
         * Here we construct the path to the widget file 
         */
        $zf_widget_file_path = APP_WIDGETS. $zf_widgetFolder . DS . $zf_widgetFile;
        
        if(file_exists($zf_widget_file_path)){
            
            /**
             * A widget might need to access database to fetch data thus there
             * is need for widget models.
             */
            $zf_widget_model = explode('.', $zf_widgetFile);
            $zf_widget_model_file = $zf_widget_model[0]."_model.php";
            $zf_widget_model_class = ucfirst($zf_widget_model[0])."_Model";
            
            $zf_widget_model_path = APP_MODELS."app_widgets". DS .$zf_widgetFolder. DS . $zf_widget_model_file;
            
            /**
             * Ascertain that the widget model file exists.
             */
             if(file_exists($zf_widget_model_path)){
                 
                 /**
                  * require the assocaited model file
                  */
                 require_once $zf_widget_model_path;
                 $zf_model_data = new $zf_widget_model_class();
                 
             }
            
            
            /**
             * Here we require the actual widget file for rendering.
             */
            require_once $zf_widget_file_path;
            
        }else{
            
            /**
             * This is the error returnedwhen the widget you are trying to access
             * is invalid or not existing.
             */
            echo "The widget you are trying to load is invalid.<br>";
            
        }
        
        
    }
    
    
}

?>


<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL IN AUTO-LOADING FILES IN ANY OF THE CLIENT
 * DIRECTORIES. IT AUTOMATICALLY SNIFF THROUGH THE "zf_client" and "view_client"
 * DIRECTORIES AND LOADS ALL THE CSS, JAVASCRIPT and FONTS FILES FOUND IN THESE
 * DIRECTORIES INTO THE RESPECTIVE VIEWS.
 * 
 * Adopted from Autoload 1.2 by Phillware. - Thanks for kindness    
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  16th/September/2013  Time: 17:20 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */


final class Zf_ClientAutoload extends Zf_MobileDetect{
    
    public $targetView = array();




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
     * THIS IS THE MAIN STATIC METHOD FOR LOADING ALL THE GLOBAL FOLDERS AND 
     * FILES WITHIN THE "zf_app_global" DIRECTORY.
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_app_global(){
        
        
        /**
         * This is essential in calling the methods that are used for device
         * detection
         */
        $zf_currentDevice = new self;
        
        /**
         * This is the path to the parent folder that contains all the global
         * files and directories
         */
        $zf_app_global = "zf_client".DS."zf_app_global";
        
        /**
         * Check for the existence of directory "zf_app_global" which contains
         * globally accessible files and folders.
         */
        if(file_exists($zf_app_global)){
            
            /**
             * Files to exclude from scanning within the "zf_client" directory
             */
            $zf_exclude_files = array(".", "..", "app_global_files", "app_global_fonts", "zf_mobile_device", "zf_tablet_device", "zf_desktop_laptop");

            /**
             * Files and directories that have been found within "view_client"
             * directory
             */
            $found_directories = array_diff(scandir($zf_app_global), $zf_exclude_files);

            return  self::Zf_createExternalPaths($found_directories, $zf_app_global);
            
        }else{
            
            /**
             * return false in the case of its absence.
             */
            return FALSE;
            
        }
        
    }
    
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE MAIN STATIC METHOD FOR LOADING ALL THE FILES AND FOLDERS THAT
     * ARE DEVICE SPECIFIC.
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_device_specific(){
        
        
        /**
         * This is essential in calling the methods that are used for device
         * detection
         */
        $zf_currentDevice = new self;
        
        /**
         * This is the path to the parent folder that contains all the global
         * files and directories
         */
        $zf_device_specific = "zf_client";
        
        /**
         * Check for the existence of directory "zf_app_global" which contains
         * globally accessible files and folders.
         */
        if(file_exists($zf_device_specific)){
            
            /**
             * This is if the accessing device is a mobile.
             * 
             */
            if($zf_currentDevice->isMobile() && !$zf_currentDevice->isTablet()){
                
                /**
                 * Files to exclude from scanning within the "zf_client" directory
                 */
                $zf_exclude_files = array(".", "..", "zf_app_global", "zf_tablet_device", "zf_desktop_laptop");

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_device_specific), $zf_exclude_files);

                return self::Zf_createExternalPaths($found_directories, $zf_device_specific);
                
            }
            /**
             * This is if the accessing device is a tablet.
             * 
             */
            else if($zf_currentDevice->isTablet()){
                
                /**
                 * Files to exclude from scanning within the "zf_client" directory
                 */
                $zf_exclude_files = array(".", "..", "zf_app_global", "zf_mobile_device", "zf_desktop_laptop");

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_device_specific), $zf_exclude_files);

                return self::Zf_createExternalPaths($found_directories, $zf_device_specific);
                
            }
            /**
             * This is if the accessing device is a desktop or laptop.
             * 
             */
            else{
                
                /**
                 * Files to exclude from scanning within the "zf_client" directory
                 */
                $zf_exclude_files = array(".", "..", "zf_app_global", "zf_mobile_device", "zf_tablet_device");

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_device_specific), $zf_exclude_files);

                return self::Zf_createExternalPaths($found_directories, $zf_device_specific);
                
            }
            
        }else{
            
            /**
             * return false in the case of its absence.
             */
            return FALSE;
            
        }
        
        
    }
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE MAIN STATIC METHOD FOR LOADING ALL THE INTERNAL FOLDERS AND 
     * FILES WITHIN THE "zf_view_global" DIRECTORY. THE SCOPE OF THESE FILES ARE
     * WITHIN THAT VIEW DIRECTORY
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_view_global($zf_controller, $targetView=Null){
        
        
        $zf_applicationStatus   = Zf_Configurations::Zf_ApplicationStatus();
        
        /**
         * --------------------------------------------------------------------
         * IN THIS SECTION, WE TRY TO LOCATE THE VALID "view_client" DIRECTORY
         * TO BE SCANNED AND EXECUTED DEPENDING ON THE RUNNING CONTROLLER
         * --------------------------------------------------------------------
         * 
         */
        if(($zf_applicationStatus['application_status'] === 'disabled') && ($zf_applicationStatus['construction_indicator'] == 'default')){
            
            /**
             * This is the "view_client" directory for the default construction
             * view
             */
            $zf_view_global = ASSETS_VIEWS . "zf_default_construction" . DS . "view_client".DS."zf_view_global";
            
        }else if(($zf_applicationStatus['application_status'] === 'disabled') && ($zf_applicationStatus['construction_indicator'] == 'custom')){
            
            /**
             * This is the "view_client" directory for the custom construction
             * view
             */
            $zf_view_global = APP_VIEWS_ASSETS . "zf_custom_construction" . DS . "view_client".DS."zf_view_global";
            
        }else{
            
            /**
             * This array holds the valid error code for various system errors.
             */
            $zf_errorViews = array("100", "101", "200", "201", "202");

            if (in_array($targetView, $zf_errorViews)) {

                $zf_view_global = ASSETS_VIEWS . "zf_default_errors" . DS . "view_client".DS."zf_view_global";
                
            } else {

                $zf_view_global = APP_VIEWS . $zf_controller . "view_client".DS."zf_view_global";
            }
            
            
        }
        
        if(file_exists($zf_view_global)){
            
            /**
             * Files and directories to exclude from scanning within the 
             * "view_client" directory
             */
            $zf_exclude_files = array(".", "..", "zf_view_mobile", "zf_view_tablet", "zf_view_desktop_laptop");

            /**
             * Files and directories that have been found within "view_client"
             * directory
             */
            $found_directories = array_diff(scandir($zf_view_global), $zf_exclude_files);

            return self::Zf_createExternalPaths($found_directories, $zf_view_global);
            
        }else{
            
            /**
             * return false in the case of its absence.
             */
            return FALSE;
            
        }
        
        
    }
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE MAIN STATIC METHOD FOR LOADING ALL THE INTERNAL FOLDERS AND 
     * FILES WITHIN THE "zf_view_global" DIRECTORY. THE SCOPE OF THESE FILES ARE
     * WITHIN THAT VIEW DIRECTORY
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_view_device_specific($zf_controller, $targetView=Null){
        
        /**
         * This holds the status of the application, whether the application is 
         * in production or construction mode.
         */
        $zf_applicationStatus   = Zf_Configurations::Zf_ApplicationStatus();
        
        
        /**
         * This is essential in calling the methods that are used for device
         * detection
         */
        $zf_currentDevice = new self;
        
        /**
         * --------------------------------------------------------------------
         * IN THIS SECTION, WE TRY TO LOCATE THE VALID "view_client" DIRECTORY
         * TO BE SCANNED AND EXECUTED DEPENDING ON THE RUNNING CONTROLLER
         * --------------------------------------------------------------------
         * 
         */
        if(($zf_applicationStatus['application_status'] === 'disabled') && ($zf_applicationStatus['construction_indicator'] == 'default')){
            
            /**
             * This is the "view_client" directory for the default construction
             * view
             */
            $zf_view_device_specific = ASSETS_VIEWS . "zf_default_construction" . DS . "view_client";
            
            
        }else if(($zf_applicationStatus['application_status'] === 'disabled') && ($zf_applicationStatus['construction_indicator'] == 'custom')){
            
            /**
             * This is the "view_client" directory for the custom construction
             * view
             */
            $zf_view_device_specific = APP_VIEWS_ASSETS . "zf_custom_construction" . DS . "view_client";
            
        }else{
            
            /**
             * This array holds the valid error code for various system errors.
             */
            $zf_errorViews = array("100", "101", "200", "201", "202");

            if (in_array($targetView, $zf_errorViews)) {

                $zf_view_device_specific = ASSETS_VIEWS . "zf_default_errors" . DS . "view_client";
                
            } else {

                $zf_view_device_specific = APP_VIEWS . $zf_controller . "view_client";
            }
            
            
        }
        
        if(file_exists($zf_view_device_specific)){
            
            /**
             * This is if the accessing device is a mobile.
             * 
             */
            if ($zf_currentDevice->isMobile() && !$zf_currentDevice->isTablet()) {

                /**
                 * Files and directories to exclude from scanning within the 
                 * "view_client" directory
                 */
                $zf_exclude_files = array(".", "..", "zf_view_global", "zf_view_tablet", "zf_view_desktop_laptop");

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_view_device_specific), $zf_exclude_files);

                return self::Zf_createExternalPaths($found_directories, $zf_view_device_specific);
                
            }
            /**
             * This is if the accessing device is a tablet.
             * 
             */
            else if($zf_currentDevice->isTablet()){
                
                /**
                 * Files and directories to exclude from scanning within the 
                 * "view_client" directory
                 */
                $zf_exclude_files = array(".", "..", "zf_view_global","zf_view_mobile", "zf_view_desktop_laptop");

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_view_device_specific), $zf_exclude_files);

                return self::Zf_createExternalPaths($found_directories, $zf_view_device_specific);
                
            }
            /**
             * This is if the accessing device is a desktop or laptop.
             * 
             */
            else{
                
                /**
                 * Files and directories to exclude from scanning within the 
                 * "view_client" directory
                 */
                $zf_exclude_files = array(".", "..", "zf_view_global", "zf_view_mobile", "zf_view_tablet");

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_view_device_specific), $zf_exclude_files);

                return self::Zf_createExternalPaths($found_directories, $zf_view_device_specific);
                
            }
            
        }else{
            
            /**
             * return false in the case of its absence.
             */
            return FALSE;
            
        }
        
  
        
    }


    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD RESPONSIBLE FOR THE AUTO GENERATION OF ALL THE
     * EXTERNAL PATHS FOR BOTH THE ".js" and ".css" EXTENDED FILES AS THE 
     * SCANNING PROCESS CONTINUES. 
     * -------------------------------------------------------------------------
     * 
     */
    private static function Zf_createExternalPaths($found_directories, $scanned_directory) {

        $_stack_of_found_files = "";

        foreach ($found_directories as $file_extension) {

            //split the file name into two;
            if (filetype($scanned_directory . DS . $file_extension) == 'dir') {

                $zf_exclude_files = array('.', '..', 'app_global_files', 'app_global_fonts', 'view_files', 'view_fonts');
                
                $inner_found_directories = array_diff(scandir($scanned_directory . DS . $file_extension), $zf_exclude_files);

                $_stack_of_found_files = $_stack_of_found_files . self::Zf_createExternalPaths($inner_found_directories, $scanned_directory . DS . $file_extension);
                
                
            } else {

                $fileName = explode('.', $file_extension); //issue fixed

                switch ($fileName[1]) {

                    case "js":
                        //echo SYS_URL . $f . '/' . $ext."<br>";    //----This is strictly for debbugging purposes
                        //if file is javascript
                        $_stack_of_found_files = $_stack_of_found_files . "<script type='text/javascript' src='" . ZF_ROOT_PATH . $scanned_directory . DS . $file_extension . "'></script>";
                        break;

                    case "css"; //if file is css
                        $_stack_of_found_files = $_stack_of_found_files . "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . ZF_ROOT_PATH . $scanned_directory . DS . $file_extension . "\" />";
                        break;

                    default://if file type is unkown
                        $_stack_of_found_files = $_stack_of_found_files . "<!-- File: " . $file_extension . " was not included-->";
                }
            }
        }

        return $_stack_of_found_files;
    }
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE MAIN STATIC METHOD FOR LOADING ALL THE "css" and "scrpit" 
     * FILES WITHIN THE SPACIFIES APPLICATION WIDGET GLOBAL. THE SCOPE OF THESE
     * FILES ARE WITHIN THAT WIDGET DIRECTORY.
     * -------------------------------------------------------------------------
     */
    public static function zf_applicationWidgets_global($zf_widgetFolder){
        
        /**
         * This is the path to the parent folder that contains all the global
         * files and directories
         */
        $zf_app_widget = APP_WIDGETS.$zf_widgetFolder. DS ."widget_client". DS ."widget_global";
        
        /**
         * Check for the existence of directory "zf_applicationWidgets_global" 
         * which contains globally accessible files and folders.
         */
        if(file_exists($zf_app_widget)){
            
            /**
             * Files to exclude from scanning within the "zf_client" directory
             */
            $zf_exclude_files = array('.', '..', 'widget_mobile', 'widget_tablet', 'widget_desktop_laptop');

            /**
             * Files and directories that have been found within "view_client"
             * directory
             */
            $found_directories = array_diff(scandir($zf_app_widget), $zf_exclude_files);

            return self::Zf_createWidgetPaths($found_directories, $zf_app_widget);
            
        }else{
            
            /**
             * return false in the case of its absence.
             */
            return FALSE;
            
        }
        
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE MAIN STATIC METHOD FOR LOADING ALL THE "css" and "scrpit" 
     * FILES WITHIN THE SPACIFIES APPLICATION WIDGET. THE SCOPE OF THESE FILES 
     * ARE WITHIN THAT WIDGET DIRECTORY
     * -------------------------------------------------------------------------
     */
    public static function zf_applicationWidgets($zf_widgetFolder){
        
        /**
         * This is an instance of this class
         */
        $zf_currentDevice = new self;
        
        /**
         * This is the path to the parent folder that contains all the global
         * files and directories
         */
        $zf_app_widget = APP_WIDGETS.$zf_widgetFolder. DS ."widget_client";
        
        /**
         * Check for the existence of directory "zf_applicationWidget" which 
         * contains globally accessible files and folders.
         */
        if(file_exists($zf_app_widget)){
            
            
            /**
             * This is if the accessing device is a mobile.
             * 
             */
            if($zf_currentDevice->isMobile() && !$zf_currentDevice->isTablet()){
                
                /**
                 * Files to exclude from scanning within the "zf_client" directory
                 */
                $zf_exclude_files = array('.', '..', 'widget_global', 'widget_tablet', 'widget_desktop_laptop');

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_app_widget), $zf_exclude_files);

                return self::Zf_createWidgetPaths($found_directories, $zf_app_widget);
                
            }
            /**
             * This is if the accessing device is a tablet.
             * 
             */
            else if($zf_currentDevice->isTablet()){
                
                /**
                 * Files to exclude from scanning within the "zf_client" directory
                 */
                $zf_exclude_files = array('.', '..', 'widget_global', 'widget_mobile', 'widget_desktop_laptop');

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_app_widget), $zf_exclude_files);

                return self::Zf_createWidgetPaths($found_directories, $zf_app_widget);
                
            }
            /**
             * This is if the accessing device is a desktop or laptop.
             * 
             */
            else{
                
                /**
                 * Files to exclude from scanning within the "zf_client" directory
                 */
                $zf_exclude_files = array('.', '..', 'widget_global', 'widget_mobile', 'widget_tablet');

                /**
                 * Files and directories that have been found within "view_client"
                 * directory
                 */
                $found_directories = array_diff(scandir($zf_app_widget), $zf_exclude_files);

                return self::Zf_createWidgetPaths($found_directories, $zf_app_widget); 
                
            }
           
            
        }else{
            
            /**
             * return false in the case of its absence.
             */
            return FALSE;
            
        }
        
    }
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD RESPONSIBLE FOR THE AUTO GENERATION OF ALL THE
     * WIDGET PATHS FOR BOTH THE ".js" and ".css" EXTENDED FILES AS THE 
     * SCANNING PROCESS CONTINUES. 
     * -------------------------------------------------------------------------
     * 
     */
    private static function Zf_createWidgetPaths($found_directories, $scanned_directory) {
        
        $_stack_of_found_files = "";

        foreach ($found_directories as $file_extension) {

            //split the file name into two;
            if (filetype($scanned_directory . DS . $file_extension) == 'dir') {

                $zf_exclude_files = array('.', '..', 'widget_images', 'widget_fonts');
                
                $inner_found_directories = array_diff(scandir($scanned_directory . DS . $file_extension), $zf_exclude_files);

                $_stack_of_found_files = $_stack_of_found_files . self::Zf_createWidgetPaths($inner_found_directories, $scanned_directory . DS . $file_extension);
                
                
            } else {

                $fileName = explode('.', $file_extension); //issue fixed

                switch ($fileName[1]) {

                    case "js":
                        //echo SYS_URL . $f . '/' . $ext."<br>";    //----This is strictly for debbugging purposes
                        //if file is javascript
                        $_stack_of_found_files = $_stack_of_found_files . require_once  $scanned_directory . DS . $fileName[0].".js";
                        break;

                    case "css"; //if file is css
                        $_stack_of_found_files = $_stack_of_found_files .  require_once  $scanned_directory . DS . $fileName[0].".css";
                        break;

                    default://if file type is unkown
                        $_stack_of_found_files = $_stack_of_found_files . "<!-- File: " . $file_extension . " was not included-->";
                }
            }
        }

        return $_stack_of_found_files;
    
    }
    


    /**
     * --------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD THAT IS RESPONSIBLE FOR LOADING ALL THE CSS3
     * FONTS THAT ARE IN THE "zf_app_fonts" directory.                                                                                                                          
     * --------------------------------------------------------------------------
     */
    public  static function zf_loadAppGlobalFonts(){
        
        /**
         * Path to the global application fonts directory.
         */
        $zf_app_global_fonts = "zf_client".DS."zf_app_global".DS."app_global_fonts";
        
        $zf_fonts_top= "<style>";
        $zf_fontFamily = "";
        
        
        /**
         * This checks if "app_global_fonts" directory exists.
         */
        if(file_exists($zf_app_global_fonts)){
            
            /**
             * Files and directories to exclude from scanning within the 
             * "app_global_fonts" directory
             */
            $zf_exclude_files = array(".", "..");

            /**
             * Files and directories that have been found within "view_client"
             * directory
             */
            $found_directories = array_diff(scandir($zf_app_global_fonts), $zf_exclude_files);
            
            $zf_fonts = array();


            //scan directories

            $zf_font_data = array();
            foreach ($found_directories as $zf_directory) {
                
                $zf_tmp_directory = explode('.', $zf_directory);

                $zf_font_data[$zf_tmp_directory[0]][] = $zf_tmp_directory[0] . '.' . $zf_tmp_directory[1];
                
            }

            
            foreach ($zf_font_data as $key => $actual_font) {

                   $zf_fonts = "";
                   
                   foreach ($actual_font as $zf_font){
                       
                       $zf_fonts .=',url("'.ZF_ROOT_PATH.'zf_client'.DS.'zf_app_global'.DS.'app_global_fonts'.DS.$zf_font.'")';  
                   }
                   
                  $zf_fonts = ltrim($zf_fonts, ', ');
                  $zf_fontFamily.= "@font-face
                                    {
                                    font-family: $key;
                                    src: $zf_fonts;
                                    }";
            }

            echo $zf_fonts_top . $zf_fontFamily . "</style>";
            
            
            
        }else{
            
            /**
             * return false in the case of its absence.
             */
            return FALSE;
            
        }
        
        
    }






    /**
     * --------------------------------------------------------------------------
     * THIS LOADS ALL THE CLASSES WITHIN THE BASE DIRECTORY.                                                                                                                             
     * --------------------------------------------------------------------------
     */
    public static function Zf_load($zf_classname) {

        require ZF_BASE . $zf_classname . '.php';
        
    }

    /**
     * --------------------------------------------------------------------------
     * THIS LOADS ALL CSS FILES, JAVASCRIPT FILES AND THE FONT FILES ALSO.                                                                                                                             
     * --------------------------------------------------------------------------
     */
    public static function Zf_loadCssScriptsFonts($zf_controller, $targetView){
        
        echo self::zf_app_global();
        echo self::zf_device_specific();
        echo self::zf_view_global($zf_controller, $targetView);
        echo self::zf_view_device_specific($zf_controller, $targetView);
        echo self::zf_loadAppGlobalFonts();
        
        $zf_applicationDefaults   = Zf_Configurations::Zf_ApplicationDefaults();

        if($zf_applicationDefaults['application_phpgrid'] == 'enabled'){
            
            include_once ZF_PLUGINS.'zf_phpgrid'.DS.'zf_phpgrid_js_css.php';
            
        }
        
        if($zf_applicationDefaults['application_fusioncharts'] == 'enabled'){
            
            include_once ZF_PLUGINS.'zf_fusioncharts'.DS.'js-css'.DS.'zf_fusioncharts_js_css.php';
            
        }
        
    }
    
    
}

spl_autoload_register(array('Zf_ClientAutoload', 'Zf_load'));

?>

<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR LOADING ALL THE SEO FILES. IT DIGS INTO A 
 * SPECIFIED SEO FILE AND INCLUDES IT TO THE NECESSARY HEADER SECTION>
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  1st/October/2013  Time: 16:40 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_GenerateSEO{
    
    
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
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR GENERATING THE SEO FOR A 
     * GIVEN VIEW
     * -------------------------------------------------------------------------
     */
    public static function zf_load_seo(){
        
        /**
         * Check to see that SEO capability of the framework has been enabled.
         */
        $zf_seoStatus = Zf_Configurations::Zf_ApplicationDefaults();
        
        $zf_applicationStatus   = Zf_Configurations::Zf_ApplicationStatus();
        
        if($zf_seoStatus['application_seo'] == "enabled"){
            
            /**
             * We check the application status, i.e if application is disabled
             * or enabled.
             */
            if($zf_applicationStatus['application_status'] == "enabled"){
                
                $zf_view_controller = Zf_Core_Functions::Zf_URLSanitize();
               
                if(empty($zf_view_controller[0])){
                    
                    /**
                     * Here we construct the default controller
                     */
                    $controller_view = explode('-', $zf_applicationStatus['default_controller']);
                    $zf_seo_view = $controller_view[0];
                    
                    $zf_seo_file = APP_VIEWS . $zf_seo_view . DS . "view_client".DS."zf_view_global". DS ."view_files". DS ."view_seo". DS ."zf_seo.php" ;
                    
                    if(!empty($zf_view_controller[1]) && $zf_view_controller[1] != "index"){
                        
                        $zf_seo_view = $zf_view_controller[1];
                        
                        if(strpos($zf_seo_view, '_')){
                        
                            $zf_seo_view = ucwords(str_replace( "_", " ", $zf_seo_view ));

                        }
                        
                    }else{
                        
                        if(strpos($zf_seo_view, '_')){
                        
                            $zf_seo_view = ucwords(str_replace( "_", " ", $zf_seo_view ));

                        }
                        
                    }
                    
                    
                }else{
                    
                    $zf_seo_view = $zf_view_controller[0];
                    
                    $zf_seo_file = APP_VIEWS . $zf_seo_view . DS ."view_client".DS."zf_view_global". DS ."view_files". DS ."view_seo". DS ."zf_seo.php" ;
                    
                    if(!empty($zf_view_controller[1]) && $zf_view_controller[1] != "index"){
                        
                        $zf_seo_view = $zf_view_controller[1];
                        
                        if(strpos($zf_seo_view, '_')){
                        
                            $zf_seo_view = ucwords(str_replace( "_", " ", $zf_seo_view ));

                        }
                        
                    }else{
                        
                        if(strpos($zf_seo_view, '_')){
                        
                            $zf_seo_view = ucwords(str_replace( "_", " ", $zf_seo_view ));

                        }
                        
                    }
                    
                }
                
                
            }else if($zf_applicationStatus['application_status'] == "disabled"){
                
                /**
                 * Check for the construction indicator in use. It can either
                 * be default or custom
                 */
                if($zf_applicationStatus['construction_indicator'] == "default"){
                    
                    $zf_seo_file = ASSETS_VIEWS . "zf_default_construction" . DS . "view_client". DS ."zf_view_global". DS ."view_files". DS ."view_seo". DS ."zf_seo.php" ;
                    
                }else if($zf_applicationStatus['construction_indicator'] == "custom"){
                    
                    $zf_seo_file = APP_VIEWS_ASSETS . "zf_custom_construction" . DS . "view_client".DS."zf_view_global". DS ."view_files". DS ."view_seo". DS ."zf_seo.php";
                    
                }
                
            }
            
            if(file_exists($zf_seo_file)){
                
                echo '<link rel="shortcut icon" href="'.ZF_ROOT_PATH.ZF_APP_GLOBAL.'app_global_files/app_global_images/favicon.ico" type="image/x-icon">';
                echo '<link rel="icon" href="'.ZF_ROOT_PATH.ZF_APP_GLOBAL.'app_global_files/app_global_images/favicon.ico" type="image/x-icon">';
                
                /**
                 * Load the seo file related to the view that is being rendered
                 * at the moment.
                 */
                require_once $zf_seo_file;
                
            }else{
                
                /**
                 * Path to the Global SEO file.
                 */
                $zf_seo_file = $zf_seo_file = ZF_APP_GLOBAL."app_global_files". DS ."app_global_seo". DS ."zf_seo.php";
                
                if(file_exists($zf_seo_file)){
                    
                    echo '<link rel="shortcut icon" href="'.ZF_ROOT_PATH.ZF_APP_GLOBAL.'app_global_files/app_global_images/favicon.ico" type="image/x-icon">'; 
                    echo '<link rel="icon" href="'.ZF_ROOT_PATH.ZF_APP_GLOBAL.'app_global_files/app_global_images/favicon.ico" type="image/x-icon">';
                
                    /**
                     * Require the global seo file if the application SEO ability is
                     * disabled. 
                     */
                    require_once $zf_seo_file;
                    
                } else {

                    echo "<code><strong>Your application lacks a global SEO file<br>This will compromise search engine rankings for this site or application!!</strong><code>";
                
                }
                
            }
                 
        }else{
            
            /**
             * check for the existence of the SEO file in the Global View
             */
            $zf_seo_file = ZF_APP_GLOBAL."app_global_files". DS ."app_global_seo". DS ."zf_seo.php";
            
            if(file_exists($zf_seo_file)){
                
                echo '<link rel="shortcut icon" href="'.ZF_ROOT_PATH.ZF_APP_GLOBAL.'app_global_files/app_global_images/favicon.ico" type="image/x-icon">'; 
                echo '<link rel="icon" href="'.ZF_ROOT_PATH.ZF_APP_GLOBAL.'app_global_files/app_global_images/favicon.ico" type="image/x-icon">';

                /**
                 * Require the global seo file if the application SEO ability is
                 * disabled. 
                 */
                require_once $zf_seo_file;
                
            }else{
                
                echo "<code><strong>Your application lacks a global SEO file<br>This will compromise search engine rankings for this site or application!!</strong><code>";
                
            }
            
        }
        
        
    }
   
    
}

?>


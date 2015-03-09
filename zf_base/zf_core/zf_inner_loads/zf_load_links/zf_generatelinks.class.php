<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR LOADING ALL THE EXTERNAL APPLICATION LINKS
 * BY ACCEPTING THE VARIOUS ASPECTS OF A DEFAULT LINK.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  25th/September/2013  Time: 16:40 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_GenerateLinks{
    
    
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
     * THIS IS THE STATIC METHOD THAT IS RESPONSIBLE FOR GENERATION OF A BASIC 
     * EXTERNAL LINK.
     * -------------------------------------------------------------------------
     */
    public static function basic_external_link($zf_external_link = NULL){
        
    }

        
    /**
     * -------------------------------------------------------------------------
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR GENERATING THE STANDARD
     * EXTERNAL LINK
     * -------------------------------------------------------------------------
     */
    public static function zf_external_link($zf_link_data = NULL){
        
        /**
         * Check to see that link data is not emtpy
         */
        if(empty($zf_link_data) || !is_array($zf_link_data) || $zf_link_data == NULL){
            
            echo "<code><strong>External Link Error:</strong> Missing Data Array</code> ";
            
        }else{
            
            $zf_external_link =  $zf_link_data['link'];
            echo "<a href='{$zf_external_link}' title='{$zf_link_data['title']}' target='{$zf_link_data['target']}' class='{$zf_link_data['style']}' id='{$zf_link_data['id']}' >{$zf_link_data['name']}</a>";
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD THAT IS RESPONSIBLE FOR GENERATION OF A BASIC 
     * INTERNAL LINK.
     * -------------------------------------------------------------------------
     */
    public static function basic_internal_link($zf_controller = NULL, $zf_action = NULL, $zf_parameter = NULL){
        
        $url_encryption_status = Zf_Configurations::Zf_ApplicationDefaults();
        
        /**
         * In this case all the 3 parameters have been passed.
         */
        if ($zf_parameter != "" && $zf_parameter != NULL) {

            /**
             * Here we check if URL encryption has been enabled. if yes, then we 
             * need to encrypt our URL's "$zf_parameter", if no, then we pass
             *  our raw URL.
             */
            if ($url_encryption_status['application_urlencrypt'] === "enabled") {

                /**
                 * Ensure that the link is not shown if encryption is disables
                 */
                if ($url_encryption_status['application_encryption'] == "disabled") {

                    /**
                     * This ensures that you cannot encrypt your links
                     * without enabling application encryption.
                     */
                    echo "<code>You must enable <strong>application encryption</strong> to be able to encrypt your link parameters.</code>";
                    
                } else {

                    $basic_internal_link = ZF_ROOT_PATH . $zf_controller . DS . $zf_action . DS . Zf_SecureData::zf_encode_data($zf_parameter);
                    echo $basic_internal_link ;
                    
                }
                
            } else {

                $basic_internal_link = ZF_ROOT_PATH . $zf_controller . DS . $zf_action . DS . $zf_parameter;
                echo $basic_internal_link ;
                    
            }
            
        }
        /**
         * In this case, only the 3rd parameter has not been passed.
         */
        else if($zf_action != "" && $zf_action != NULL && $zf_parameter == ""){
            
            //Echo  link to the referenced action within the controller
            $basic_internal_link = ZF_ROOT_PATH . $zf_controller . DS . $zf_action ;
            echo $basic_internal_link ;
            
        }
        /**
         * In this case, only the 1st parameter has been passed.
         */
        else if($zf_controller !="" && $zf_controller != NULL && $zf_action == "" && $zf_parameter == ""){
            
            //Echo  a link to the refrenced controller
            $basic_internal_link = ZF_ROOT_PATH . $zf_controller;
            echo $basic_internal_link ;
            
        }
        /**
         * In this case, no parameter has been passed at all.
         */
        else{
            
            //Echo a dead link.
            $zf_current_url = Zf_Core_Functions::Zf_URLSanitize();
            
            if(empty($zf_current_url[2]) && (!empty($zf_current_url[1]))){
                
               $basic_internal_link = ZF_ROOT_PATH. $zf_current_url[0] . DS .$zf_current_url[1] . DS ."#";
               echo $basic_internal_link ;
                
            }else if(empty($zf_current_url[1]) && (!empty($zf_current_url[0]))){
                
               $basic_internal_link = ZF_ROOT_PATH. $zf_current_url[0]. DS ."#";
               echo $basic_internal_link ;
                
            }else if(empty($zf_current_url[0])){
                
               $basic_internal_link = ZF_ROOT_PATH. DS ."#";
               $zf_current_url = explode("-", DEFAULT_CONTROLLER);
               echo $basic_internal_link ;
                
            }else{
                
               $basic_internal_link = ZF_ROOT_PATH. $zf_current_url[0] . DS .$zf_current_url[1] . DS .$zf_current_url[2] . DS . "#";
               echo $basic_internal_link ;
                
            }
        }   
        
    }
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD THAT IS RESPONSIBLE FOR GENERATION OF A BASIC 
     * INTERNAL LINK.
     * -------------------------------------------------------------------------
     */
    public static function zf_fusionCharts_link($zf_controller, $zf_action, $zf_parameter){
        
        $url_encryption_status = Zf_Configurations::Zf_ApplicationDefaults();
        
        /**
         * In this case all the 3 parameters have been passed.
         */
        if ($zf_parameter != "" && $zf_parameter != NULL) {

            /**
             * Here we check if URL encryption has been enabled. if yes, then we 
             * need to encrypt our URL's "$zf_parameter", if no, then we pass
             *  our raw URL.
             */
            if ($url_encryption_status['application_urlencrypt'] === "enabled") {

                /**
                 * Ensure that the link is not shown if encryption is disables
                 */
                if ($url_encryption_status['application_encryption'] == "disabled") {

                    /**
                     * This ensures that you cannot encrypt your links
                     * without enabling application encryption.
                     */
                    echo "<code>You must enable <strong>application encryption</strong> to be able to encrypt your link parameters.</code>";
                    
                } else {

                    $basic_internal_link = ZF_ROOT_PATH . $zf_controller . DS . $zf_action . DS . Zf_SecureData::zf_encode_data($zf_parameter);
                    return $basic_internal_link ;
                    
                }
                
            } else {

                $basic_internal_link = ZF_ROOT_PATH . $zf_controller . DS . $zf_action . DS . $zf_parameter;
                return; $basic_internal_link ;
                    
            }
            
        }
       
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR GENERATING THE STANDARD
     * INTERNAL LINK
     * -------------------------------------------------------------------------
     */
    public static function zf_internal_link($zf_link_data = NULL){
        
        $url_encryption_status = Zf_Configurations::Zf_ApplicationDefaults();
        
        if(empty($zf_link_data) && !is_array($zf_link_data)){
            
            $zf_current_url = Zf_Core_Functions::Zf_URLSanitize();
            
            if(empty($zf_current_url[2]) && (!empty($zf_current_url[1]))){
                
               $zf_internal_link = ZF_ROOT_PATH. $zf_current_url[0] . DS .$zf_current_url[1] . DS ."#";
               echo "<a href='{$zf_internal_link}' title='Dead Link'>{$zf_current_url[0]} ". DS ." {$zf_current_url[1]}". DS ."#</a> ";
                
            }else if(empty($zf_current_url[1]) && (!empty($zf_current_url[0]))){
                
               $zf_internal_link = ZF_ROOT_PATH. $zf_current_url[0]. DS ."#";
               echo "<a href='{$zf_internal_link}' title='Dead Link'>{$zf_current_url[0]}". DS ."#</a> ";
                
            }else if(empty($zf_current_url[0])){
                
               $zf_internal_link = ZF_ROOT_PATH. DS ."#";
               $zf_current_url = explode("-", DEFAULT_CONTROLLER);
               echo "<a href='{$zf_internal_link}' title='Dead Link'>{$zf_current_url[0]}". DS ."#</a> ";
                
            }else{
                
               $zf_internal_link = ZF_ROOT_PATH. $zf_current_url[0] . DS .$zf_current_url[1] . DS .$zf_current_url[2] . DS . "#";
               echo "<a href='{$zf_internal_link}' title='Dead Link'>{$zf_current_url[0]} {$zf_current_url[1]}". DS ."#</a> ";
                
            }
            
            
        }else{
            
                if(is_array($zf_link_data) && !empty($zf_link_data)){
                    
                        if(($zf_link_data['name'] == '') || empty($zf_link_data['name'])){

                            /**
                             * This ensures that a link cannot miss a name
                             */
                            echo "<code>You cannot have a link without a name!!</code>";

                        }else{

                            if (($zf_link_data['parameter'] != "") || !empty($zf_link_data['parameter'])) {

                                /**
                                 * Check to see that a parameter can not be specified without a 
                                 * controller or an action.
                                 */
                                if(empty($zf_link_data['controller'])){

                                    /**
                                     * This ensures that a link with a parameter cannot miss
                                     * a controller.
                                     */
                                    echo "<code><strong>Internal Link Error:</strong> Missing Controller</code> ";

                                }else if(empty($zf_link_data['action'])){

                                    /**
                                     * This ensures that a link with a parameter cannot miss
                                     * an action.
                                     */
                                    echo "<code><strong>Internal Link Error:</strong> Missing Action</code>";

                                }else{

                                    /**
                                     * Here we check if URL encryption has been enabled. if yes, then we 
                                     * need to encrypt our URL's "$zf_parameter", if no, then we pass
                                     *  our raw URL.
                                     */

                                    if ($url_encryption_status['application_urlencrypt'] === "enabled") {

                                        /**
                                         * Ensure that the link is not shown if encryption is disables
                                         */
                                        if($url_encryption_status['application_encryption'] == "disabled"){

                                            /**
                                             * This ensures that you cannot encrypt your links
                                             * without enabling application encryption.
                                             */
                                            echo "<code>You must enable <strong>application encryption</strong> to be able to encrypt your link parameters.</code>";

                                        }else{

                                            $zf_internal_link = ZF_ROOT_PATH . $zf_link_data['controller'] . DS . $zf_link_data['action'] . DS . Zf_SecureData::zf_encode_data($zf_link_data['parameter']);
                                            echo "<a href='{$zf_internal_link}' title='{$zf_link_data['title']}' class='{$zf_link_data['style']}' id='{$zf_link_data['id']}' >{$zf_link_data['name']}</a>";

                                        }

                                    } else {

                                        $zf_internal_link = ZF_ROOT_PATH . $zf_link_data['controller'] . DS . $zf_link_data['action'] . DS . $zf_link_data['parameter'];
                                        echo "<a href='{$zf_internal_link}' title='{$zf_link_data['title']}' class='{$zf_link_data['style']}' id='{$zf_link_data['id']}' >{$zf_link_data['name']}</a>";

                                    }

                                }

                            } else if (($zf_link_data['action'] != "") || !empty($zf_link_data['action'])) {

                                /**
                                 * Checks to see that an action can not be specified without a 
                                 * controller.
                                 */
                                if(empty($zf_link_data['controller'])){

                                    /**
                                     * This ensures that a link with an action cannot miss a
                                     * controller.
                                     */
                                    echo "<code><strong>Internal Link Error:</strong> Missing Controller</code> ";

                                }else{

                                    $zf_internal_link = ZF_ROOT_PATH . $zf_link_data['controller'] . DS . $zf_link_data['action'];
                                    echo "<a href='{$zf_internal_link}' title='{$zf_link_data['title']}' class='{$zf_link_data['style']}' id='{$zf_link_data['id']}' >{$zf_link_data['name']}</a>";

                                }

                            }else if(($zf_link_data['controller'] != "") || !empty($zf_link_data['controller'])) {

                                $zf_internal_link = ZF_ROOT_PATH . $zf_link_data['controller'];
                                echo "<a href='{$zf_internal_link}' title='{$zf_link_data['title']}' class='{$zf_link_data['style']}' id='{$zf_link_data['id']}' >{$zf_link_data['name']}</a>";

                            } 

                       }
            
                }else{
                    
                    /**
                     * This will automatically direct a link with an empty array
                     * to the home page by default.
                     */
                    $zf_internal_link = ZF_ROOT_PATH;
                    echo "<a href='{$zf_internal_link}' title=' ".APPLICATION_NAME." '  >Home</a>";

                } 
        
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR GENERATING THE HEADERS
     * ROUTING. THIS IS ESSENTIAL FOR ROUTING YOUR PAGES TO DIFFERENT LOCATIONS.
     * -------------------------------------------------------------------------
     */
    public static function zf_header_location($zf_controller = NULL, $zf_action = NULL, $zf_parameter = NULL){
        
        /**
         * This returns the encryption status of the whole application and is
         * important for proper routing purposes. 
         */
        $url_encryption_status = Zf_Configurations::Zf_ApplicationDefaults();
        
         /**
         * In this case all the 3 parameters have been passed.
         */
        if ($zf_parameter != "" && $zf_parameter != NULL) {

            /**
             * Here we check if URL encryption has been enabled. if yes, then we 
             * need to encrypt our URL's "$zf_parameter", if no, then we pass
             *  our raw URL.
             */
            if ($url_encryption_status['application_urlencrypt'] === "enabled") {

                /**
                 * Ensure that the link is not shown if encryption is disables
                 */
                if ($url_encryption_status['application_encryption'] == "disabled") {

                    /**
                     * This ensures that you cannot encrypt your links
                     * without enabling application encryption.
                     */
                    echo "<code>You must enable <strong>application encryption</strong> to be able to encrypt your link parameters.</code>";
                    
                } else {

                    $header_location_link = ZF_ROOT_PATH . $zf_controller . DS . $zf_action . DS . Zf_SecureData::zf_encode_data($zf_parameter);
                    header('location:'. $header_location_link); 
                    exit();
                    
                }
                
            } else {

                $header_location_link = ZF_ROOT_PATH . $zf_controller . DS . $zf_action . DS . $zf_parameter;
                header('location:'. $header_location_link); 
                exit();
                    
            }
            
        }
        /**
         * In this case, only the 3rd parameter has not been passed.
         */
        else if($zf_action != "" && $zf_action != NULL && $zf_parameter == ""){
            
            //Echo  link to the referenced action within the controller
            $header_location_link = ZF_ROOT_PATH . $zf_controller . DS . $zf_action ;
            header('location:'. $header_location_link); 
            exit();
            
        }
        /**
         * In this case, only the 1st parameter has been passed.
         */
        else if($zf_controller !="" && $zf_controller != NULL && $zf_action == "" && $zf_parameter == ""){
            
            //Echo  a link to the refrenced controller
            $header_location_link = ZF_ROOT_PATH . $zf_controller;
            header('location:'. $header_location_link); 
            exit();
            
        }
        /**
         * In this case, no parameter has been passed at all.
         */
        else{
            
            //Echo a dead link.
            $zf_current_url = Zf_Core_Functions::Zf_URLSanitize();
            
            if(empty($zf_current_url[2]) && (!empty($zf_current_url[1]))){
                
               $header_location_link = ZF_ROOT_PATH. $zf_current_url[0] . DS .$zf_current_url[1] . DS ."#";
               header('location:'. $header_location_link); 
               exit();
                
            }else if(empty($zf_current_url[1]) && (!empty($zf_current_url[0]))){
                
               $header_location_link = ZF_ROOT_PATH. $zf_current_url[0]. DS ."#";
               header('location:'. $header_location_link); 
               exit();
                
            }else if(empty($zf_current_url[0])){
                
               $header_location_link = ZF_ROOT_PATH. DS ."#";
               $zf_current_url = explode("-", DEFAULT_CONTROLLER);
               header('location:'. $header_location_link); 
               exit();
                
            }else{
                
               $header_location_link = ZF_ROOT_PATH. $zf_current_url[0] . DS .$zf_current_url[1] . DS .$zf_current_url[2] . DS . "#";
               header('location:'. $header_location_link); 
               exit();
                
            }
        }
        
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR GENERATING THE STANDARD
     * INTERNAL LINK THAT USES AN IMAGE AS A LINK.
     * -------------------------------------------------------------------------
     */
    public static function zf_image_link($zf_link_data = NULL){
        
        echo "This will help in generating image links";
        
    }
    
}

?>
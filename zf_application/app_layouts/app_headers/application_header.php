<?php
error_reporting((E_ALL & ~E_NOTICE) & 0);
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE APPLICATION GENERAL HEADER THAT IS RENDERED WHEN THE APPLICATION
 * IS ENABLED AND IS NOT UNDER CONSTRUCTION OR WHEN THE APPLICATION UNDER  
 * CONSTRUCTION AND THE CONSTRUCTION INDICATOR IS SET TO CUSTOM
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  16th/September/2013  Time: 16:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en" class="no-js"> 
<!--<![endif]-->

<!-- BEGIN HEAD -->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        
            /**
             * This loads all the SEO files depending on whether the SEO ability
             * of the framework has been enabled or not. If the SEO ability is
             * enabled then the SEO files are view specific if and only if they
             * exist in the particular view.
             */
            Zf_GenerateSEO::zf_load_seo();    
            
            /**
             * This is loads all the CSS and Javascript files that are global to
             * the application and even those that are specific to a given view 
             * of the application
             */
            Zf_ClientAutoload::Zf_loadCssScriptsFonts($zf_currentController, $zf_targetView);
            
            $activeURL = Zf_Core_Functions::Zf_URLSanitize();
        
        ?>        
    </head>
    <body 
        <?php if(empty($activeURL[0]) || 
                ($activeURL[0] == "index" && empty($activeURL[1])) || 
                ($activeURL[0] == "index" && $activeURL[1] == "login" || $activeURL[0] == "index" && $activeURL[1] == "reset_password" || $activeURL[0] == "index" && $activeURL[1] == "sign_up" ))
            {echo 'class="login"';}
            else{ 
                echo 'class="page-header-fixed"'; 
            } ?> 
      >
        
           
        <?php

            $identificationCodeArray = Zf_Core_Functions::Zf_DecodeIdentificationCode(Zf_SessionHandler::zf_getSessionVariable('ttv_identificationCode'));
            //echo "<br><br><br><pre>"; print_r($identificationCodeArray); echo "</pre>";//This is strictly for debugging purposes
            
            if(empty($activeURL[0]) || 
                ($activeURL[0] == "index" && empty($activeURL[1])) || 
                ($activeURL[0] == "index" && $activeURL[1] == "login" || $activeURL[0] == "index" && $activeURL[1] == "reset_password" || $activeURL[0] == "index" && $activeURL[1] == "sign_up" )){

                //BEGIN LOGIN HEADER
                $zf_widgetFolder = "lock_screens"; $zf_widgetFile = "login_header.php";
                Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile);
                //END LOGIN HEADER

            }else{
                //BEGIN DASHBOARD HEADER
                $zf_widgetFolder = "header_bars"; $zf_widgetFile = "dashboard_header.php";
                Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile, $identificationCodeArray);
                //END DASHBOARD HEADER
            }
        
        ?> 
        
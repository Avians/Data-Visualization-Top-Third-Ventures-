<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE APPLICATION DEFAULT HEADER THAT IS RENDERED WHEN THE APPLICATION
 * IS SET TO BE UNDER CONSTRUCTION AND THE CONSTRUCTION INDICATOR IS SET TO 
 * DEFAULT
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
    <head>    
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
            
        
        ?>  
            
            
    </head>
    <body>
        
        <!--This is the start of the page's header section-->
        <div class="zf_content_header">
            Header goes here.<br>
        </div>
        <!--This is the end of the page's header section-->
        
        <!-- This is the start of the page's content section -->
        <div class="zf_content_body">
  
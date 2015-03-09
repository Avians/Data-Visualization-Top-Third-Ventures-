<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
        <div class="container-fluid">

            <!-- BEGIN LOGO -->
            <?php
                //echo "<code>"; print_r($zf_externalWidgetData); echo "</code>"; exit(); //This is strictly for debugging purposes.
            
                $userIdentificationArray = $zf_externalWidgetData;
            
                $main_logo = array(
                    'name' => '<p>Top3 Tracker<sup>TM</sup></p>',
                    'controller' => 'index',
                    'action' => '',
                    'parameter' => '',
                    'title' => '',
                    'style' => 'brand',
                    'id' => ''
                );
                Zf_GenerateLinks::zf_internal_link($main_logo);
                
            ?>
            <!-- END LOGO -->

            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                <img src="<?php echo ZF_ROOT_PATH . ZF_CLIENT . 'zf_app_global' . DS . 'app_global_files' . DS . 'app_global_images' . DS . 'menu-toggler.png'; ?>" alt="Menu Bar" />
            </a>          
            <!-- END RESPONSIVE MENU TOGGLER -->

            <!-- BEGIN TOP NAVIGATION MENU -->              
            <ul class="nav pull-right">
                <?php
                /* BEGIN NOTIFICATION DROPDOWN */
                Zf_ApplicationWidgets::zf_load_widget("header_bars", "notifications.php", $userIdentificationArray);
                /* END NOTIFICATION DROPDOWN */


                /* BEGIN INBOX DROPDOWN */
                Zf_ApplicationWidgets::zf_load_widget("header_bars", "messages.php", $userIdentificationArray);
                /* END INBOX DROPDOWN */


                /*  BEGIN TODO DROPDOWN */
                Zf_ApplicationWidgets::zf_load_widget("header_bars", "pending_tasks.php", $userIdentificationArray);
                /* END TODO DROPDOWN */


                /* BEGIN USER LOGIN DROPDOWN */
                Zf_ApplicationWidgets::zf_load_widget("header_bars", "user_section.php", $userIdentificationArray);
                /* END USER LOGIN DROPDOWN */
                ?>
            </ul>
            <!-- END TOP NAVIGATION MENU --> 
        </div>
    </div>
    <!-- END TOP NAVIGATION BAR -->
    <!-- THIS IS THE START OF THE BETA RIBBON-->
        <?php
        $devicePC = Zf_DeviceDetect::zf_detectPC(); $deviceTablet = Zf_DeviceDetect::zf_detectTablet(); $deviceMobile = Zf_DeviceDetect::zf_detectMobile();
        if($devicePC === True){
        ?>
        <div class="span1">
             <div class="ribbon-wrapper">
                 <div class="ribbon-wrapper-green">
                     <div class="ribbon-green">ALPHA</div>
                 </div>
             </div>
         </div>
        <?php } ?>
        <!-- THIS IS THE END OF THE BETA RIBBON-->
</div>

<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS SYSTEM ERROR 202 FILE. ITS AN ERROR RENDERED WHEN THE SELECETD ACTION
 * IS INVALID. I.E THE REQUESTED ACTION IS NOT AMONG THE EXECUTABLE ACTIONS IN A
 * GIVEN CONTROLLER.
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

?>
<!-- BEGIN PAGE -->
<div class="page-content">

    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">

        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">    
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    This dashboard interface is in development!!
                </h3>

                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="index.html">Home</a> 
                        <i class="icon-angle-right"></i>
                    </li>
                    <li><a href="#">Dashboard</a></li>
                    <li class="pull-right no-text-shadow">
                        <div id="dashboard-report-range" class="dashboard-date-range tooltips no-tooltip-on-touch-device responsive" data-tablet="" data-desktop="tooltips" data-placement="top" data-original-title="Change dashboard date range">
                            <i class="icon-calendar"></i>
                            <span></span>
                            <i class="icon-angle-down"></i>
                        </div>
                    </li>
                </ul>

                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->

        <div id="dashboard">

            <div class="clearfix"></div>
            <div class="row-fluid">
                <div class="span8 offset2 default-error">
                    <?php 
                        //echo $zf_actionData; 
                        
                    ?>
                    <img src="<?php echo ZF_ROOT_PATH.ASSETS_VIEWS.'zf_default_errors'.DS.'view_client'.DS.'zf_view_global'.DS.'view_files'.DS.'view_images'.DS.'Under-Construction.jpg'; ?>" alt="under construction" >
                    <div class="clearfix"><hr></div>
                    <div class="construction-info">
                        <p><h3>While our Top Third Ventures team is working on this section of the portal, you may pass your ideas or comments for consideration via ,</h3></p>
                    <p><a href="mailto:developers@topthirdventures.com">developers@topthirdventures.com</a></p>
                    </div>
                </div>	
            </div>
        </div>

    </div>
    <!-- END PAGE CONTAINER-->    
</div>
<!-- END PAGE -->



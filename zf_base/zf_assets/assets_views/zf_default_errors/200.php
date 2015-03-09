<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS SYSTEM ERROR 200 FILE. ITS AN ERROR RENDERED WHEN THE DEFAULT ACTION
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
                    TTV Dashboard Error!!
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
                <div class="span8 offset3 default-error">
                    <?php echo $zf_actionData; ?>
                </div>	
            </div>
        </div>

    </div>
    <!-- END PAGE CONTAINER-->    
</div>
<!-- END PAGE -->


<?php
    //Load the model that has general information
    $zf_controller->Zf_loadModel("platform_overview", "generalinformation");
?>
    <!-- BEGIN PAGE -->
    <div class="page-content">
        
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <?php Zf_ApplicationWidgets::zf_load_widget("platform_overview", "session_user_details.php", $zf_actionData[4]); ?>
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="#">Home</a> 
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
                <?php Zf_ApplicationWidgets::zf_load_widget("platform_overview", "overview_statistics.php", $zf_actionData[4]); ?>
                <div class="clearfix"></div>
                <!--END OF PORTLET CONTAINERS-->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-wrench"></i>General Overview and Operations</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row-fluid" style="height:530px">
                                    <div class="span12">
                                        <!--BEGIN TABS-->
                                        <div class="tabbable tabbable-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#general_view" data-toggle="tab">General Overview</a></li>
                                                <li><a href="#new_sale" data-toggle="tab">Make New Sales</a></li>
                                                <li><a href="#update_sale" data-toggle="tab">Update Sales Data</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="general_view">
                                                    <p>General Data Overview.</p>
                                                    <p>
                                                        Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.
                                                        Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.
                                                        Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.
                                                    </p>
                                                    <div class="alert ">
                                                        Check out the below dropdown menu. Don't worry it won't get chopped out by the tab content.
                                                        Instead it will be opened as dropup menu.
                                                    </div>
                                                    <div class="btn-group">
                                                        <a class="btn green" href="#" data-toggle="dropdown">
                                                            Options
                                                            <i class="icon-angle-down"></i>
                                                        </a>
                                                        <div class="dropdown-menu bottom-up hold-on-click dropdown-checkboxes">
                                                            <label><input type="checkbox">Option 1</label>
                                                            <label><input type="checkbox">Option 2</label>
                                                            <label><input type="checkbox">Option 3</label>
                                                            <label><input type="checkbox">Option 4</label>
                                                            <label><input type="checkbox">Option 5</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="new_sale">
                                                    <div class='row-fluid'>
                                                        <div class='span12'>
                                                            <div class="portlet box yellow margin-bottom-10" id="form_wizard_1">
                                                                <div class="portlet-title">
                                                                    <div class="caption">
                                                                        <i class="icon-reorder"></i> New Sale - <span class="step-title">Step 1 of 4</span>
                                                                    </div>
                                                                </div>
                                                                <div class="portlet-body form">
                                                                    <?php
                                                                            $zf_widgetFolder = "forms"; $zf_widgetFile = "product_sale.php";
                                                                            Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="update_sale">
                                                    <p>Update Sales Data.</p>
                                                    <p>
                                                        Duis autem vel eum iriure dolor in hendrerit in vulputate.
                                                        Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat
                                                    </p>
                                                    <p>
                                                        <a class="btn yellow" href="ui_tabs_accordions.html#tab_1_3" target="_blank">Activate this tab via URL</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--END TABS-->
                                    </div>
                                </div>
                                <div class="scroller-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END OF PORTLET CONTAINERS-->
                <div class="clearfix"></div>
            </div>
            
        </div>
        <!-- END PAGE CONTAINER-->    
    </div>
    <!-- END PAGE -->



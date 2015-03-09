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
                    <div class="span9">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-globe"></i>Area of Presence</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
                                    Map Goes here
                                </div>
                                <div class="scroller-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-bar-chart"></i>Overall Statistics</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">           
                                   <?php Zf_ApplicationWidgets::zf_load_widget("platform_overview", "specific_statistics.php", $zf_actionData); ?>     
                                </div>
                                <div class="scroller-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-user"></i>Gender Ratio</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
                                    Content goes here
                                </div>
                                <div class="scroller-footer">
                                    <div id="slider-range" class="slider bg-green" style="width: 99%;"></div>
                                    <div class="slider-value pull-left">
                                          Age Range: <span id="slider-range-amount"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-time"></i>Age Distribution</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
                                    Content goes here
                                </div>
                                <div class="scroller-footer">
                                    <input type="text" id="someID" name="rangeName" value="10;100" />
                                </div>
                            </div>
                        </div>
                    </div>	
                </div>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-book"></i>Eduction Level</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
                                    Content goes here
                                </div>
                                <div class="scroller-footer">
                                    <div class="pull-right">
                                        <a href="#">See All Records <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-certificate"></i>Marital Status</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
                                    Content goes here
                                </div>
                                <div class="scroller-footer">
                                    <div class="pull-right">
                                        <a href="#">See All Records <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-briefcase"></i>Occupation</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
                                    Content goes here
                                </div>
                                <div class="scroller-footer">
                                    <div class="pull-right">
                                        <a href="#">See All Records <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-money"></i>Annual Income</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">
                                    Content goes here
                                </div>
                                <div class="scroller-footer">
                                    <div class="pull-right">
                                        <a href="#">See All Records <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                    </div>
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


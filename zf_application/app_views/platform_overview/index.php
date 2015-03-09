<?php
    //Load the model that has general information
    $zf_controller->Zf_loadModel("platform_overview", "GeneralInformation"); 
?>
    <!-- BEGIN PAGE -->
    <div class="page-content">
        
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <?php Zf_ApplicationWidgets::zf_load_widget("platform_overview", "session_user_details.php"); ?>
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
                                <div class="caption"><i class="icon-globe"></i>Project Countries</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload" id='reload-countries'></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body" id='project-countries'>
                                <div class="scroller" style="height:310px" data-always-visible="0" data-rail-visible="0">
                                    <?php $zf_controller->zf_targetModel->ProjectAreas(); ?>
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
                                <div  style="height:290px" data-always-visible="0" data-rail-visible="0">
                                    <!--Start of the gender chart-->
                                    <div id="genderChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                    <!--End of the gender chart-->
                                </div>
                                <div class="scroller-footer">
                                    <input type="text" id="genderSlider" name="ageRange" value="10;100" style="width: 100% !important;"/>
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
                                <div class="scroller" style="height:290px" data-always-visible="1" data-rail-visible="0">
                                    <!--Start of the age chart-->
                                    <div id="ageChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                    <!--End of the age chart-->
                                </div>
                                <div class="scroller-footer">
                                    <div class="pull-right">
                                        <div class="actions">
                                            <div class="btn-group">
                                                <a class="btn" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    Filter By
                                                    <i class="icon-angle-down"></i>
                                                </a>
                                                <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                                                    <label><input type="radio" id="ageFilter" name="genderFilter" value="all" checked="checked"> All</label>
                                                    <label><input type="radio" id="ageFilter" name="genderFilter" value="male"> Male</label>
                                                    <label><input type="radio" id="ageFilter" name="genderFilter" value="female"> Female</label>
                                                </div>
                                            </div>
                                        </div>
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
                                <div class="caption"><i class="icon-book"></i>Education Level</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:290px" data-always-visible="1" data-rail-visible="0">
                                    <!--Start of the age chart-->
                                    <div id="educationChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                    <!--End of the age chart-->
                                </div>
                                <div class="scroller-footer">
                                    <div class="pull-right">
                                        <div class="actions">
                                            <div class="btn-group">
                                                <a class="btn" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    Filter By
                                                    <i class="icon-angle-down"></i>
                                                </a>
                                                <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                                                    <label><input type="radio" id="educationFilter" name="educationFilter" value="all" checked="checked"> All</label>
                                                    <label><input type="radio" id="educationFilter" name="educationFilter" value="male"> Male</label>
                                                    <label><input type="radio" id="educationFilter" name="educationFilter" value="female"> Female</label>
                                                </div>
                                            </div>
                                        </div>
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
                                <div  style="height:290px" data-always-visible="0" data-rail-visible="0">
                                    <!--Start of the gender chart-->
                                    <div id="maritalChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                    <!--End of the gender chart-->
                                </div>
                                <div class="scroller-footer">
                                    <input type="text" id="maritalSlider" name="ageRange" value="10;100" style="width: 100% !important;"/>
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
                                <div class="scroller" style="height:290px" data-always-visible="1" data-rail-visible="0">
                                    <!--Start of the age chart-->
                                    <div id="occupationChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                    <!--End of the age chart-->
                                </div>
                                <div class="scroller-footer">
                                    <div class="pull-right">
                                        <div class="actions">
                                            <div class="btn-group">
                                                <a class="btn" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    Filter By
                                                    <i class="icon-angle-down"></i>
                                                </a>
                                                <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                                                    <label><input type="radio" id="occupationFilter" name="occupationFilter" value="all" checked="checked"> All</label>
                                                    <label><input type="radio" id="occupationFilter" name="occupationFilter" value="male"> Male</label>
                                                    <label><input type="radio" id="occupationFilter" name="occupationFilter" value="female"> Female</label>
                                                </div>
                                            </div>
                                        </div>
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
                                <div  style="height:290px" data-always-visible="0" data-rail-visible="0">
                                    <!--Start of the gender chart-->
                                    <div id="incomeChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                    <!--End of the gender chart-->
                                </div>
                                <div class="scroller-footer">
                                    <input type="text" id="incomeSlider" name="ageRange" value="10;100" style="width: 100% !important;"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END OF PORTLET CONTAINERS-->
                <div class="clearfix"><br><br></div>
            </div>
            
        </div>
        <!-- END PAGE CONTAINER-->    
    </div>
    <!-- END PAGE -->
    <script typr="text/javascript">
    $(document).ready(function() {

        //Here we are generating the applications absolute path.
        var $absolute_path = "<?php echo ZF_ROOT_PATH; ?>";
        var $separator = "<?php echo DS; ?>";
        
        IonSliders.genderRatio($absolute_path, $separator );
        IonSliders.ageBracket($absolute_path, $separator );
        IonSliders.educationLevel($absolute_path, $separator );
        IonSliders.maritalStatus($absolute_path, $separator );
        IonSliders.occupation($absolute_path, $separator );
        IonSliders.annualIncome($absolute_path, $separator );
        

    });
    </script>


<?php
    //Load the model that has general information
    $zf_controller->Zf_loadModel("platform_data", "AgeAnalysis");
    
   $dataFilter = explode("_", $zf_actionData); $portletTitle = $dataFilter[0]; $dataRange = $dataFilter[1];
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
                        <div class="portlet box">
                             <?php echo $zf_generateTable ; ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span9">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-globe"></i><?php echo $portletTitle; ?> Yrs, Project Countries</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:310px" data-always-visible="0" data-rail-visible="0">
                                    <?php //$zf_controller->zf_targetModel->ProjectAreas(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-bar-chart"></i><?php echo $portletTitle; ?> Yrs, Statistics</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">           
                                    <?php
                                        $zf_controller->Zf_loadModel("platform_data", "general_statistics");
                                        $houseHolds        = $zf_controller->zf_targetModel->HouseHolds("ageBracket_".$zf_actionData);
                                        $allChildren       = $zf_controller->zf_targetModel->AllChildren("ageBracket_".$zf_actionData);
                                        $childrenUnderFive = $zf_controller->zf_targetModel->ChildrenUnderFive("ageBracket_".$zf_actionData);
                                        $allBenefactors    = $zf_controller->zf_targetModel->AllBenefactors("ageBracket_".$zf_actionData);
                                    ?>
                                    <!--This is the data for all house holds-->
                                    <div class="span6 responsive" data-tablet="span12" data-desktop="span6">
                                        <div class="dashboard-stat blue">
                                            <div class="details">
                                                <div class="number"><?php echo $houseHolds; ?></div>
                                                <div class="desc">Total of Households</div>
                                            </div>
                                            <a class="more" href="#">View more <i class="m-icon-swapright m-icon-white"></i></a>                 
                                        </div>
                                    </div>

                                    <!--This is the data for all children-->
                                    <div class="span6 responsive" data-tablet="span12" data-desktop="span6">
                                        <div class="dashboard-stat green">
                                            <div class="details">
                                                <div class="number"><?php echo $allChildren; ?></div>
                                                <div class="desc">Total of Children</div>
                                            </div>
                                            <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
                                        </div>
                                    </div>
                                    
                                    <!--This is the data for all children under 5 years-->
                                    <div class="span6 responsive" data-tablet="span12" data-desktop="span6">
                                        <div class="dashboard-stat red">
                                            <div class="details">
                                                <div class="number"><?php echo $childrenUnderFive; ?></div>
                                                <div class="desc">Children below 5 years</div>
                                            </div>
                                            <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
                                        </div>
                                    </div>

                                    <!--This is the data for all project benefactors-->
                                    <div class="span6 responsive" data-tablet="span12" data-desktop="span6">
                                        <div class="dashboard-stat purple">
                                            <div class="details">
                                                <div class="number"><?php echo $allBenefactors; ?></div>
                                                <div class="desc">Total Project Benefactors</div>
                                            </div>
                                            <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="scroller-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-time"></i>Gender Filter <?php echo $portletTitle." Yrs by:"; ?></div>
                                <div class="actions">
                                    <div class="btn-group">
                                        <a class="btn" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            Filter By
                                            <i class="icon-angle-down"></i>
                                        </a>
                                        <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                                            
                                            <input type="hidden" id="ageBracket" name="ageBacket" value="<?php echo $portletTitle; ?>" />
                                            <input type="hidden" id="activeGender" name="activeGender" value="<?php echo $dataRange; ?>" />
                                            
                                            <label><input type="radio" id="ageFilter" name="genderFilter" value="all" <?php if($dataRange == 'all'){echo 'checked="checked"';}?> > All</label>
                                            <label><input type="radio" id="ageFilter" name="genderFilter" value="male" <?php if($dataRange == 'male'){echo 'checked="checked"';}?>> Male</label>
                                            <label><input type="radio" id="ageFilter" name="genderFilter" value="female" <?php if($dataRange == 'female'){echo 'checked="checked"';}?>> Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php
                    //Load the model that has general information
                    $zf_controller->Zf_loadModel("platform_data", "ageanalysis");
                ?>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-time"></i><?php echo $portletTitle; ?> Yrs, Gender Ratio</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--Start of the gender chart-->
                                <div id="genderChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                <!--End of the gender chart-->
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-certificate"></i><?php echo $portletTitle; ?> Yrs, Marital Status</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--Start of the marital status chart-->
                                <div id="maritalChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                <!--End of the marital status chart-->
                            </div>
                        </div>
                    </div>	
                </div>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-book"></i><?php echo $portletTitle; ?> Yrs, Eduction Level</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--Start of the education level chart-->
                                <div id="educationChart" style="height:240px" data-always-visible="0" data-rail-visible="0"></div>
                                <!--End of the education level chart-->
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-briefcase"></i><?php echo $portletTitle; ?> Yrs, Occupation</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--Start of the occupation chart-->
                                <div id="occupationChart" style="height:240px" data-always-visible="0" data-rail-visible="0"></div>
                                <!--End of the occupation chart-->
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-money"></i><?php echo $portletTitle; ?> Yrs, Annual Income</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--Start of the income chart-->
                                <div id="incomeChart" style="height:240px" data-always-visible="0" data-rail-visible="0"></div>
                                <!--End of the income chart-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!--END OF PORTLET CONTAINERS-->
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
        var $current_view = "ageAnalysis";
        
        ChartDrawer.init($current_view, $absolute_path, $separator );
        

    });
    </script>


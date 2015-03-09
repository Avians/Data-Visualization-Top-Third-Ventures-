<?php
    
    $sessionUserArray = Zf_Core_Functions::Zf_DecodeIdentificationCode(Zf_SessionHandler::zf_getSessionVariable("ttv_identificationCode"));
    
    
    //Load the model that has general information
    $zf_controller->Zf_loadModel("platform_data", "GenderAnalysis");
    
    $dataFilter = explode("_", $zf_actionData); $portletTitle = $dataFilter[0]; $dataRange = $dataFilter[1];
?>
    <!-- BEGIN PAGE -->
    <div class="page-content">
        
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <?php Zf_ApplicationWidgets::zf_load_widget("platform_overview", "session_user_details.php", $sessionUserArray[4]); ?>
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
                             <?php echo $zf_generateTable; ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span9">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-globe"></i><?php echo $portletTitle; ?> Project Countries</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:310px" data-always-visible="0" data-rail-visible="0">
                                    <?php  $zf_controller->zf_targetModel->ProjectAreas();  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-bar-chart"></i><?php echo $portletTitle; ?> Statistics</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="0">           
                                   <?php
                                        $zf_controller->Zf_loadModel("platform_data", "general_statistics");
                                        $houseHolds        = $zf_controller->zf_targetModel->HouseHolds("gender_".$zf_actionData);
                                        $allChildren       = $zf_controller->zf_targetModel->AllChildren("gender_".$zf_actionData);
                                        $childrenUnderFive = $zf_controller->zf_targetModel->ChildrenUnderFive("gender_".$zf_actionData);
                                        $allBenefactors    = $zf_controller->zf_targetModel->AllBenefactors("gender_".$zf_actionData);
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
                                <div class="caption"><i class="icon-time"></i>Age Range Slider</div>
                            </div>
                            <div class="portlet-body">
                                <div id="slider-wrapper" style="height:35px" data-always-visible="0" data-rail-visible="0">
                                    <!--Start of the gender chart-->
                                    <!--<input type="text" id="ageSlider" name="ageRange" value="" style="width: 100% !important;"/>-->
                                    <input type="hidden" id="gender" name="gender" value="<?php echo $portletTitle; ?>" />
                                    <input type="text" id="genderSlider" name="ageRange" value="<?php echo $dataRange; ?>" style="width: 100% !important;"/>
                                    <!--End of the gender chart-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php
                    //Load the model that has general information
                    $zf_controller->Zf_loadModel("platform_data", "genderanalysis");
                ?>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-time"></i><?php echo $portletTitle; ?> Age Distribution</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--Start of the age chart-->
                                <div id="ageChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                <!--End of the age chart-->
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-certificate"></i><?php echo $portletTitle; ?> Marital Status</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--Start of the marital chart-->
                                <div id="maritalChart" style="height:290px" data-always-visible="0" data-rail-visible="0"></div>
                                <!--End of the marital chart-->
                            </div>
                        </div>
                    </div>	
                </div>
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption"><i class="icon-book"></i><?php echo $portletTitle; ?> Education Level</div>
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
                                <div class="caption"><i class="icon-briefcase"></i> <?php echo $portletTitle; ?> Occupation</div>
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
                                <div class="caption"><i class="icon-money"></i><?php echo $portletTitle; ?> Annual Income</div>
                                <div class="tools">
                                    <a href="" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="" class="reload"></a>
                                    <a href="" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--Start of the annual income chart-->
                                <div id="incomeChart" style="height:240px" data-always-visible="0" data-rail-visible="0"></div>
                                <!--End of the annual income chart-->
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
        var $current_view = "genderAnalysis";
        
        ChartDrawer.init($current_view, $absolute_path, $separator );
        

    });
    </script>
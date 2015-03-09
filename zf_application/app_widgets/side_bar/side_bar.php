<?php

//echo "<br><br><code>"; print_r($zf_externalWidgetData); echo "</code>"; //This is strictly for debugging purposes.

$identificationCode = Zf_SessionHandler::zf_getSessionVariable('ttv_identificationCode');

$identificationCodeArray = $zf_externalWidgetData;


//echo "<br><br><code>"; print_r($identificationCodeArray);echo "</code>";  exit();

//THIS IS THE SECTION THAT HANDLES THE PROCESSING OF THE SIDE BAR MENU.

    function PorcessActiveParameter($parameter = NULL) {
        
        $url_encryption_status = Zf_Configurations::Zf_ApplicationDefaults();
        
        //check if encryption has been enabled. So decrypt the parameter
        if ($url_encryption_status['application_urlencrypt'] === "enabled") {
            
            $safe_parameter = Zf_SecureData::zf_decode_data($parameter);
            
        }else{
            
            $safe_parameter = $parameter;
            
        }
        
        return $safe_parameter;
    }
    
    //THE SIDE BAR MENU ARRAY. IT CONTAINS ALL THE MENU ITEMS FOR THE SIDE BAR.

    $side_menu = array(
        
        //START PLATFORM OVERVIEW
        "dashboard_overview" => array(
            'name' => '<i class="icon-dashboard"></i><span class="title">Dashboard Overview</span><span class="selected"></span>',
            'controller' => 'platform_overview',
            'action' => 'index',
            'parameter' => $identificationCode,
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
         
        //START PLATFORM CLIENTS
        "register_client" => array(
            'name' => '<i class="icon-book"></i> Register New Client',
            'controller' => 'platform_clients',
            'action' => 'register_client',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "clients_directory" => array(
            'name' => '<i class="icon-folder-open"></i> Clients Directory',
            'controller' => 'platform_clients',
            'action' => 'clients_directory',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "suspended_clients" => array(
            'name' => '<i class="icon-ban-circle"></i><span class=" badge badge-warning">4</span> Suspended Clients',
            'controller' => 'platform_clients',
            'action' => 'suspended_clients',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "client_reports" => array(
            'name' => '<i class="icon-bar-chart"></i> Client Reports',
            'controller' => 'platform_clients',
            'action' => 'client_reports',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "client_scheduled_tasks" => array(
            'name' => '<i class="icon-time"></i><span class=" badge badge-important">9</span> Scheduled Tasks',
            'controller' => 'platform_clients',
            'action' => 'client_scheduled_tasks',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        
        //START PLATFORM USERS
        "register_user" => array(
            'name' => '<i class="icon-book"></i> Register New User',
            'controller' => 'platform_users',
            'action' => 'register_user',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "users_directory" => array(
            'name' => '<i class="icon-folder-open"></i> Users Directory',
            'controller' => 'platform_users',
            'action' => 'users_directory',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "suspended_users" => array(
            'name' => '<i class="icon-ban-circle"></i><span class=" badge badge-warning">4</span> Suspended Users',
            'controller' => 'platform_users',
            'action' => 'suspended_users',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "user_reports" => array(
            'name' => '<i class="icon-bar-chart"></i> User Reports',
            'controller' => 'platform_users',
            'action' => 'user_reports',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "user_scheduled_tasks" => array(
            'name' => '<i class="icon-time"></i><span class=" badge badge-important">9</span> Scheduled Tasks',
            'controller' => 'platform_users',
            'action' => 'user_scheduled_tasks',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        
        //START PLATFORM COMMUNICATION
        "compose_email" => array(
            'name' => '<i class="icon-edit"></i> Compose Email',
            'controller' => 'platform_communication',
            'action' => 'emails',
            'parameter' => 'compose_email',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "email_inbox" => array(
            'name' => '<i class="icon-inbox"></i><span class="badge badge-important">15</span> Inbox',
            'controller' => 'platform_communication',
            'action' => 'emails',
            'parameter' => 'email_inbox',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "email_outbox" => array(
            'name' => '<i class="icon-mail-reply"></i><span class="badge badge-info">20</span> Outbox',
            'controller' => 'platform_communication',
            'action' => 'emails',
            'parameter' => 'email_outbox',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "email_draft" => array(
            'name' => '<i class="icon-save"></i><span class="badge badge-success">2</span> Draft',
            'controller' => 'platform_communication',
            'action' => 'emails',
            'parameter' => 'email_draft',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "email_trash" => array(
            'name' => '<i class="icon-trash"></i><span class="badge badge-warning">15</span> Trash',
            'controller' => 'platform_communication',
            'action' => 'emails',
            'parameter' => 'email_trash',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "compose_sms" => array(
            'name' => '<i class="icon-edit"></i>Compose SMS',
            'controller' => 'platform_communication',
            'action' => 'sms',
            'parameter' => 'compose_sms',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "sms_inbox" => array(
            'name' => '<i class="icon-inbox"></i> <span class="badge badge-important">15</span> SMS Inbox',
            'controller' => 'platform_communication',
            'action' => 'sms',
            'parameter' => 'sms_inbox',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "sms_outbox" => array(
            'name' => '<i class="icon-mail-reply"></i><span class="badge badge-info">20</span> SMS Outbox',
            'controller' => 'platform_communication',
            'action' => 'sms',
            'parameter' => 'sms_outbox',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "sms_draft" => array(
            'name' => '<i class="icon-save"></i><span class="badge badge-success">2</span> SMS Draft',
            'controller' => 'platform_communication',
            'action' => 'sms',
            'parameter' => 'sms_draft',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "sms_trash" => array(
            'name' => '<i class="icon-trash"></i> <span class="badge badge-warning">15</span> SMS Trash',
            'controller' => 'platform_communication',
            'action' => 'sms',
            'parameter' => 'sms_trash',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "sms_history" => array(
            'name' => '<i class="icon-archive"></i> SMS History',
            'controller' => 'platform_communication',
            'action' => 'sms',
            'parameter' => 'sms_history',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "chart_board" => array(
            'name' => '<i class="icon-comments"></i> Chart Board',
            'controller' => 'platform_communication',
            'action' => 'chart_board',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
                   
        //START PLATFORM DATA
        "data_overview" => array(
            'name' => '<i class="icon-dashboard"></i> Data Overview',
            'controller' => 'platform_data',
            'action' => 'data_overview',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "customer_data" => array(
            'name' => '<i class="icon-group"></i> Customers Data',
            'controller' => 'platform_data',
            'action' => 'customer_data',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "sales_data" => array(
            'name' => '<i class="icon-money"></i> Sales Data',
            'controller' => 'platform_data',
            'action' => 'sales_data',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "product_data" => array(
            'name' => '<i class="icon-shopping-cart"></i> Product Data',
            'controller' => 'platform_data',
            'action' => 'product_data',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "data_segmentation" => array(
            'name' => '<i class="icon-signal"></i> Data Segmentation',
            'controller' => 'platform_data',
            'action' => 'data_segmentation',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "data_analytics" => array(
            'name' => '<i class="icon-bar-chart"></i> Data Analytics',
            'controller' => 'platform_data',
            'action' => 'data_analytics',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        
        //START CURRENT PROJECTS
        "client_projects" => array(
            'name' => '<i class="icon-group"></i><span class="badge badge-info">15</span> All Client Projects',
            'controller' => 'platform_projects',
            'action' => 'client_projects',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "platform_projects" => array(
            'name' => '<i class="icon-briefcase"></i><span class="badge badge-info">5</span> Platform Projects',
            'controller' => 'platform_projects',
            'action' => 'platform_projects',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
         
        
        //START PLATFORM REPORTS
        "clients_reports" => array(
            'name' => '<i class="icon-folder-open"></i> Clients Reports',
            'controller' => 'platform_reports',
            'action' => 'clients_reports',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "customer_reports" => array(
            'name' => '<i class="icon-file-text"></i> Customer Reports',
            'controller' => 'platform_reports',
            'action' => 'project_reports',
            'parameter' => 'customer_reports',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "sales_reports" => array(
            'name' => '<i class="icon-file-text"></i> Sales Reports',
            'controller' => 'platform_reports',
            'action' => 'project_reports',
            'parameter' => 'sales_reports',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        
        //START PLATFORM MAPS
        "clients_maps" => array(
            'name' => '<i class="icon-map-marker"></i> Clients Location Maps',
            'controller' => 'platform_maps',
            'action' => 'clients_maps',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "project_maps" => array(
            'name' => '<i class="icon-map-marker"></i> Project Location Maps',
            'controller' => 'platform_maps',
            'action' => 'project_maps',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        
        //START PLATFORM CHARTS
        "clients_charts" => array(
            'name' => '<i class="icon-film"></i> Clients Charts',
            'controller' => 'platform_charts',
            'action' => 'clients_charts',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        "project_charts" => array(
            'name' => '<i class="icon-film"></i> Project Charts',
            'controller' => 'platform_charts',
            'action' => 'project_charts',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
        
        //START PLATFORM SETTINGS
        "dashboard_settings" => array(
            'name' => '<i class="icon-cogs"></i><span class="title">Dashboard Settings</span><span class="selected "></span>',
            'controller' => 'platform_settings',
            'action' => '',
            'parameter' => '',
            'title' => '',
            'style' => '',
            'id' => ''
        ),

    );
    
    $active_menu_item = Zf_Core_Functions::Zf_URLSanitize();

?>
<?php
if($identificationCodeArray[4] != GUEST_USER && $identificationCodeArray[4] != BANNED_USER){
?>

<div class="page-sidebar nav-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->        
    <ul class="page-sidebar-menu">
        <li>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler hidden-phone"></div>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        </li>
        <li>
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <form class="sidebar-search">
                <div class="input-box">
                    <a href="javascript:;" class="remove"></a>
                    <input type="text" placeholder="Search..." />
                    <input type="button" class="submit" value=" " />
                </div>
            </form>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        
        <!-- BEGIN DASHBOARD OVERVIEW-->
        <li class="<?php if (empty($active_menu_item[0]) || ($active_menu_item[0] == "platform_overview")) { echo "active";} ?>" >
            <?php Zf_GenerateLinks::zf_internal_link($side_menu['dashboard_overview']); ?>
        </li>
        <!-- END DASHBOARD OVERVIEW-->

        <?php
            if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
        ?>
        <!-- BEGIN MANAGE CLIENTS-->
        <li class="<?php if ($active_menu_item[0] == "platform_clients") { echo "active";} ?>">
            <a href="javascript:;">
                <i class="icon-group"></i> 
                <span class="title">Manage Clients</span>
                <?php if ($active_menu_item[0] == "platform_clients") { ?><span class="selected "></span><?php }?>
                <span class="arrow <?php if ($active_menu_item[0] == "platform_clients") { echo "open";} ?>"></span>
            </a>
            <ul class="sub-menu">
                <li class="<?php if ($active_menu_item[0] == "platform_clients" && $active_menu_item[1] == "register_client") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['register_client']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_clients" && $active_menu_item[1] == "clients_directory") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['clients_directory']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_clients" && $active_menu_item[1] == "suspended_clients") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['suspended_clients']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_clients" && $active_menu_item[1] == "client_reports") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['client_reports']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_clients" && $active_menu_item[1] == "scheduled_tasks") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['client_scheduled_tasks']); ?>        
                </li>

            </ul>
        </li>
        <!-- END MANAGE CLIENTS-->
        <?php
            }
            
            if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN || $identificationCodeArray[4] == COMPANY_ADMIN){
        ?>
        <!-- BEGIN MANAGE USERS-->
        <li class="<?php if ($active_menu_item[0] == "platform_users") { echo "active";} ?>">
            <a href="javascript:;">
                <i class="icon-user"></i> 
                <span class="title">Manage Users</span>
                <?php if ($active_menu_item[0] == "platform_users") { ?><span class="selected "></span><?php }?>
                <span class="arrow <?php if ($active_menu_item[0] == "platform_users") { echo "open";} ?>"></span>
            </a>
            <ul class="sub-menu">
                <li class="<?php if ($active_menu_item[0] == "platform_users" && $active_menu_item[1] == "register_user") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['register_user']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_users" && $active_menu_item[1] == "users_directory") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['users_directory']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_users" && $active_menu_item[1] == "suspended_users") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['suspended_users']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_users" && $active_menu_item[1] == "user_reports") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['user_reports']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_users" && $active_menu_item[1] == "scheduled_tasks") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['user_scheduled_tasks']); ?>        
                </li>

            </ul>
        </li>
        <!-- END MANAGE USERS-->
        <?php
            }
            
            if($identificationCodeArray[4] != BANNED_USER){
        ?>
        <!-- BEGIN COMMUNICATION-->
        <li class="<?php if ($active_menu_item[0] == "platform_communication") { echo "active";} ?>">
            <a href="javascript:;">
                <i class="icon-comments"></i>
                <span class="title">Communication</span>
                <?php if ($active_menu_item[0] == "platform_communication") { ?><span class="selected "></span><?php }?>
                <span class="arrow <?php if ($active_menu_item[0] == "platform_communication") { echo "open";} ?>"></span>
            </a>
            <ul class="sub-menu">
                <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "emails") { echo "active";} ?>" >
                    <a href="javascript:;">
                        <i class="icon-envelope"></i> Email
                        <span class="arrow <?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "emails") { echo "open";} ?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "emails" && PorcessActiveParameter($active_menu_item[2]) == "compose_email") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['compose_email']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "emails" && PorcessActiveParameter($active_menu_item[2]) == "email_inbox") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['email_inbox']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "emails" && PorcessActiveParameter($active_menu_item[2]) == "email_outbox") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['email_outbox']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "emails" && PorcessActiveParameter($active_menu_item[2]) == "email_draft") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['email_draft']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "emails" && PorcessActiveParameter($active_menu_item[2]) == "email_trash") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['email_trash']); ?>
                        </li>
                    </ul>
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "sms") { echo "active";} ?>" >
                    <a href="javascript:;">
                        <i class="icon-comment"></i> SMS
                        <span class="arrow <?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "sms") { echo "open";} ?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "sms" && PorcessActiveParameter($active_menu_item[2]) == "compose_sms") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['compose_sms']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "sms" && PorcessActiveParameter($active_menu_item[2]) == "sms_inbox") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['sms_inbox']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "sms" && PorcessActiveParameter($active_menu_item[2]) == "sms_outbox") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['sms_outbox']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "sms" && PorcessActiveParameter($active_menu_item[2]) == "sms_draft") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['sms_draft']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "sms" && PorcessActiveParameter($active_menu_item[2]) == "sms_trash") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['sms_trash']); ?>
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "sms" && PorcessActiveParameter($active_menu_item[2]) == "sms_history") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['sms_history']); ?>
                        </li>
                    </ul>
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_communication" && $active_menu_item[1] == "chart_board") { echo "active";} ?>">
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['chart_board']); ?>
                </li>
            </ul>
        </li>
        <!-- END COMMUNICATION-->
        <?php
            }
            
            if($identificationCodeArray[4] != INACTIVE_USER && $identificationCodeArray[4] != BANNED_USER){
        ?>
        <!-- BEGIN PLATFORM DATA-->
        <li class="<?php if ($active_menu_item[0] == "platform_data") { echo "active";} ?>">
            <a href="javascript:;">
                <i class="icon-cloud"></i> 
                <span class="title">Platform Data</span>
                <?php if ($active_menu_item[0] == "platform_data") { ?><span class="selected "></span><?php }?>
                <span class="arrow <?php if ($active_menu_item[0] == "platform_data") { echo "open";} ?>"></span>
            </a>
            <ul class="sub-menu">
                <li class="<?php if ($active_menu_item[0] == "platform_data" && $active_menu_item[1] == "data_overview") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['data_overview']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_data" && $active_menu_item[1] == "customer_data") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['customer_data']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_data" && $active_menu_item[1] == "sales_data") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['sales_data']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_data" && $active_menu_item[1] == "product_data") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['product_data']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_data" && $active_menu_item[1] == "data_segmentation") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['data_segmentation']); ?>        
                </li>
                <li class="<?php if ($active_menu_item[0] == "platform_data" && $active_menu_item[1] == "data_analytics") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['data_analytics']); ?>        
                </li>
            </ul>
        </li>
        <!-- END PLATFORM DATA-->
        <?php
            }
        ?>
        <!-- BEGIN CURRENT PROJECTS-->
        <li class="<?php if ($active_menu_item[0] == "platform_projects") { echo "active";} ?>">
            <a href="javascript:;">
                <i class="icon-glass"></i> 
                <span class="title">Current Projects</span>
                <?php if ($active_menu_item[0] == "platform_projects") { ?><span class="selected "></span><?php }?>
                <span class="arrow <?php if ($active_menu_item[0] == "platform_projects") { echo "open";} ?>"></span>
            </a>
            <ul class="sub-menu">
                <?php
                    if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
                ?>
                <li class="<?php if ($active_menu_item[0] == "platform_projects" && $active_menu_item[1] == "client_projects") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['client_projects']); ?>        
                </li>
                <?php 
                    }
                    if($identificationCodeArray[4] != INACTIVE_USER && $identificationCodeArray[4] != BANNED_USER){
                ?>
                <li class="<?php if ($active_menu_item[0] == "platform_projects" && $active_menu_item[1] == "platform_projects") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['platform_projects']); ?>        
                </li>
                <?php
                    }
                ?>
            </ul>
        </li>
        <!-- END CURRENT PROJECTS-->
        
        <!-- BEGIN REPORTS-->
        <li class="<?php if ($active_menu_item[0] == "platform_reports") { echo "active";} ?>">
            <a href="javascript:;">
                <i class="icon-book"></i> 
                <span class="title">Reports</span>
                <?php if ($active_menu_item[0] == "platform_reports") { ?><span class="selected "></span><?php }?>
                <span class="arrow <?php if ($active_menu_item[0] == "platform_reports") { echo "open";} ?>"></span>
            </a>
            <ul class="sub-menu">
                <?php
                    if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
                ?>
                <li class="<?php if ($active_menu_item[0] == "platform_reports" && $active_menu_item[1] == "clients_reports") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['clients_reports']); ?>    
                </li>
                <?php 
                    }
                    if($identificationCodeArray[4] != INACTIVE_USER && $identificationCodeArray[4] != BANNED_USER){
                ?>
                <li class="<?php if ($active_menu_item[0] == "platform_reports" && $active_menu_item[1] == "project_reports") { echo "active";} ?>" >
                    <a href="javascript:;">
                        <i class="icon-folder-open"></i> 
                        <span class="title">Platform Reports</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?php if ($active_menu_item[0] == "platform_reports" && $active_menu_item[1] == "project_reports" && $active_menu_item[2] == "customer_reports") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['customer_reports']); ?>  
                        </li>
                        <li class="<?php if ($active_menu_item[0] == "platform_reports" && $active_menu_item[1] == "project_reports" && $active_menu_item[2] == "sales_reports") { echo "active";} ?>" >
                            <?php Zf_GenerateLinks::zf_internal_link($side_menu['sales_reports']); ?>  
                        </li>
                    </ul>
                </li>
                <?php 

                    } 
                ?>
            </ul>
        </li>
        <!-- END REPORTS-->
        
        <!-- BEGIN MAPS-->
        <li class="<?php if ($active_menu_item[0] == "platform_maps") { echo "active";} ?>">
            <a href="javascript:;">
                <i class="icon-globe"></i> 
                <span class="title">Maps</span>
                <?php if ($active_menu_item[0] == "platform_maps") { ?><span class="selected "></span><?php }?>
                <span class="arrow <?php if ($active_menu_item[0] == "platform_maps") { echo "open";} ?>"></span>
            </a>
            <ul class="sub-menu">
                <?php
                    if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
                ?>
                <li class="<?php if ($active_menu_item[0] == "platform_maps" && $active_menu_item[1] == "clients_maps") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['clients_maps']); ?>        
                </li>
                <?php 
                    }
                    if($identificationCodeArray[4] != INACTIVE_USER && $identificationCodeArray[4] != BANNED_USER){
                ?>
                <li class="<?php if ($active_menu_item[0] == "platform_maps" && $active_menu_item[1] == "projects_maps") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['project_maps']); ?>        
                </li>
                <?php
                    }
                ?>
            </ul>
        </li>
        <!-- END MAPS-->
        
        <!-- BEGIN CHARTS-->
        <li class="<?php if ($active_menu_item[0] == "platform_charts") { echo "active";} ?>">
            <a href="javascript:;">
                <i class="icon-bar-chart"></i> 
                <span class="title">Visual Charts</span>
                <?php if ($active_menu_item[0] == "platform_charts") { ?><span class="selected "></span><?php }?>
                <span class="arrow <?php if ($active_menu_item[0] == "platform_charts") { echo "open";} ?>"></span>
            </a>
            <ul class="sub-menu">
                <?php
                    if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
                ?>
                <li class="<?php if ($active_menu_item[0] == "platform_charts" && $active_menu_item[1] == "clients_charts") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['clients_charts']); ?>        
                </li>
                <?php 
                    }
                    if($identificationCodeArray[4] != INACTIVE_USER && $identificationCodeArray[4] != BANNED_USER){
                ?>
                <li class="<?php if ($active_menu_item[0] == "platform_charts" && $active_menu_item[1] == "project_charts") { echo "active";} ?>" >
                    <?php Zf_GenerateLinks::zf_internal_link($side_menu['project_charts']); ?>        
                </li>
                <?php
                    }
                ?>
            </ul>
        </li>
        <!-- END CHARTS-->
        <?php
            if($identificationCodeArray[4] == PLATFORM_SUPER_ADMIN || $identificationCodeArray[4] == TOP_THIRD_ADMIN){
        ?>
        <!-- BEGIN DASHBOARD SETTINGS-->
        <li class="last <?php if (($active_menu_item[0] == "platform_settings")) { echo "active";} ?>">
            <?php Zf_GenerateLinks::zf_internal_link($side_menu['dashboard_settings']); ?>
        </li>
        <!-- BEGIN DASHBOARD SETTINGS-->
        <?php
            }
        ?>
        
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
<?php
}
?>

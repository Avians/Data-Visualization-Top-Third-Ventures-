<?php

//echo "<code>"; print_r($zf_externalWidgetData); echo "</code>"; exit(); //This is strictly for debugging purposes.
$userIdentificationArray = $zf_externalWidgetData;

$user_menu = array(
    
        //VIEW USER PROFILE
        "view_profile" => array(
            'name' => '<i class="icon-user"></i> My Profile',
            'controller' => 'platform_overview',
            'action' => 'view_profile',
            'parameter' => $userIdentificationArray[2], //Username e.g Athias
            'title' => '',
            'style' => '',
            'id' => ''
        ),
    
        //UPDATE USER PROFILE
        "update_profile" => array(
            'name' => '<i class="icon-edit"></i> Update Profile',
            'controller' => 'platform_overview',
            'action' => 'update_profile',
            'parameter' => $userIdentificationArray[2], //Username e.g Athias
            'title' => '',
            'style' => '',
            'id' => ''
        ),
    
        //MAIL INBOX
        "mail_inbox" => array(
            'name' => '<i class="icon-inbox"></i> Mail Inbox <span class="badge badge-important">3</span>',
            'controller' => 'platform_communication',
            'action' => 'emails',
            'parameter' => 'email_inbox',
            'title' => '',
            'style' => '',
            'id' => ''
        ),
    
        //USER TASKS
        "user_tasks" => array(
            'name' => '<i class="icon-tasks"></i> All My Tasks <span class="badge badge-success">8</span>',
            'controller' => 'platform_overview',
            'action' => 'user_tasks',
            'parameter' => $userIdentificationArray[2], //Username e.g Athias
            'title' => '',
            'style' => '',
            'id' => ''
        ),
    
        //LOCK USER
        "lock_user" => array(
            'name' => '<i class="icon-lock"></i> Lock Dashboard',
            'controller' => 'index',
            'action' => 'lock_user',
            'parameter' => $userIdentificationArray[2], //Username e.g Athias
            'title' => '',
            'style' => '',
            'id' => ''
        ),
    
        //LOGOUT
        "logout" => array(
            'name' => '<i class="icon-off"></i> Log Out',
            'controller' => 'index',
            'action' => 'logout',
            'parameter' => $userIdentificationArray[2], //Username e.g Athias
            'title' => '',
            'style' => '',
            'id' => ''
        ),
    
    
);
?>
<li class="dropdown user">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <img alt="" src="<?php echo ZF_ROOT_PATH . ZF_CLIENT . 'zf_app_global' . DS . 'app_global_files' . DS . 'app_global_images' . DS . 'app_users' . DS . 'small_images' . DS . 'avatar1.jpg'; ?>" />
        <span class="username"><?php echo $userIdentificationArray[2]; ?></span>
        <i class="icon-angle-down"></i>
    </a>
    <ul class="dropdown-menu">
        <li>
            <?php Zf_GenerateLinks::zf_internal_link($user_menu['view_profile']); ?>
        </li>
        <li>
            <?php Zf_GenerateLinks::zf_internal_link($user_menu['update_profile']); ?>
        </li>
        <li>
            <?php Zf_GenerateLinks::zf_internal_link($user_menu['mail_inbox']); ?>
        </li>
        <li>
            <?php Zf_GenerateLinks::zf_internal_link($user_menu['user_tasks']); ?>
        </li>
        <li class="divider"></li>
        <li>
            <?php Zf_GenerateLinks::zf_internal_link($user_menu['lock_user']); ?>
        </li>
        <li>
            <?php Zf_GenerateLinks::zf_internal_link($user_menu['logout']); ?>
        </li>
    </ul>
</li>
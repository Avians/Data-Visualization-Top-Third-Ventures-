<?php

if($zf_externalWidgetData == PLATFORM_SUPER_ADMIN || $zf_externalWidgetData == TOP_THIRD_ADMIN){
    //Loads the overview_statistics_model methods

    $realAccounts  = $zf_model_data->ClientInformation('real_accounts');
    $trialAccounts = $zf_model_data->ClientInformation('trial_accounts');
    $allMails = $zf_model_data->MailingList();
    $allDataRecords = $zf_model_data->DataRecords();
?>

<!-- BEGIN DASHBOARD STATS -->
<div class="row-fluid">
    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="icon-group"></i>
            </div>
            <div class="details">
                <div class="number"><?php echo $realAccounts; ?></div>
                <div class="desc">Real Clients</div>
            </div>
            <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
        </div>
    </div>
    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
        <div class="dashboard-stat green">
            <div class="visual">
                <span><i class="icon-group"></i></span>
            </div>
            <div class="details">
                <div class="number"><?php echo $trialAccounts; ?></div>
                <div class="desc">Trial Clients</div>
            </div>
            <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
        </div>
    </div>
    <div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
        <div class="dashboard-stat yellow">
            <div class="visual">
                <i class="icon-envelope"></i>
            </div>
            <div class="details">
                <div class="number"><?php echo $allMails; ?></div>
                <div class="desc">Mailing List Subscription</div>
            </div>
            <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
        </div>
    </div>
    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
        <div class="dashboard-stat purple">
            <div class="visual">
                <i class="icon-cloud"></i>
            </div>
            <div class="details">
                <div class="number"><?php echo $allDataRecords; ?></div>
                <div class="desc">Total Data Sets Tracked</div>
            </div>
            <a class="more" href="#">
                More Details <i class="m-icon-swapright m-icon-white"></i>
            </a>                 
        </div>
    </div>
</div>
<!-- END DASHBOARD STATS -->
<?php
    }
?>
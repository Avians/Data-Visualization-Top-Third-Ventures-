<?php
    //Recieve data for all households
    $houseHolds  = $zf_model_data->HouseHolds($zf_externalWidgetData);
    
    //Recieve data for all children
    $allChildren  = $zf_model_data->AllChildren($zf_externalWidgetData);
    
    //Recieve data for children under five years
    $childrenUnderFive  = $zf_model_data->ChildrenUnderFive($zf_externalWidgetData);
    
    //Recieve data for all project benefactors
    $allBenefactors  = $zf_model_data->AllBenefactors($zf_externalWidgetData);
    
?>
<!--This is the data for all house holds-->
<div class="span12 responsive" data-tablet="span12" data-desktop="span12">
    <div class="dashboard-stat blue">
        <div class="details">
            <div class="number"><?php echo $houseHolds; ?></div>
            <div class="desc">Total of Households</div>
        </div>
        <a class="more" href="#">View more <i class="m-icon-swapright m-icon-white"></i></a>                 
    </div>
</div>

<!--This is the data for all children-->
<div class="span12 responsive" data-tablet="span12" data-desktop="span12">
    <div class="dashboard-stat green">
        <div class="details">
            <div class="number"><?php echo $allChildren; ?></div>
            <div class="desc">Total of Children</div>
        </div>
        <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
    </div>
</div>

<!--This is the data for all children under 5 years-->
<div class="span12 responsive" data-tablet="span12" data-desktop="span12">
    <div class="dashboard-stat red">
        <div class="details">
            <div class="number"><?php echo $childrenUnderFive; ?></div>
            <div class="desc">Children below 5 years</div>
        </div>
        <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
    </div>
</div>

<!--This is the data for all project benefactors-->
<div class="span12 responsive" data-tablet="span12" data-desktop="span12">
    <div class="dashboard-stat purple">
        <div class="details">
            <div class="number"><?php echo $allBenefactors; ?></div>
            <div class="desc">Total Project Benefactors</div>
        </div>
        <a class="more" href="#">More Details <i class="m-icon-swapright m-icon-white"></i></a>                 
    </div>
</div>

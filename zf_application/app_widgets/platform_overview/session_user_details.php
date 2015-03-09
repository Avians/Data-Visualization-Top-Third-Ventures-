<?php

    //Load the model that has user information.

    $companyInfo = array("companyName", "accountType");

    foreach ($companyInfo as $value) {

        if($value == "companyName"){
           $companyName  =  $zf_model_data->ActiveCompanyInformation($value);
        }
        if($value == "accountType"){
           $accountType  =  $zf_model_data->ActiveCompanyInformation($value);
        }

    }

?>
<h3 class="page-title">   
    Dashboard Overview - <?php echo "<small>".$companyName ." Limited</small> | <small>" . $accountType . " Account</small> ";?>
</h3>

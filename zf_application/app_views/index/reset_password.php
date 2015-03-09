
<!-- BEGIN LOGIN -->
<div class="content">
    <div class="container-fluid">
        <?php
            $zf_widgetFolder = "indicators"; $zf_widgetFile = "sign_up_indicator.php";
            Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile);
        ?>
    </div>
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <?php
        $zf_widgetFolder = "forms"; $zf_widgetFile = "reset_password.php";
        Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile);
    ?>
    <!-- END FORGOT PASSWORD FORM -->
    
</div>
<!-- END LOGIN -->

<script typr="text/javascript">
$(document).ready(function() {
    
    //Here we are generating the applications absolute path.
    var $absolute_path = "<?php echo APPLICATION_FOLDER; ?>";
    
    Login.init($pageselector = "reset_password", $absolute_path );
    
});
</script>
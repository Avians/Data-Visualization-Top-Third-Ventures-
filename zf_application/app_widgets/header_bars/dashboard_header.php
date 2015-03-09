<!-- BEGIN HEADER -->   
<?php
    //echo "<code>"; print_r($zf_externalWidgetData); echo "</code>"; exit(); //This is strictly for debugging purposes.

    $zf_widgetFolder = "header_bars"; $zf_widgetFile = "main_header.php";
    Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile, $zf_externalWidgetData);
?>
<!-- END HEADER -->

<!-- BEGIN CONTAINER -->
<div class="page-container">

    <!-- BEGIN SIDEBAR -->
    <?php
        $zf_widgetFolder = "side_bar"; $zf_widgetFile = "side_bar.php";
        Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile, $zf_externalWidgetData);
    ?>
    <!-- END SIDEBAR -->

        <?php
            
        
            if(empty($activeURL[0]) || 
                    ($activeURL[0] == "index" && empty($activeURL[1])) || 
                    ($activeURL[0] == "index" && $activeURL[1] == "login" || $activeURL[0] == "index" && $activeURL[1] == "reset_password" ||$activeURL[0] == "index" && $activeURL[1] == "sign_up" )){

                //BEGIN LOGIN HEADER
                $zf_widgetFolder = "lock_screens"; $zf_widgetFile = "login_footer.php";
                Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile);
                //END LOGIN HEADER

            }else{
                //BEGIN DASHBOARD HEADER
                $zf_widgetFolder = "footer_bars"; $zf_widgetFile = "dashboard_footer.php";
                Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile);
                //END DASHBOARD HEADER
            }
        
        ?>

    </body>
    
</html>

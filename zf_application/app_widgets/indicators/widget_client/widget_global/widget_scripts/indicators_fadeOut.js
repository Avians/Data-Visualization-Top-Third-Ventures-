<script type="text/javascript" >

    $(document).ready(function() {

        $('.info-fadeout,.error-fadeout').show('fast', function(){
            
            $(this).fadeOut(10000, function(){
                
                $('body').scrollTo('#footer_section');
                
            });
            
        });
        
        $('.success-fadeout').show('fast', function(){
            
            $(this).fadeOut(20000);
            
        });

    });

</script>



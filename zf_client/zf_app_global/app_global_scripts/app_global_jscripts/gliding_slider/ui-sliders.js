var UISliders = function () {

    return {
        //main function to initiate the module
        initSliders: function () {

            // range slider
            $("#slider-range").slider({
                range: true, min: 0, max: 100, values: [0, 100],
                slide:function (event, ui) {
                    var value = ui.values[0] + "yrs - " + ui.values[1] + "yrs";
                    
                    $.post("http://localhost/topthird_dashboard/zf_template/test",{'age_bracket':ui.values},function(response){
                       //alert ( ui.values[0] ); 
                    });
                    $("#slider-range-amount").html( value );
                }
                
            });

            $("#slider-range-amount").html( $("#slider-range").slider("values", 0) + " Yrs - " + $("#slider-range").slider("values", 1) + "Yrs");



            // vertical range sliders
            $("#slider-range-vertical").slider({
                orientation: "vertical",
                range: true,
                values: [17, 67],
                slide: function (event, ui) {
                    $("#slider-range-vertical-amount").text("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });

            $("#slider-range-vertical-amount").text("$" + $("#slider-range-vertical").slider("values", 0) + " - $" + $("#slider-range-vertical").slider("values", 1));

        }

    };

}();
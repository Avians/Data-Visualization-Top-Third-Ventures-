/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

    $("#someID").ionRangeSlider({
        min: 0,
        max: 100,
        from: 10,
        to: 80,
        type: 'double',
        step: 1,
        postfix: "yrs",
        prettify: true,
        hasGrid: false
    });

});



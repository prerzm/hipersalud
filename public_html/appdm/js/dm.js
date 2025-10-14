
function bmi(weight, height) {
    var hm = parseFloat(parseInt(height)/100);
    var bmi = parseFloat(parseFloat(weight)/(hm*hm)).toFixed(2)
    $("#icon_imc_under").hide();
    $("#icon_imc_ok").hide();
    $("#icon_imc_over").hide();
    if(bmi<18.5) {
        $("#div_imc").css('color', '#c09853');
        $("#icon_imc_under").show();
    } else if(bmi>25) {
        $("#div_imc").css('color', '#b94a48');
        $("#icon_imc_over").show();
    } else {
        $("#div_imc").css('color', '#468847');
        $("#icon_imc_ok").show();
    }
    $("#calc_imc").html(bmi);
}
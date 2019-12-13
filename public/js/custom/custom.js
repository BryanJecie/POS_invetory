// console.log(BASE_URL)


$(".numbers").focusout(function(){
    format_numbers(this);
    // IsFloatOnly(this);
});
 
function format_numbers(obj) {

    var x = $(obj).val().trim();

    if( x.length > 0 ){
        var numbers = /^[0-9]+([,.][0-9]+)?$/;
        var _value;
        _value = x.replace(/,/g,'');
        if( _value.match(numbers) ){
            _value = parseFloat(_value).toFixed(2);
            _value = numberWithCommas(_value);
            $(obj).val(_value);
            return;
        }
    }
    $(obj).val('');
}

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}


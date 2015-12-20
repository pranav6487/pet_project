function loginFrm() {
    if( $("#loginEmail").val() == "" ) {
        alert("Please enter Email");
        $("#loginEmail").focus();
        return false;
    }
    
    if( $("#loginPswd").val() == "" ) {
        alert("Please enter Password");
        $("#loginPswd").focus();
        return false;
    }
    
    var ajaxUrl = window.location.pathname;
    var params = "aj=1&action=login";
    params += "&"+$("#loginFrm").serialize();
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done(function(resp){
        console.debug(resp);
    });
    return false;
}
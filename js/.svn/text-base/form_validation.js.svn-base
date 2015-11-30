
/****************** optimiseJS ***************************/

//====String Prototype===
String.prototype.trim  = function ()
{
    return this.replace(/^\s+/,'').replace(/\s+$/,'');
};
String.prototype.isEmpty = function ()
{
    return ( 0 == this.replace(/^\s+/,'').replace(/\s+$/,'').length );
};
String.prototype.isAlphaNumeric = function (){
    return ALLOWED_ALPHANUM.test(this);
};
String.prototype.isEmail = function()
{
    return ALLOWED_EMAIL.test(this);
};
String.prototype.isNum = function()
{
    return !isNaN(this);
};
String.prototype.isWebURL = function (){
    return ALLOWED_URL.test(this);
};
String.prototype.isName = function (){
    return ALLOWED_ALPHABETIC.test(this);
};
String.prototype.isUserName = function (){
    return ALLOWED_USER_NAMES.test(this);
};
String.prototype.isFeedName = function (){
  return ACCOUNT_NAME_PATTERN.test(this);
};
String.prototype.isFeedName = function (){
  return ACCOUNT_NAME_PATTERN.test(this);
};
String.prototype.isNumericUnsigned = function (){
  return ALLOWED_NUMERIC_UNSIGNED.test(this);
};
String.prototype.isText = function (){
  return ALLOWED_FEED_DETAILS.test(this);
};
String.prototype.isDecimal = function (){
  return ALLOWED_DECIMAL_WITHOUT_HYPHEN.test(this);
};
String.prototype.escapeHTML =  function()
{
    var div = document.createElement('div');
    var text = document.createTextNode(this);
    div.appendChild(text);
    var ret = div.innerHTML;
    delete div;
    return ret;
};
String.prototype.isPhone = function()
{
	return ALLOWED_NUMERIC_UNSIGNED.test(this);
};


/***************************** New Validation Functions ***************************/
/**
This function can work for EMPTY , NUMBER , and E-Mail Validation.

    How it works

    0) Form Object
            Form : To validate form Entries and make post_data string
        Methods:
            Form.is_valid(form, [object option], [bool retAsObj]);

    If retAsObj is true then it return object
        return {
            'is_valid':boolean,
            'post_data':String
               };
    Else if retAsObj is false it return boolean ( true for no error )
    Default value of  retAsObj is false.

    a)form - form object(this)

        b)
        option is passed as object
            var option =
            {
                accept:'name1,name2,...',
                reject:'name1,name2,...',
                additional:'ajax=1&para1=val1...',
                err_msg:'My Custome Error Message',
                timestame:boolean
                css_class:errrBorder
                    }

        All keys of option is Optional
        if accept and reject both provided , Only accept will work

        accept  : This will take comma saperated control names
              The function will only validated the controls which are present in the accept list
              default value is " null " ie if validation is required on all controls of form then passed it as null(or do not define it)

        reject  : This will take comma saperated control names
              The function will not validated the controls which are present in the reject list
              default value is " null " ie if validation is required on all controls of form then passed it as null(or do not define it)

        NOTE :- If both accept and reject is defined then function will take only accept list.

        additional :If extra parameter is required in post data like ajax=yes then passed in this
                default value is null
        err_msg : used to show the custom message if required
              default value is 'Fill all required fields'
        timestamp : If timestamp is true then one parameter __timestamp__ = date() will be added to Post data string.
                default value is false
        css_class : used to give colour to controls having error
            default value is errorBorder


    1) Put all elements in Form tag

    2) Add attribute "validate" or "validatenull" on every control which requires the validation .

    3) If you want to check for combination of null value and specific validation(like NUMBER , E-MAIL) then use attribute validatenull else use validate

    3) Set value of "attribute" , the kind of validation required ,
       Attribute's values are not case-sensitive (email OR EMAIL or EmAiL),
       While attribute names are case-sensitive (validate NOT Validate).

        For E-MAIL
            <input type="text" value="" maxlength="255" size="30" name="email" validate="EMAIL" />
        For E-MAIL + NULL(Empty)
            <input type="text" value="" maxlength="255" size="30" name="email" validatenull="EMAIL" />
                * this means it can be null or incorrect email address
        For Number
            <input type="text" value="asdfasd" maxlength="255" size="30" name="email" validate="NUMBER" />
        For Number + NULL(Empty)
            <input type="text" value="asdfasd" maxlength="255" size="30" name="email" validatenull="NUMBER" />

    4) onsubmit function of form call Form function
        <form onsubmit="javascript:return Form.is_valid(this);" >
        OR
        <form onsubmit="javascript: return Form.is_valid(this , option); " >
        OR
        <form onsubmit="javascript:return Form.is_valid(this , {accept:'name1,name2'});" >

*/
//==Form VALIDATION FUNCTINOS STARTS==
var Form = {_post_data_str:''};
Form.is_valid = function(frm,option,retobj)
{	
    option = option || {};
    retobj = retobj || false;
    //Set Default values for options 
    var accept = option['accept'] || null;
    var reject = option['reject'] || null;
    var additional = option['additional'] || null;
    var err_msg = option['err_msg'] || 'Fill all required fields';
    var css_class = option['css_class'] || 'errorBorder';
    var alert_err = (option['alert_err']=='undefined')?  true:option['alert_err'];
    var error_handle_each = option['error_handle_each'] || false;
    var error_handle_all = option['error_handle_all'] || false;

    //validate request 
    if(error_handle_each){
        if( 'function' != typeof(error_handle_each)){
            alert(' Invalid callback `'+option['error_handle_each']+'` given as error handler '); 
            error_handle_each = false;
        }
    }
    if(error_handle_all){
        if( 'function' != typeof(error_handle_all)){
            alert(' Invalid callback `'+option['error_handle_all']+'` given as error handler ');
            error_handle_each = false;
        }
    }
    if( 'undefined' == frm['elements'] ){
        alert('First argument must be valid form object');
        return false;
    }
    //Array of all error controll
    var arr_err_objs = Array();
    
    Form._post_data_str ='';

    var sret = '',ele,first_err_ele,i;
    var valtp='', cannull=false, err_flag=false;

    if(reject){
        reject = Form._array2obj(reject.split(','));
    }
    if(accept){
        accept = Form._array2obj(accept.split(','));
    }

    //var eles = frm.elements || {};
    var eles = $("#"+frm+" :input");
    

    var elen = eles.length; 
    for(i=0; i<elen; i++){
        ele = eles[i];
        
        if($(ele).attr("disabled")){
            continue;
        }
        
        if('none' == $(ele).css("display")){
            continue;
        }
        
        var ename = $(ele).attr("name");
        if('' == ename){
            continue;
        }

        if(accept){
            if(!(ename in accept)){
                continue;
            }
        }else if(reject){
            if(ename in reject){
                continue;
            }
        }

        var tagtp = $(ele).attr("tagName") || 'fieldset';
        if( 'fieldset' == tagtp.toLowerCase() ){
            continue; //ignoring fieldset
        }
        
        cannull = false;
        valtp = '';
        validate = '';
        if(validate = $(ele).attr("validatenull")){
        	validate_arr = validate.split(":");
            cannull = true;
        }else if(validate = $(ele).attr("validate")){
		validate_arr = validate.split(":");
            cannull = false;
        }

        alias = $(ele).attr("title");
        if(validate){

        for(x in validate_arr){
	  valtp = validate_arr[x]; 
        	switch (valtp){
        	
        	case "EMPTY":
        		err_msg = "Please enter value for "+alias;
        		break;
        	
        	default:
        		err_msg = "Invalid value for "+alias;
    			break;
        	}

        	var evalue = '';

	        switch ($(ele).attr("type").toLowerCase()){
	            // Text fields, hidden form elements
	            case 'select':
	            case 'select-one':
	                if(valtp){ valtp='EMPTY'};
	                sret += ename + '=' + encodeURIComponent($(ele).val()) + '&';
	                evalue = $(ele).val();
	                //ele = Form._add_wraper(ele, ename + i);
	                break;
	            case 'text':
	            case 'textarea':
	                if(!($(ele).attr("readonly"))){
	                    ele.value = $(ele).val().trim();
	                }
	            case 'file':
	            case 'hidden':
	            case 'password':
	                sret += ename + '=' + encodeURIComponent($(ele).val()) + '&';
	                evalue = $(ele).val();
	                break;
	            // Multi-option select
	            case 'select-multiple':
	                if(valtp){ valtp='EMPTY'};
	                for(var j = 0; j < ele.options.length; j++){
	                    var currOpt = ele.options[j];
	                    if(currOpt.selected){
	                        sret += ename + '=' + encodeURIComponent(currOpt.value) + '&';
	                        evalue = ele.value;
	                    }
	                }
	                //ele = Form._add_wraper(ele, ename + i);
	                break;
	
	            case 'radio':
	                var rdos = eles[ename];
	                
	                if(undefined == rdos['length'])
	                {
	                    rdos = Array( ele );
	                }
	
	                var len = rdos['length'] || 0;
	                evalue = '';
	                for( var ri=0; ri<len; ri++){
	                    if( rdos[ri].checked ){
	                        evalue= rdos[ri].value;
	                        break;
	                    }
	                }
	                break;
	            case 'checkbox':
	                if(ele.checked)
			{
	                    sret += ename + '=' + encodeURIComponent($(ele).val()) + '&';
	                    evalue = $(ele).val();
	                }
	                //ele = Form._add_wraper(ele, ename + i);
	                break;
	            default:
	                evalue='';
	                continue;   
	        }
	        //validate
	        if(valtp){
	            if(!Form._validate_ele(evalue, valtp, cannull)){
	                if(error_handle_each){
	                    //calling callback with (current) ele having error 
	                    err_msg = error_handle_each(ele, err_msg );
	                }
	                if(error_handle_all){
	                    //used in calling callback error_handle_all()
	                    arr_err_objs.push(ele); 
	                }
	               
	                err_flag = true;
	                
	                if(err_flag){
	                	//message_hide_show(1,err_msg);
	                	$(ele).focus();
	                	$(ele).css("border","1px solid red");
	                	//display_message(err_msg, 0);
	                	alert(err_msg);
	                	return false;
	                }
	                if(!first_err_ele){
	                    first_err_ele = eles[i];
	                }
	            }
	        }
        }

	}

    }

    if(option['timestamp']){
        sret += '__timestamp__=' +encodeURIComponent(Date())+'&';
    }
   
    if(err_flag){
        //first_err_ele.focus();
        if(error_handle_all){
           //calling callback with array of ele's have error  
            err_msg = error_handle_all( arr_err_objs, err_msg );
        }
	
       if(alert_err){
		
            alert(err_msg);
        }else{
            //message_hide_show(1,err_msg);//show err div
            //display_message(err_msg, 1);
        	alert(err_msg);
        }
	
    }else{
        if(additional){
            var tp = (typeof(additional)).toLowerCase();
            if('string' == tp){
                sret += additional + '&';
            }else if('object' == tp){
                for(var k in additional){
                    if('function' != (typeof(additional[k])).toLowerCase()){
                        sret += k + '=' + additional[k] + '&';
                    }
                }
            }
        }
        // Remove trailing separator
        sret = sret.substr(0, sret.length - 1);
    }
    
    ele = null;
    eles = null;
    error_handle_each = null;
    error_handle_all = null;
    delete arr_err_objs;
    
    Form._post_data_str = sret;
    if( retobj ){
        return {'is_valid':!err_flag, 'post_data':Form._post_data_str};
    }else{
        return !err_flag;
    }
}
/*
    Private function
    form validateion support function
    str = value to be validate(value of control)
    valtp = validation type {EMPTY | NUMBER | EMAIL}
    cannull = boolean (passed for checking the contoll with null )
        this parameteris optional, and default value is false
*/
Form._validate_ele = function (str, valtp, cannull)
{
    cannull = cannull || false;
    
    if(cannull){
        if(0 >=str.length){
        	return true;
        }
    }
    
    switch(valtp.toUpperCase()){
        case "EMPTY":
            return (0 < str.length);
            break;
        case "NUMBER":
            return ('' == str) ? false : !isNaN(str);
            break;
		case "PHONE":
            return ('' == str) ? false : str.isPhone(str);
            break;
        case "EMAIL":
            return str.isEmail();
            break;
		case "ALPHANUM":
			return ('' == str) ? false:str.isAlphaNumeric();
			break;
		case "WEBURL":
			return ('' == str) ? false:str.isWebURL();
			break;
		case "NAME":
			return ('' == str) ? false:str.isName();
			break;
		case "USERNAME":
			return ('' == str) ? false:str.isUserName();
			break;
		case "POSINT":
		  return ('' == str) ? false:str.isNumericUnsigned();
		  break;	
		case "FEEDNAME":
		  return ('' == str) ? false:str.isFeedName();
		  break;
		case "LONGTEXT":
		  return ('' == str) ? false:str.isText();
		  break;
		case "DECIMAL":
		  return ('' == str) ? false:str.isDecimal();
		  break;
        default:
            alert("Validation '" + valtp + "' not defined in lib.");
            break;
    }

    return false;
}
/*
    Private function
    it converts array in to object and returns
    make object  from arary, flaping index and value
*/
Form._array2obj = function(arr){
    var oret = null;
    var len = arr.length;
    if(len){
        oret = {};
        for(var i=0; i<len; i++){
            oret[arr[i]]=i;
        }
    }
    return oret;
}
//  Input
//  1) takes object(this) of the control
//  2) div id
//  it creates a div with given div ID and  puts the element in that div and replaces the control with the new div
//  it can be used in future if required
// Form._add_wraper = function (ele, divid)
// {
//     //Private function
//     //adding container
//     var odiv;
//     if(odiv = document.getElementById(divid))
//     {
//         //return odiv;
//     }else{
//         odiv = document.createElement('div');
//         odiv.id = divid;
//         odiv['style']['display'] = 'inline';
//         var par = ele.parentNode || parent;
//         par.insertBefore(odiv,ele);
//         par.removeChild(ele);
//         odiv.appendChild(ele);
//         par = null;
//     }
//     return odiv;
// }
//
//FORM VALIDATION FUNCTINOS END

/****************** optimiseJS END ***************************/


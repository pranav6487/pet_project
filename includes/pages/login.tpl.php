<?php
global $global_params;
global $page_params;
$pageArgs = $global_params['page_arguments'];

if( !empty($pageArgs['action']) && $pageArgs['action'] == "forgotPasswd" && !empty($pageArgs['id']) ) {
?>
<section id="left-column">
    <section class="sale" id="resetPasswd">
        <h1>Reset Password</h1>
        <form id="resetFrm" onsubmit="return resetFrm();" method="POST" action="">
        <ul id="resetPassdUl">
            <li class="center" id="errMsgLi" style="display:none;color:red;">
                
            </li>
            <li class="center">
                <input type="hidden" id="userId" name="userId" value="<?php echo $pageArgs['id']; ?>" />
                New Password: <input type="password" id="newPasswd" name="newPasswd" value="" placeholder="Password"/> 
            </li>
            <li class="center">
                Confirm Password: <input type="password" id="confPasswd" name="confPasswd" value="" placeholder="Confirm Password"/>
            </li>
            <li class="center">
                <input type="submit" id="sbmtReset" name="sbmtReset" value="Reset"/>
                <input type="reset" id="clrReset" name="clrReset" value="Clear"/>
            </li>
            <li>
                <a href="/login.html">Login</a>
            </li>
        </ul>
        </form>
    </section>
</section>
<?php
}
else {
?>
<section id="left-column">
    <section class="sale" id="loginBox">
        <h1>Login</h1>
        <form id="loginFrm" onsubmit="return loginFrm();" method="POST" action="">
        <ul>
            <li class="center" id="errMsgLi" style="display:none;color:red;">
                
            </li>
            <li>
                <input class="inpTxtBox" size="30" type="text" id="loginEmail" name="loginEmail" value="" placeholder="Email"/>
            </li>
            <li>
                <input class="inpTxtBox" size="30" type="password" id="loginPswd" name="loginPswd" value="" placeholder="Password"/>
            </li>
            <li class="center">
                <input type="submit" id="sbmtLogin" name="sbmtLogin" value="Login" />&nbsp;
                <input type="reset" id="resetFrm" name="resetFrm" value="Reset" />
            </li>
            <li class="center">
                <a href="javascript:void(0);" onclick="forgotPasswd();">Forgot Password</a>
            </li>
        </ul>
        </form>
    </section>
</section>
<?php
}
?>
<?php

?>
<section id="left-column">
    <section class="sale" id="loginBox">
        <h1>Login</h1>
        <form id="loginFrm" onsubmit="return loginFrm();" method="POST" action="">
        <ul>
            <li>
                Email: <input type="text" id="loginEmail" name="loginEmail" value="" placeholder="Email"/>
            </li>
            <li>
                Password: <input type="password" id="loginPswd" name="loginPswd" value="" placeholder="Password"/>
            </li>
            <li>
                <input type="submit" id="sbmtLogin" name="sbmtLogin" value="Login" />&nbsp;
                <input type="reset" id="resetFrm" name="resetFrm" value="Reset" />
            </li>
            <li>
                <a href="javascript:void(0);">Forgot Password</a>
            </li>
        </ul>
        </form>
    </section>
</section>
<?php
global $global_params;
global $page_params;

?>
<section id="left-column">
    <section class="sale" id="contFrm">
        <h1>Mail your query</h1>
        <ul>
            <li id="errMsgLi" style="display:none;color:red;"></li>
            <li>
                <input type="text" id="querySub" name="querySub" value="" placeholder="Subject" class="inpTxtBox" size=30 />
            </li>
            <li>
                <br /><textarea id="queryMsg" name="queryMsg" rows="10" cols="38" placeholder="Message"></textarea>
            </li>
            <li id="sbmtLi" class="center">
                <input type="button" id="sbmtQuery" name="sbmtQuery" value="Submit"/>
                &nbsp;
                <input type="button" id="reset" name="reset" value="Reset"/>
            </li>
            <li id="plsWaitLi" style="display:none;">
                Please wait ...
            </li>
        </ul>
    </section>
</section>
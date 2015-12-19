<?php
?>
<style>
   .inpError{border:1px solid red;}
</style>

<script type="text/javascript" src="<?php echo JS_URL.PAGE_JS_MANAGEREST;?>"></script>

<section id="left-column">
    <form id="add_restaurant" onsubmit="return addRestaurant();" method="POST" action="">
        <section class="sale" id="addRestDtls">
            <h1>Add Restaurant Details</h1>
            <ul>
                <li>
                    Restaurant name*:
                    <input class="required" id="restName" name="restName" value="" type="text"  />
                </li>
                <li>
                    Restaurant Type*:
                    <input class="required" id="restType" name="restType" value="" type="text" />
                </li>
                <li>
                    Restaurant Timings*:(10:00-16:00,19:00-23:00)
                    <input class="required" id="restTime" name="restTime" value="" type="text" />
                </li>
                <li>
                    Locality*:
                    <input class="required" id="restLoc" name="restLoc" value="" type="text" />
                </li>
                <li>
                    Address line 1*:
                    <input class="required" id="restAdd1" name="restAdd1" value="" type="text" />
                </li>
                <li>
                    Address line 2:
                    <input id="restAdd2" name="restAdd2" value="" type="text" />
                </li>
                <li>
                    Company email*:
                    <input class="required email" id="restCoEmail" name="restCoEmail" value="" type="text" />
                </li>
                <li>
                    Manager Name*:
                    <input class="required" id="restManagerName" name="restManagerName" value="" type="text"/>
                </li>
                <li>
                    Manager number*:
                    <input class="required numeric" id="restManagerNum" name="restManagerNum" value="" maxlength="10" type="text" />
                </li>
                <li>
                    Contact Name 1*:
                    <input class="required" id="restContactName1" name="restContactName1" value="" type="text"/>
                </li>
                <li>
                    Contact Num 1*:
                    <input class="required numeric" id="restContactNum1" name="restContactNum1" value="" maxlength="10" type="text" />
                </li>
                <li>
                    Contact Name 2:
                    <input id="restContactName2" name="restContactName2" value="" maxlength="10" type="text"/>
                </li>
                <li>
                    Contact Num 2:
                    <input class="numeric" id="restContactNum2" name="restContactNum2" value="" maxlength="10" type="text"/>
                </li>
                <li>
                    Login email*:
                    <input class="required email" id="login_email" name="login_email" value="" type="text"/>
                </li>
                <li>
                    Login password*:
                    <input class="required" id="login_pwd" name="login_pwd" value="" type="password" />
                </li>
                <li>
                    <input type="submit" id="submit_rest" name="submit_rest" value="Add Restaurant"/>&nbsp;
                    <input type="reset" id="reset_rest" name="reset_rest" value="Reset" />
                </li>
            </ul>
        </section>
        <section class="sale" id="restDtls" style="display:none;">
            <h1>Restaurant Details</h1>
            <ul>
                <li>
                    Restaurant name: <span id="dispRestName"></span>
                </li>
            </ul>
        </section>
        </form>
        <section class="sale" id="addTableDtls" style="display:none;">
            <h1>Add Table Details</h1>
            <ul>
                <li>
                    No of tables: <input class="numeric" id="noOfTables" size="1" name="noOfTables" value="" type="text"/>&nbsp; <input type="button" id="addNoOfTables" name="addNoOfTables" value="Add" />
                </li>
            </ul>
            <form id="tableDtlsFrm" method="POST" action="" onsubmit="return addTableDtls();" >
            <input type="hidden" id="restId" name="restId" value="" />
            <ul id="tableDtlsList">
                
            </ul>
            </form>
        </section>
    <section class="sale" id="partyRestRel" style="display:none;">
        <h1>Party Characteristics</h1>
        <select id="multipleTableOpts" style="display:none;">
                    
        </select>
        <form method="post" action="" id="partyRestRelFrm" onsubmit="return addPartyRestRel();">
        <ul id="partyRestRelList">
            <li id="partyRel_1">
                <input type="text" size="1" placeholder="No of People" class="numeric" id="noOfPeople_1" name="noOfPeople[]" value=""/>
                <input type="text" size="1" placeholder="Avg Time" class="numeric" id="avgTime_1" name="avgTime[]" value=""/>
                <input type="text" size="1" placeholder="Buffer" class="numeric" id="bufferTime_1" name="bufferTime[]" value="" />
                <select multiple="multiple" id="eligibleTablOpts_1" name="eligibleTableOpts_1[]" style="display:none;">
                    
                </select>
                <input type="button" id="removePartyRel_1" class="removePartyRel" value="Remove"/>
            </li>
        </ul>
            <input type="submit" value="Add Details" id="submitPartyRel"/>
        </form>
        <input type="button" id="addMoreParty" value="Add More" />
    </section>
</section>
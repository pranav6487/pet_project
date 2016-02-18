<?php
?>
<style>
   .inpError{border:1px solid red;}
</style>
<script type="text/javascript" src="<?php echo JS_URL.PAGE_JS_MANAGEREST;?>"></script>

<?php
if( $_SESSION[SESSION_USER_TYPE] == $users::SUPER_USER ) {
?>
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
<?php }
else {
?>
<section id="left-column">
    <section class="sale">
        <h1>Restaurant Details</h1>
        <ul class="hotel">
            <li>
                <label>Name</label>
                <strong>:</strong> <?php echo $restDtls['name']; ?>
            </li>
            <li>
                <label>Type</label>
                <strong>:</strong> <?php echo $restDtls['restType']; ?>
            </li>
            <li>
                <label>Timing</label>
                <strong>:</strong> <?php echo $restDtls['restTimings']; ?>
            </li>
            <li>
                <label>Location</label>
                <strong>:</strong> <?php echo $restDtls['location']; ?>
            </li>
            <li>
                <label>Address Line 1</label>
                <strong>:</strong> <?php echo $restDtls['address1']; ?>
            </li>
            <li>
                <label>Address Line 2</label>
                <strong>:</strong> <?php echo $restDtls['address2']; ?>
            </li>
            <li>
                <label>Email</label>
                <strong>:</strong> <?php echo $restDtls['restEmail']; ?>
            </li>
            <li>
                <label>Manager Name</label>
                <strong>:</strong> <?php echo $restDtls['restManagerName']; ?>
            </li>
            <li>
                <label>Manager Number</label>
                <strong>:</strong> <?php echo $restDtls['restManagerNum']; ?>
            </li>
            <li>
                <label>POC1 Name</label>
                <strong>:</strong> <?php echo $restDtls['restContact1Name']; ?>
            </li>
            <li>
                <label>POC1 Number</label>
                <strong>:</strong> <?php echo $restDtls['restContact1Num']; ?>
            </li>
            <li>
                <label>POC2 Name</label>
                <strong>:</strong> <?php echo $restDtls['restContact2Name']; ?>
            </li>
            <li>
                <label>POC2 Number</label>
                <strong>:</strong> <?php echo $restDtls['restContact2Num']; ?>
            </li>
        </ul>
    </section>
    <section class="sale">
        <h1>Table Details</h1>
        <table cellspacing="10">
            <tr>
                <th style="width:22%">Table no</th>
                <th style="width:39%">Min Occupancy</th>
                <th style="width:39%">Max Occupancy</th>
            </tr>
                <?php
                foreach( $restDtls['tableDtls'] as $tableId => $tableDtls ) {
                    echo "<tr><td>".$tableDtls['tableNo']."</td><td>".$tableDtls['tableMinOcc']."</td><td>".$tableDtls['tableMaxOcc']."</td></tr>";
                }
                ?>
        </table>
    </section>
    <section class="sale">
        <h1>Party Relation Details</h1>
        <table cellspacing="10">
            <tr>
                <th style="width:10%">No of People</th>
                <th style="width:30%">Eligible Tables</th>
                <th style="width:20%">Average Time</th>
                <th style="width:20%">Buffer Time</th>
                <th style="width:20%">Next Available At</th>
            </tr>
            <?php 
            $partyRelHtml = "";
            foreach( $restDtls['partyRel'] as $partyRelId => $partyRelDtls ) {
                $partyRelHtml .="<tr>";
                $partyRelHtml .= "<td style='width:10%'>".$partyRelDtls['noOfPeople']."</td>";
                $partyRelHtml .= "<td style='width:30%'>".preg_replace("/,/",", ",$partyRelDtls['eligibleTableNos'])."</td>";
                $partyRelHtml .= "<td style='width:20%'>".$partyRelDtls['avgTime']."</td>";
                $partyRelHtml .= "<td style='width:20%'>".$partyRelDtls['bufferTime']."</td>";
                
                if( $partyRelDtls['nextAvailAt'] == 0 ) {
                    $partyRelHtml .= "<td style='width:20%'>Now</td>";
                }
                else {
                $partyRelHtml .= "<td style='width:20%'>".date("d-m-y h:i A",$partyRelDtls['nextAvailAt'])."</td>";   
                }
                $partyRelHtml .="</tr>";
            }
            echo $partyRelHtml;
            ?>
        </table>
    </section>
</section>
<?php
}
?>
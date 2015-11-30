<?php
//Generate enrypted value of the given text value
global $global_params;
global $page_params;

require_once FUNCTIONS_DIR."common.functions.inc.php";

if( isset($global_params['page_arguments']['bid']) && $global_params['page_arguments']['bid'] != "" && isset($global_params['page_arguments']['pid']) && $global_params['page_arguments']['pid'] != "" )
{
  $bid = $global_params['page_arguments']['bid'];
  $pid = $global_params['page_arguments']['pid'];
  
  //USE THE BELOW LINES WHEN YOU DO NOT HAVE MY_CRYPT INSTALLED IN PHP
  $encrypted_bid = base64_encode($bid);
  $encrypted_pid = base64_encode($pid);
  
  //USE THE BELOW LINES WHEN YOU HAVE MY_CRYPT INSTALLED IN PHP
  //$encrypted_bid = encrypt($bid);
  //$encrypted_pid = encrypt($pid);

  $url = "http://".HTTP_HOST_NAME."/shop/shop.html?bid=".$encrypted_bid."&pid=".$encrypted_pid;
  
  $bin2hex = bin2hex($bid."@".$pid);
  $pack = pack("H".strlen($bin2hex),$bin2hex);
  
  //echo $bin2hex."<br />".$pack;
}
?>
<html>
  <head>
    <title>Get Encrypt Value</title>
    <script type='text/javascript'>
    
    function checkVideo()
    {
        if(!!document.createElement('video').canPlayType)
        {
	    	var vidTest=document.createElement("video");
	    	oggTest=vidTest.canPlayType('video/ogg; codecs="theora, vorbis"');
	    	if (!oggTest)
	    	{
	    	    h264Test=vidTest.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"');
	    	    if (!h264Test)
	    	    {
	    			document.getElementById("checkVideoResult").innerHTML="Sorry. No video support."
	    	    }
	    	    else
	    	    {
		    		if (h264Test=="probably")
		    		{
		    		    document.getElementById("checkVideoResult").innerHTML="Yeah! Full support!";
		    		}
		    		else
		    		{
		    		    document.getElementById("checkVideoResult").innerHTML="Meh. Some support.";
		    		}
	    	    }
	    	}
	    	else
	    	{
	    	    if (oggTest=="probably")
	    	    {
	    			document.getElementById("checkVideoResult").innerHTML="Yeah! Full support!";
	    	    }
	    	    else
	    	    {
	    			document.getElementById("checkVideoResult").innerHTML="Meh. Some support.";
	    	    }
	    	}
        }
        else
        {
    		document.getElementById("checkVideoResult").innerHTML="Sorry. No video support."
        }
    }
    </script>
  </head>
  <body>
    <form method="post" action="">
      BID:&nbsp;<input type="text" id="bid" name="bid" value="" />
      <br />
      PID:&nbsp;<input type="text" id="pid" name="pid" value="" />
      <input type="submit" id="sbmt" name="sbmt" value="Get Link" />
    </form>

    <br />
    Encrypted Link:
    <br />
    <?php 
      if($url != '')
      {
    ?>
    <a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a>
    <?php
      }
    ?>
    
    <br />
    <button onclick="checkVideo()">Check HTML5 support</button>
    <span id="checkVideoResult"></span>
  </body>
</html>
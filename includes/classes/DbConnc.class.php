<?php

class DbConnc
{
    var $link;
    var $result;
    var $errnum;
    var $error;
    var $error_flag;
    var $num_rows;
    var $num_fields;

    var $username;
    var $password;
    var $database;
    var $host;
    var $options;
    var $lastInsertId;

    function __construct( $dbUrl,$options = array() ) {
        $url = parse_url($dbUrl);
        $this->username = urldecode($url['user']);
        $this->password = urldecode($url['pass']);
        $this->database = substr(urldecode($url['path']),1);

        $url['host'] = urldecode($url['host']);
        if( isset($url['port']))
        {
            $url['host'] = $url['host'].":".$url['port'];
        }
        list($this->host,$this->port) = preg_split('/:/',$url['host']);
        $this->link = '';
        $this->result = '';
        $this->errnum = '';
        $this->error = '';
        $this->error_flag = '';
        $this->num_rows = 0;
        $this->num_fields = 0;
        $this->options = $options;

        $this->db_connect();
    }

//	function Database($p_host='', $p_database='',$p_username='',$p_password='',$p_options=array())
//	{
//		list($this->host,$this->port) = preg_split('/:/',$p_host);
//		$this->database = $p_database;
//		$this->username = $p_username;
//		$this->password = $p_password;
//		$this->link = '';
//		$this->result = '';
//		$this->errnum = '';
//		$this->error = '';
//		$this->error_flag = '';
//		$this->num_rows = 0;
//		$this->num_fields = 0;
//		$this->options = $p_options;
//		//print_r($this);
//	}

    function db_connect()
    {
            $this->link = mysqli_init();
            foreach($this->options as $key => $val)
            {
                    mysqli_options($this->link,$key,$val);
            }

            $this->link = @mysqli_connect($this->host, $this->username, $this->password,'',$this->port) or die("Sorry. Could not connect to Database Server");

            if(!$this->link)
            {
                    $this->errnum = mysqli_errno($this->link);
                    $this->error = mysqli_error($this->link);
                    $this->error_flag = 1;
                    die("Could not connect to db ".$this->database.".\Error no: ".$this->errnum."\nError: ".$this->error);
                    return false;
            }

            if(!@mysqli_select_db($this->link, $this->database))
            {
                    $this->errnum = mysqli_errno($this->link);
                    $this->error = mysqli_error($this->link);
                    $this->error_flag = 1;
                    die("Cannot connect to database ".$this->database." for user ".$this->username."\nError no: ".$this->errnum."\nError: ".$this->error);
            }

            return true;
    }

    function db_escape_string($string)
    {
            if($this->link)
                    return mysqli_real_escape_string($this->link,$string);
    }

    function db_query($query)
    {
            //while($this->db_fetch_next_result());

            if(!@mysqli_multi_query($this->link, $query))
            {
                    $this->errnum = mysqli_errno($this->link);
                    $this->error = mysqli_error($this->link);
                    $this->error_flag = 1;
                    die("Could not execute query $query.\Error no: ".$this->errnum."\nError: ".$this->error);
                    return false;
            }

            $this->result = mysqli_store_result($this->link);

            if( mysqli_errno($this->link) ) {
                $this->errnum = mysqli_errno($this->link);
                $this->error = mysqli_error($this->link);
                $this->error_flag = 1;
                return false;
            }
            
//            if(!$this->result)
//            {
//                    $this->errnum = mysqli_errno($this->link);
//                    $this->error = mysqli_error($this->link);
//                    $this->error_flag = 1;
//                    die("Could not fetch result for query $query.\Error no: ".$this->errnum."\nError: ".$this->error);
//                    return false;
//            }

            $this->num_fields = @mysqli_num_fields($this->result);
            if($this->num_fields)
                $this->num_rows = @mysqli_num_rows($this->result);
            else
            {
                $this->num_rows = @mysqli_affected_rows($this->link);
                $this->num_fields = 0;
            }
            $this->lastInsertId = @mysqli_insert_id($this->link);

            return true;
    }

    function db_fetch_next_result()
    {
            if(!$this->result)
                    return false;

            $this->db_free_result();

            mysqli_more_results($this->link);

            if(!mysqli_next_result($this->link))
                    return false;

            $this->result = mysqli_store_result($this->link);

            if( mysqli_errno($this->link) ) {
                $this->errnum = mysqli_errno($this->link);
                $this->error = mysqli_error($this->link);
                $this->error_flag = 1;
                return false;
            }
            
//            if(!$this->result)
//            {
//                $this->errnum = mysqli_errno($this->link);
//                $this->error = mysqli_error($this->link);
//                $this->error_flag = 1;
//                return false;
//            }

            $this->num_fields = @mysqli_num_fields($this->result);
            if($this->num_fields)
                    $this->num_rows = @mysqli_num_rows($this->result);
            else
            {
                    $this->num_rows = @mysqli_affected_rows($this->link);
                    $this->num_fields = 0;
            }

            return true;
    }

    function db_fetch_num_fields()
    {
            return $this->num_fields;
    }

    function db_num_rows()
    {
            return $this->num_rows;
    }

    function db_fetch_array()
    {
            if($this->result)
                    return mysqli_fetch_array($this->result,MYSQL_ASSOC);
    }

    function db_fetch_assoc()
    {
            if($this->result)
                    return mysqli_fetch_assoc($this->result);
    }

    function db_fetch_row()
    {
            if($this->result)
                    return mysqli_fetch_row($this->result);
    }

    function db_fetch_field($offset = 0)
    {
            if($this->result)
                    return mysqli_fetch_field_direct($this->result, $offset)->name;
    }

    function db_free_result()
    {
            if($this->result)
            {
                    $this->num_fields = 0;
                    $this->num_rows = 0;
                    return mysqli_free_result($this->result);
            }

            return 0;
    }

    function db_close()
    {
            if($this->link)
                    return mysqli_close($this->link);
    }
}
?>
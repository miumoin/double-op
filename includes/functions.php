<?php
/*
 * Project: Double-P Framework
 * Copyright: 2011-2012, Moin Uddin (pay2moin@gmail.com)
 * Version: 1.0
 * Author: Moin Uddin
 */
function heading()
{
    module_include("header");
}

function footing()
{
    $base=BASE;
    module_include("footer");
}

function set_flash_message($message, $flag)
{
    $_SESSION['flash']['message']=$message;
    $_SESSION['flash']['type']=$flag;
}

function get_flash_message()
{
    if(isset($_SESSION['flash']))
    {
        $message=array('message'=>$_SESSION['flash']['message'], 'type'=>$_SESSION['flash']['type']);
        unset($_SESSION['flash']);
        return $message;
    }
    else return 0;
}

function logged_in()
{
    if( isset( $_SESSION['shop'] ) ) {
		
		return true;
		
	} else return false;
}

//following function returns the id of current user
function current_user_info($parameter)
{
    if(isset($_SESSION['auth_user'][$parameter])) return $_SESSION['auth_user'][$parameter];
    else return false;
}

function db_connect()
{
	$link=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('<h1>Could not connect to database</h1>');
	mysql_select_db(DB_NAME,$link) or die('<h1>Could not connect to database</h1>');
	return $link;
}

function module_include($module)
{
    global $option, $mysqli;
	if(file_exists("modules/".$module."/".$module.".php")) include("modules/".$module."/".$module.".php");
}

function form_processor()
{
	if(isset($_REQUEST['process']))
	{
		$func="process_".$_REQUEST['process'];
		$func();
		die();
	}
}

//following function creates a pagination
function paginate($total, $current_page, $total_every_page, $url)
{

    $total_pages=$total/$total_every_page;
    if($total_page>round($total_page)) $total_pages=round($total_pages)+1;

    if($current_page>1) echo "<a href='".$url."/page/".($current_page-1)."'><input type='submit' value='<<<Previous'></a>";
    if($current_page<($total_pages)) echo "<a href='".$url."/page/".($current_page+1)."'><input type='submit' value='Next>>>'></a>";
}

function upload_an_image($max_size, $prefix, $valid_exts) {        
        
        $path = FILEUPLOAD; // upload directory
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            if( ! empty($_FILES['image']) ) {
                // get uploaded file extension
                $ext = strtolower(pathinfo($_FILES['image']['name'][0], PATHINFO_EXTENSION));
                // looking for format and size validity
                if (in_array($ext, $valid_exts) AND $_FILES['image']['size'][0] < $max_size*50) {
                    $path = $path . uniqid(). $prefix.rand(0,100).'.' .$ext;
                    
                    
                    // move uploaded file from temp to uploads directory
                    if (move_uploaded_file($_FILES['image']['tmp_name'][0], $path)) {   
                        return $path;
                    } //else echo $_FILES['image']['tmp_name'][0];
                } else {
                    //echo 'Invalid file!';
                }
            } else {
                //echo 'File not uploaded!';
            }
        } else {
            //echo 'Bad request!';
        }
    }
    
    function add_shop_meta( $shop_id, $meta_name, $value ) {
		
		global $mysqli;
		$res = $mysqli->query("SELECT meta_id FROM shops_meta WHERE meta_name='$meta_name' AND shop_id='$shop_id'");
		if( $res->num_rows > 0 ) {
			
			$arr = $res->fetch_array( MYSQLI_ASSOC );
			$mysqli->query("UPDATE shops_meta SET meta_value='" . $mysqli->real_escape_string( $value ) . "' WHERE meta_id='" . $arr['meta_id'] . "'");
		} else $mysqli->query("INSERT INTO shops_meta (shop_id, meta_name, meta_value) VALUES ('" . $shop_id . "', '" . $mysqli->real_escape_string( $meta_name ) . "', '" . $mysqli->real_escape_string( $value ) . "')");
		
		return true;
	}
	
	function delete_shop_meta( $shop_id, $meta_name ) {
		
		global $mysqli;
		$res = $mysqli->query("DELETE FROM shops_meta WHERE shop_id='" . $_SESSION['shop_id'] . "' AND meta_name='" . $mysqli->real_escape_string( $meta_name ) . "'");
		return true;
	}
	
	function get_shop_meta( $shop_id, $meta_name ) {
		
		global $mysqli;
		$res = $mysqli->query("SELECT meta_value FROM shops_meta WHERE meta_name='$meta_name' AND shop_id='$shop_id'");
		if( $res->num_rows > 0 ) {
			
			$arr = $res->fetch_array( MYSQLI_ASSOC );
			return $arr['meta_value'];
		} else return false;
	}
	
	function google_pagespeed_insight( $url ) {

        $url = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=' . urlencode( $url );
        $useragent="Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:24.0) Gecko/20100101 Firefox/24.0";
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_USERAGENT, $useragent); // set user agent
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $output = curl_exec ($ch);
        curl_close($ch);
        $output = json_decode( $output );
        return $output->ruleGroups->SPEED->score;
    }

    function diff_with_current_time( $time ) {

        $current_time = date("Y-m-d H:i:s");
        return $diff = ( strtotime( $current_time ) - strtotime( $time ) );
    }
?>

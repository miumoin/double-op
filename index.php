<?php
/*
 * Project: Double-P Framework
 * Copyright: 2011-2012, Moin Uddin (pay2moin@gmail.com)
 * Version: 1.0
 * Author: Moin Uddin
 */
	$url = $_SERVER['REQUEST_URI'];
    //starting a secured session
    session_start();

    include ( "config/connection.php" );
    include ( "includes/functions.php" );
    
    //Connecting database
    /*$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }*/

    //breaking the url to many parts
    $break = explode ( "/", $url );

    //broken useful parts starts from the array position $start
    $start = START;

    $uurl = ""; //universal/global use purpose url
    $i = $start;
    while ( $i < count ( $break ) ) {
        $uurl = $break[$i] . "/";
        $i++;
    }
    $GLOBALS['url'] = $uurl;

    /*Start routing*/
    $option = $break[ $start ];
    if ( ( $option != "" ) && ( is_dir ( "modules/" . $option ) ) ) $module = "modules/" . $option;
    else {
        $option = "home";
        $module = "modules/" . $option;
    }
    include ( $module . "/" . $option . ".php" );

    /* if a class exists with the string of $option, create the object */
    if( class_exists ( $option ) ) {
        $option_obj = new $option();
        /* if form is submitted */
        if( ( isset( $_REQUEST['process'] ) ) && ( method_exists( $option_obj, 'process_' . $_REQUEST['process'] ) ) ) {
            $process_func = 'process_' . $_REQUEST['process'];
            $option_obj->$process_func();
            die();
        }

        /* call method based on URL structure */
        echo START;
        echo '<pre>';
            var_dump( $break );
        echo '</pre>';


    }
 ?>

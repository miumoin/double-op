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

    //breaking the url to many parts
    $break = explode ( "/", $url );

    //broken useful parts starts from the array position $start
    $start = START;

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
        $break_points = count( $break );
        for( $j = ( count( $break ) - START ); $j >= 0; $j-- ) {
            $break_point_method = '';
            for( $i = 1; $i < ( $j ); $i++ ) {
                $break_point_method .= ( $break_point_method != '' ? '_' : '' ) . $break[ START + $i ];
            }

            if( method_exists( $option_obj, $break_point_method ) ) {
                $option_obj->$break_point_method();
                break;
            }
        }

    }
 ?>

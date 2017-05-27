<?php
    $ref = $_SERVER['HTTP_REFERER'];
    if(strpos($ref, $_SERVER['HTTP_HOST']) > -1) {
        $url = "";
        if( isset( $_GET['url'] ) )
        {
            $url = $_GET[ 'url' ];
        }
        else
        {
            exit();
        }
        $imginfo = getimagesize( $url );
        header("Content-type: ".$imginfo['mime']);
        readfile( $url );
    }
    echo 'fuck off';
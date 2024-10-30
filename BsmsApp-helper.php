<?php

function kurieriBG_get_netgsm_headers($username,$password) {
    $password= urlencode($password);
    $url= "#";
    $request = wp_remote_get($url);

    if ($request['body'] !=30) {
        return array_filter(explode("<br>",$request['body']));
    } else {
        return false;
    }
}

function kurieriBG_get_netgsm_packet_info($username,$password) {
    $password= urlencode($password);
    $url= "#";
    $request = wp_remote_get($url);

    if ($request['body'] !=30) {
        return $request['body'];
    } else {
        return false;
    }
}

function kurieriBG_get_netgsm_credit_info($username,$password) {
    $password= urlencode($password);
    $url= "#";
    $request = wp_remote_get($url);

    if ($request['body'] !=30) {
        return  explode(" ",$request['body'])[1];
    } else {
        return false;
    }
}

?>
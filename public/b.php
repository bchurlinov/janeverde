<?php
$servername = "localhost";
$username = "buyadoo_jvr";
$password = "Nr2fJ4T6s88KUCd";
$db = "buyadoo_janeverde";
include("xmlapi.php");
// Create connection
$con = new mysqli($servername, $username, $password, $db);

$fromQuery = $con->query("SELECT * FROM `useremails` WHERE `email`='hristijan.tintar111@gmail.com' LIMIT 1");

if(mysqli_num_rows($fromQuery) == 0){
    $ip = "127.0.0.1";            
    $account = "buyadoo";       
    $passwd ="Yicu3E9Weckb";          
    $port =2083;                 
    $email_domain ="buyadoo.com";
    $email_user =md5(uniqid(rand(), true));
    $email_pass =md5(uniqid(rand(), true));
    $email_quota = 0;             
    $xmlapi = new xmlapi($ip);
    $xmlapi->set_port($port);
    $xmlapi->password_auth($account, $passwd);
    $xmlapi->set_debug(0);
    $xmlapi->set_output('json');
    
    //create the user
    $call = array('domain' => $email_domain, 'email' => $email_user, 'password' => $email_pass, 'quota' => $email_quota);
    
    $result = $xmlapi->api2_query($account, "Email", "addpop", $call );
    
    $p['domain']	= 'buyadoo.com';
    $p['email']		= $email_user;
    $p['password']  = $email_pass;
    $p['fwdopt']	= 'pipe';
    $p['pipefwd']	= '/usr/bin/php -f /home/buyadoo/public_html/public/parse.php';
    
    //add the forwarder
    $res = $xmlapi->api2_query($account, 'Email', 'addforward', $p);
    $con->query("INSERT INTO `useremails`(`email`, `masked`, `maskedpass`) VALUES ('$from','$email_user@$email_domain','$email_pass')");
    $fromEmail = $email_user;
    $fromPass  = $email_pass;
}
else{
    $fr = mysqli_fetch_assoc($fromQuery);
    $fromEmail = $fr['masked'];
    $fromPass  = $fr['maskedpass'];
}


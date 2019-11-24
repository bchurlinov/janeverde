<?php

include("xmlapi.php");

$ip = "127.0.0.1";            
$account = "justinho";       
$passwd ="Sftech@2020!!";          
$port =2083;                 
$email_domain ="justinhoffman.net";
$email_user ="john";
$email_pass ="johnspassword";
$email_quota = 0;             
$xmlapi = new xmlapi($ip);
$xmlapi->set_port($port);
$xmlapi->password_auth($account, $passwd);
$xmlapi->set_debug(0);
$xmlapi->set_output('json');

//create the user
$call = array('domain' => $email_domain, 'email' => $email_user, 'password' => $email_pass, 'quota' => $email_quota);

$result = $xmlapi->api2_query($account, "Email", "addpop", $call );

$p['domain']	= 'justinhoffman.net';
$p['email']		= 'john';
$p['password']  = 'johnspassword';
$p['fwdopt']	= 'pipe';
$p['pipefwd']	= '/home2/justinho/parse.php';

//add the forwarder
$res = $xmlapi->api2_query($account, 'Email', 'addforward', $p);

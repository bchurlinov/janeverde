#!/usr/bin/php -q
<?php
//include the scripts
require_once 'vendor/autoload.php';
include("xmlapi.php");

// connect to mysql
$servername = "localhost";
$username = "justinho_jvr";
$password = "Nr2fJ4T6s88KUCd";
$db = "justinho_janeverde";

// get mail via stdin
$email = file_get_contents("php://stdin");

// set empty vars and explode message to variables
$from = "";
$subject = "";
$to = "";
$headers = "";
$message = "";

$mailParser = new \ZBateson\MailMimeParser\MailMimeParser();
$message = $mailParser->parse($email);

$subject = $message->getHeaderValue('subject');
$text = $message->getTextContent();
$from = $message->getHeader('from');

$matches = null;
preg_match_all('/<(.*)>/', $from, $matches);
$from = $matches[1][0];

$to = $message->getHeader('to')->getAddresses()[0];

// Create connection
$con = new mysqli($servername, $username, $password, $db);
$sql = "INSERT INTO `emails`(`EmailFrom`, `EmailTo`, `EmailSubject`, `EmailBody`) VALUES ('test', 'test', 'test', 'test')";
  $res = $con->query($sql);
  exit;

$fromQuery = $con->query("SELECT * FROM `useremails` WHERE `email`='$from' LIMIT 1");
$toQuery = $con->query("SELECT * FROM `useremails` WHERE `email`='$to' OR `masked`='$to' LIMIT 1");

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
    $p['pipefwd']	= '/home/buyadoo/public_html/public/parse.php';
    
    //add the forwarder
    $res = $xmlapi->api2_query($account, 'Email', 'addforward', $p);
    
    //insert it in database
    $con->query("INSERT INTO `useremails`(`email`, `masked`, `maskedpass`) VALUES ('$from','$email_user@$email_domain','$email_pass')");
    
    $fromEmail = $email_user.'@'.$email_domain;
    $fromPass  = $email_pass;
}
else{
    $fr = mysqli_fetch_assoc($fromQuery);
    $fromEmail = $fr['masked'];
    $fromPass  = $fr['maskedpass'];
}

$toq = mysqli_fetch_assoc($toQuery);
$to = $toq['email'];

$sql = "INSERT INTO `emails`(`EmailFrom`, `EmailTo`, `EmailSubject`, `EmailBody`) VALUES ('$fromEmail', '$to', '$subject', '$text')";
  $res = $con->query($sql);

//we have from email, from password, and to, send the email now
$transport = (new \Swift_SmtpTransport('buy.buyadoo.com', 25))->setUsername($fromEmail)->setPassword($fromPass);

$mailer = new \Swift_Mailer($transport);

$message = (new \Swift_Message($subject))->setFrom([$fromEmail])->setTo([$to])->setBody($text);
$message->setContentType("text/html");
$mailer->send($message);

//$headers = "From:" . $fromEmail;
//mail($to,$subject,$text, $headers);

$sql = "INSERT INTO `emails`(`EmailFrom`, `EmailTo`, `EmailSubject`, `EmailBody`) VALUES ('$fromEmail', '$to', '$subject', '$text')";
$res = $con->query($sql);
exit;
?>
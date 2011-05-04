#!/usr/bin/env php
<?php

if (!isset($argv[3])){
	$script_name = $argv[0];
	echo basename($script_name) . ": missing operand\n";
	echo "Usage: " . $script_name . " IP-address login password\n";
	exit;
}

$cisco_ip = $argv[1];
$login = $argv[2];
$password = $argv[3];

if ($socket=pfsockopen($cisco_ip, 23))
{
	read_welcome_message($socket);
	$result = send_login($socket, $login); 
	$result = send_passw($socket, $password); 
	if ($result === false)
	{
		exit("Auth failed\n"); 
	}
	else
	{
		send_command($socket, 'terminal length 0');
		send_command($socket, 'show config');
	}
}
else
{
	exit("Unable to connect to $cisco_ip");
}

fclose($socket);

function read_welcome_message($socket)
{
	while ($out = fread($socket, 512))
	{
		if(preg_match('/Username:/i',$out))
		return (true); 
	}
}
function send_login($socket, $username) 
{ 
   fputs($socket, $username . "\r"); 
   while ($out = fread($socket, 512)) 
   { 
      if(preg_match('/Password:/i',$out)) 
         return (true); 
   } 
} 

function send_passw($socket, $password) 
{ 
	fputs($socket, $password . "\r"); 
	while ($out = fread($socket, 512)) 
	{
		if(preg_match('/#/i',$out)) 
			return(true);
		if(preg_match('/Username:/i',$out)) 
			return(false);
   } 
} 
function send_command($socket, $command) 
{
	fputs($socket, $command . "\r");
	sleep(1);
	$out = fread($socket, 512);
	$stat = socket_get_status($socket);
	$socket_unread_bytes = $stat["unread_bytes"];
	if ($socket_unread_bytes)
	{
		$out .= fread($socket, $socket_unread_bytes);
	}
	//$out = str_replace($command, '', $out);
	echo $out;
	if(preg_match('/[#]/i',$out))
		return(true);
} 

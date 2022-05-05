<?php
	/*
	APP Name: IOT Relay Controller
	Author: EtaNetwork(Daud)
	File: switching.php
	Website: http://eta-network.com/
	*/

	$fh=fopen('relaystate.txt', 'r');//open .txt filefor reading

	$relay_states=fgets($fh);// get the file content

	echo "Relay".$relay_states;

	fclose($fh);
?>
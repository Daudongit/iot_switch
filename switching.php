<?php
	/*
	APP Name: IOT Relay Controller
	Author: EtaNetwork(Daud)
	File: switching.php
	Website: http://eta-network.com/
	*/

	// error_log("**** relay_id *****:{$relay_id}", 4);
	// error_log("**** relay_id *****:{$relay_id}", 3, 'log.txt'); // Log to file

	$relay_id = $_POST["relay_id"];	
	
	$textfile = "relaystate.txt"; // Declares the name and location of the .txt file

	$fileLocation = "$textfile";

	$fh = fopen($fileLocation, 'r') or die("Something went wrong!"); // Opens up the .txt file for reading

	$previous_state=fgets($fh); //get devices previous state

	$previous_state=str_split($previous_state);

	$new_state=$previous_state;

	$real_id=$relay_id - 1;

	$new_state[$real_id]=$new_state[$real_id]=='0'?'1':'0';

	$new_state=implode('', $new_state);

	$fh = fopen($fileLocation, 'w') or die("Something went wrong!"); // Opens up the .txt file for writing and replaces any previous content
	//$new_state=implode('', $new_state);

	fwrite($fh, $new_state); // Writes the new device state to the .txt file
	 
	fclose($fh); 	 
	//header("Location: index.html"); // Return to frontend (index.html) 
	//echo  $previous_state[$real_id]+1;
	echo $new_state;
	
?>
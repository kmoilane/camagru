<?php

function generate_otp()
{
	$otp = str_shuffle("0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM");
	$otp = substr($otp, 0, 10);
	return ($otp);
}

?>

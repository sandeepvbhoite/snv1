<?php

# Copyright 2012 Rohitt Shinde <shinde.rohitt@gmail.com>

# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
# MA 02110-1301, USA.
?>
<?php
	session_start();
	require_once('model/database.php');
	require_once('model/userInfo.php');
	
	if (!isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['emailAddress']) || !isset($_POST['password']) ) {
		$error = " Please fill in all the details to get signed up!";
		include ('loginpage.php');
	}

	$fname = $_POST['firstName'];
	$fname_pattern = '/(?=.*[[:digit:]])/';
	$isfnameok = preg_match($fname_pattern, $fname);
	if ($isfnameok) {
		$fnameerror = "Your first name should contain letters only";
	}

	$lname = $_POST['lastName'];

	$lname_pattern = '/(?=.*[[:digit:]])/';
	$islnameok = preg_match($lname_pattern, $lname);
	if ($islnameok) {
		$lnameerror = "Your last name should contain letters only";
	}


	$year  = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$gender = $_POST['gender'];
	$email = $_POST['emailAddress'];
	if (!filter_var ($email, FILTER_VALIDATE_EMAIL)) {
		$emailerror = "Please enter a valid email address";
	}
	$password = $_POST['password'];
	$pw_pattern = '/^(?=.*[[:digit:]]) (?=.*[[:punct:]])[[:print:]]{6,}$/';
	$isPasswordOk = preg_match($pw_pattern, $password);
	if (!$isPasswordOk) {
		$passworderror = "Password must contain at least 6 characters, 1 digit, 1 punctuation character";
	}
	$dob = $year . '-' . $month . '-' . $day;
	
	if ($isfnameok || $islnameok || $isPasswordOk || $emailerror) {
		include ('logina2.php');
	}

	if (createUser($fname, $lname, $dob, $gender, $email, $password)) {
		$userid = getuserID($email);
		$_SESSION['userid'] = $userid;
		header('Location: .');
	} else {
		include ('loginpage.php');
	}

?>

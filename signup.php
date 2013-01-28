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
	
	# Let's first save user information 
	
	$fname = trim($_POST['firstName']);	
	$lname = trim($_POST['lastName']);
	$year  = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$gender = $_POST['gender'];
	$email = trim($_POST['emailAddress']);
	$password = $_POST['password'];

	# Checking if all fields are filled

	if (empty($fname) || empty($lname) || empty($email) || empty($password)) {
		# since user has not filled all the necessary details,
		# this is redirecting user to the welcome page
		header('Location: .');
	}
	# Birthdate validation, using checkdate temporarily, not the right place for it 
	# here. It expects its parameters to be integers.
	if(!checkdate($month, $day, $year)) {
		$dateError = "Please select a valid birth date";
	}
	# Name validation
	$fname_pattern = '/(?=.*[[:digit:]])/';
	$isfnameok = preg_match($fname_pattern, $fname);
	if ($isfnameok) {
		$fnameerror = "Your first name should contain letters only";
	}
	$lname_pattern = '/(?=.*[[:digit:]])/';
	$islnameok = preg_match($lname_pattern, $lname);
	if ($islnameok) {
		$lnameerror = "Your last name should contain letters only";
	}
	if (!filter_var ($email, FILTER_VALIDATE_EMAIL)) {
		$emailerror = "Please enter a valid email address";
	}
	/*
	This is rude, I guess.. I am not sure, if this should be used..
	$pw_pattern = '/^(?=.*[[:digit:]]) (?=.*[[:punct:]])[[:print:]]{6,}$/';
	$isPasswordOk = preg_match($pw_pattern, $password);
	if (!$isPasswordOk) {
		$passworderror = "Password must contain at least 6 characters, 1 digit, 1 punctuation character";
	}
	*/
	$dob = $year . '-' . $month . '-' . $day;
	
	if ($fnameerror || $lnameerror || $emailerror || $passworderror || $dateError) {
		include ('logina2.php');
	} else {
		createUser($fname, $lname, $dob, $gender, $email, $password);
		$userid = getuserID($email);
		$_SESSION['userid'] = $userid;
		header('Location: .');
	} 

?>

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
?><?php
	$db = database::getDB();	
	function getuserID($email) {
		global $db;
		$query = "SELECT userID from users
			WHERE emailAddress = '$email'";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		$userid = $row['userID'];
		$result->free();
		return $userid;
	}

	function createUser($fname, $lname, $dob, $gender, $email, $password) {
		global $db;
		$query = "INSERT INTO users
		(emailAddress, password, firstName, lastName, gender, birthday)
		VALUES
		('$email', '$password', '$fname', '$lname', '$gender', '$dob')";
		$success = $db->query($query);
		return $success;
	}

	function getProfile($userid) {
		global $db;
		$query = "SELECT * FROM users
			WHERE userID = '$userid'";	
		$success = $db->query($query);
		$total = $success->num_rows;
		$profile = array();
		$row = $success->fetch_assoc();
		$profile['emailAddress'] = $row['emailAddress'];
		$profile['fname'] = $row['firstName'];
		$profile['lname'] = $row['lastName'];
		$profile['pic'] = $row['pic'];
		$profile['gender'] = $row['gender'];
		$profile['birthday'] = $row['birthday'];
		$profile['education'] = $row['education'];
		$profile['languages'] = $row['languages'];
		$profile['country'] = $row['country'];
		$profile['state'] = $row['state'];
		$profile['city'] = $row['city'];
		$profile['status'] = $row['status'];
		$profile['mobile'] = $row['mobile'];
		$profile['website'] = $row['website'];
		$success->free();	
		return $profile;
	}

	function getUserName($userid) {
		global $db;
		$query = "SELECT firstName, lastName FROM users
				WHERE userID = '$userid'";
		$result = $db->query($query);
		$tmp    = $result->fetch_assoc();
		$userName = array();
		$userName['fname'] = $tmp['firstName'];
		$userName['lname'] = $tmp['lastName'];
		$result->free();
		return $userName;
	}

	function changePassword ($userid, $password) {
		global $db;
		$query = "UPDATE users 
				SET password = '$password'
				WHERE userID =  '$userid'" ;
		$result = $db->query($query);
		return $result;
	}

	function updatePersonalInfo ($userid, $fname, $lname, $city, $birthday, $status, $education, $languages) {
		global $db;
		$query = "UPDATE users
				SET firstName = '$fname',
					lastName  = '$lname',
					city      = '$city',
					birthday  = '$birthday',
					status    = '$status',
					education = '$education',
					languages = '$languages'
				WHERE userID = '$userid'";
		$result = $db->query($query);
		return $result;
	}

	function updateContactInfo ($userid, $city, $state, $country, $email, $website, $mobile) {
		global $db;
		$query = "UPDATE users
				SET city = '$city',
					country = '$country',
					state = '$state',
					emailAddress = '$email',
					website = '$website',
					mobile = '$mobile'
				WHERE userID = '$userid'";
		$result = $db->query($query);
		return $result;
	}

	function currentPassword ($userid) {
		global $db;
		$query = "SELECT password FROM users
				WHERE userID = '$userid'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$password = $row['password'];
		return $password;
	}

	function getCurrentProfilePic($userid) {
		global $db;
		$query = "SELECT pic FROM users
				WHERE userID = '$userid'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$image_path = $row['pic'];
		return $image_path;
	}

	function changeProfilePic ($userid, $newPath) {
		global $db;
/*		$query = "INSERT INTO images
				(userID, imagePath)
				VALUES
				('$userid', '$newPath')";
		$success = $db->query($query);
		$query = "SELECT imagePath FROM images
				WHERE userID = '$userid'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$newpic = $row['imagePath'];
*/
		$query = "UPDATE users
				SET pic = '$newPath'
				WHERE userID = '$userid'";
		$success = $db->query($query);
		return $success;
	}

	function removeProfilePic ($userid) {
		global $db;
		$query = "UPDATE users SET pic = 'sample.png'
				WHERE userID = '$userid'";
		$success = $db->query($query);
		return $success;
	}
	
	function getCityAndAge($userid) {
		global $db;
		$query = "SELECT city, birthday FROM users
				WHERE userID = '$userid'";
		$success = $db->query($query);
		$result = array();
		$row = $success->fetch_assoc();
		$result['city'] = $row['city'];
		$birthday = $row['birthday'];
		$year = substr($birthday, 0, 4);
		$result['age'] = 2012 - $year;
		$success->free();
		return $result;
	}
?>

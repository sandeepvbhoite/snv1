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
			WHERE emailAddress = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $email);
		$stmt->bind_result($userid);
		$stmt->execute();
		$row = $stmt->fetch();
		$stmt->close();
		return $userid;
	}

	function createUser($fname, $lname, $dob, $gender, $email, $password) {
		
		global $db;

		$query = "INSERT INTO users
		(emailAddress, password, firstName, lastName, gender, birthday)
		VALUES
		(?, ?, ?, ?, ?, ?)";

		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssss", $email, $password, $fname, $lname, $gender, $dob);
		$success = $stmt->execute();
		$stmt->close();
		return $success;
	}

	function getProfile($userid) {

		global $db;

		$query = "SELECT emailAddress, firstName, lastName,
			pic, gender, birthday, education, languages, country, state,
			city, status, mobile, website 
			FROM users
			WHERE userID = ?";	

		$stmt = $db->stmt_init();
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($emailAddress, $firstName, $lastName,
				$pic, $gender, $birthday, $education, $languages, $country,
				$state, $city, $status, $mobile, $website);
		$stmt->execute();
		
		$row = $stmt->fetch();
		$stmt->close();
		$profile = array();
		$profile['emailAddress'] = $emailAddress; 
		$profile['fname'] = $firstName; 
		$profile['lname'] = $lastName; 
		$profile['pic'] = $pic; 
		$profile['gender'] = $gender; 
		$profile['birthday'] = $birthday; 
		$profile['education'] = $education; 
		$profile['languages'] = $languages; 
		$profile['country'] = $country; 
		$profile['state'] = $state; 
		$profile['city'] = $city; 
		$profile['status'] = $status; 
		$profile['mobile'] = $mobile; 
		$profile['website'] = $website; 
		return $profile;
	}

	function getUserName($userid) {
		
		global $db;

		$query = "SELECT firstName, lastName FROM users
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $userid);
		$stmt->bind_result($firstName, $lastName);
		$stmt->execute();
		// Fetch result
		$stmt->fetch();
		$stmt->close();
		// Create an array to store first, last names
		$userName = array();
		$userName['fname'] = $firstName;
		$userName['lname'] = $lastName;
		return $userName;
	}

	function changePassword ($userid, $password) {
	
		global $db;
		
		$query = "UPDATE users 
				SET password = ?
				WHERE userID = ?" ;

		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $userid, $password);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	function updatePersonalInfo ($userid, $fname, $lname, $city, $birthday, 
			$status, $education, $languages) {

		global $db;

		$query = "UPDATE users
				SET firstName = ?,
					lastName  = ?,
					city      = ?,
					birthday  = ?,
					status    = ?,
					education = ?,
					languages = ?
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("sssssssi", $fname, $lname, $city, $birthday,
				$status, $education, $languages, $userid);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	function updateContactInfo ($userid, $city, $state, $country, $email, 
			$website, $mobile) {

		global $db;

		$query = "UPDATE users
				SET city = ?,
					country = ?,
					state = ?,
					emailAddress = ?,
					website = ?,
					mobile = ?
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("ssssssi", $city, $country, $state, $email, 
				$website, $mobile, $userid);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	function currentPassword ($userid) {
		
		global $db;

		$query = "SELECT password FROM users
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($password);
		$stmt->execute();
		$row = $stmt->fetch();
		$stmt->close();
		return $password;
	}

	function getCurrentProfilePic($userid) {
		
		global $db;

		$query = "SELECT pic FROM users
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($imagepath);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->close();
		return $imagepath;
	}

	function changeProfilePic ($userid, $newPath) {

		global $db;

		$query = "UPDATE users
				SET pic = ?
				WHERE userID = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("si", $newpath, $userid);
		$success = $stmt->execute();
		$stmt->close();
		return $success;
	}

	function removeProfilePic ($userid) {

		global $db;

		$query = "UPDATE users SET pic = 'sample.png'
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $userid);
		$success = $stmt->execute();
		return $success;
	}
	
	function getCityAndAge($userid) {
		
		global $db;
		
		$query = "SELECT city, birthday FROM users
				WHERE userID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($city, $birthday);
		$success = $stmt->execute();
		$stmt->fetch();
		$stmt->close();

		$result = array();
		$result['city'] = $city;
		$year = substr($birthday, 0, 4);
		$result['age'] = 2012 - $year;
		
		return $result;
	}
?>

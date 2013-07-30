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
		$stmt->bindValue("1", $email);
		$stmt->execute();
		$row = $stmt->fetch();
		$userid = $row['userID'];
		return $userid;
	}

	function createUser($fname, $lname, $dob, $gender, $email, $password) {
		
		global $db;

		$query = "INSERT INTO users
		(emailAddress, password, firstName, lastName, gender, birthday)
		VALUES
		(?, ?, ?, ?, ?, ?)";
		
		// Prepare SQL statement
		$stmt = $db->prepare($query);
		// Bind values
		$stmt->bindValue(1, $email);
		$stmt->bindValue(2, $password);
		$stmt->bindValue(3, $fname);
		$stmt->bindValue(4, $lname);
		$stmt->bindValue(5, $gender);
		$stmt->bindValue(6, $dob);
		$success = $stmt->execute();
		$stmt->closeCursor();
		return $success;
	}

	function getProfile($userid) {

		global $db;

		$query = "SELECT emailAddress, firstName, lastName,
			pic, gender, birthday, education, languages, country, state,
			city, status, mobile, website 
			FROM users
			WHERE userID = ?";	

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		//$stmt->bind_result($emailAddress, $firstName, $lastName,
		//		$pic, $gender, $birthday, $education, $languages, $country,
		//		$state, $city, $status, $mobile, $website);
		$stmt->execute();
		
		$row = $stmt->fetch();
		$stmt->closeCursor();
		$profile = array();
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
		return $profile;
	}

	function getUserName($userid) {	

		global $db;	
		$query = "SELECT firstName, lastName 
			FROM users 
			WHERE userID = ?";

		$stmt = $db->prepare($query);
		
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		// Fetch result
		$row = $stmt->fetch();
		
		$stmt->closeCursor();
		// Create an array to store first, last names
		$userName = array();
		$userName['fname'] = $row['firstName'];
		$userName['lname'] = $row['lastName'];
		return $userName;
	}

	function changePassword ($userid, $password) {
	
		global $db;
		
		$query = "UPDATE users 
				SET password = ?
				WHERE userID = ?" ;

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $password);
		$stmt->bindValue(2, $userid);
		
		$result = $stmt->execute();
		$stmt->closeCursor();
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
		
		$stmt->bindValue(1, $fname);
		$stmt->bindValue(2, $lname);
		$stmt->bindValue(3, $city);
		$stmt->bindValue(4, $birthday);
		$stmt->bindValue(5, $status);
		$stmt->bindValue(6, $education);
		$stmt->bindValue(7, $languages);
		$stmt->bindValue(8, $userid);
		
		$result = $stmt->execute();
		$stmt->closeCursor();
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
		
		$stmt->bindValue(1, $city);
		$stmt->bindValue(2, $country);
		$stmt->bindValue(3, $state);
		$stmt->bindValue(4, $email);
		$stmt->bindValue(5, $website);
		$stmt->bindValue(6, $mobile);
		$stmt->bindValue(7, $userid);
		
		$result = $stmt->execute();
		$stmt->closeCursor();
		return $result;
	}

	function currentPassword ($userid) {
		
		global $db;

		$query = "SELECT password FROM users
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		$row = $stmt->fetch();
		$stmt->closeCursor();
		$password = $row['password'];
		return $password;
	}

	function getCurrentProfilePic($userid) {
		
		global $db;

		$query = "SELECT pic FROM users
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		$row = $stmt->fetch();
		$stmt->closeCursor();
		$imagepath = $row['pic'];
		return $imagepath;
	}

	function changeProfilePic ($userid, $newPath) {

		global $db;

		$query = "UPDATE users
				SET pic = ?
				WHERE userID = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("si", $newpath, $userid);
		$stmt->bindValue(1, $newpath);
		$stmt->bindValue(2, $userid);

		$success = $stmt->execute();
		$stmt->closeCursor();
		return $success;
	}

	function removeProfilePic ($userid) {

		global $db;

		$query = "UPDATE users SET pic = 'sample.png'
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$success = $stmt->execute();
		$stmt->closeCursor;
		return $success;
	}
	
	function getCityAndAge($userid) {
		
		global $db;
		
		$query = "SELECT city, birthday FROM users
				WHERE userID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$success = $stmt->execute();
		$row = $stmt->fetch();
		$stmt->closeCursor();

		$result = array();
		$result['city'] = $row['city'];
		$birthday = $row['birthday'];
		$year = substr($birthday, 0, 4);
		$result['age'] = date('Y') - $year;
		
		return $result;
	}
?>

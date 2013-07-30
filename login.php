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
	// Start a new session
	session_start();

	/* Get database class from model/database.php */
	require_once('model/database.php');
	// Get database connection
	$db = database::getDB();

	if ( (!isset($_POST['email'])) || (!isset($_POST['password'])) ):
		$error = "Please enter valid data!";
		include ('logina.php');
	
	else:
		$email = $_POST['email'];
		$password  = $_POST['password'];
		$query = "SELECT emailAddress, password, userID  FROM users
				WHERE emailAddress = ? AND password = ?";
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $email);
		$stmt->bindValue(2, $password);
		$result = $stmt->execute();
		if ($result == false) {
			echo "<p>error</p>";
			exit();
		}
		
		$row = $stmt->fetch();
		$stmt->closeCursor();
		if ($row < 1) {
			$error = "Invalid email or password. Please try again!";
			include('logina.php');
		} else {
			//$user = $result->fetch_assoc();
			if ($password == $row['password']) {
				if (!isset($_SESSION['userid'])) {
					$_SESSION['userid'] = $row['userID'];
				}
				header('Location: .');
			}
		}
	
		endif;
?>	

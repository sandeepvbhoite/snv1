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
	/* Get database class from model/database.php */
	require_once('model/database.php');
	$db = database::getDB();
	if ( (!isset($_POST['email'])) || (!isset($_POST['password'])) ):
		$error = "Please enter valid data!";
		include ('logina.php');
	else:
	$email = $_POST['email'];
	$password  = $_POST['password'];
	$query = "SELECT emailAddress, password, userID  FROM users
			WHERE emailAddress = '$email' AND password = '$password'";
	$result = $db->query($query);
	if ($result == false) {
		echo "<p>error connecting db</p>";
		exit();
	}

	$row = $result->num_rows;
	if ($row < 1) {
		$error = "Wrong email, password combo! Please try again!";
		include('logina.php');
	} else {
		$user = $result->fetch_assoc();
		if ($password == $user['password']) {
			if (!isset($_SESSION['userid'])) {
				$_SESSION['userid'] = $user['userID'];
			}
			header('Location: .');
		}
	}

	endif;
?>	

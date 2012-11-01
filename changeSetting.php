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
	require_once ('model/database.php');
	require_once ('model/userInfo.php');
	if (!isset($_SESSION['userid'])) {
		include ('loginpage.php');
	} else {
		$userid = $_SESSION['userid'];
 		if (isset($_POST['old']) && isset($_POST['password']) && isset($_POST['password2'])) {
			$oldpass = $_POST['old'];
			$newpass = $_POST['password'];
			$newpass2 = $_POST['password2'];
			$currentpass = currentPassword($userid);
			if ($oldpass === $currentpass) {
				if ($newpass === $newpass2) {
					$success = changePassword($userid, $newpass);
				}
			}

			if ($success) {
				$msg =  "<p> Success! Your password has beed successfully changed!!! </p>";
			} else {
				$msg =  "<p> Oops! Something has gone wrong! Would you please try again? </p>";
			}

			include ("settings.php");
		}

	}
		
?>

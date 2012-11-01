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
		if ($_POST['edit'] == 'pedit') {

			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$city = $_POST['city'];
			$day  = $_POST['day'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$status = $_POST['status'];
			$education = $_POST['education'];
			$languages = $_POST['languages'];
			$birthday = $year . '-' . $month . '-' . $day;

			$success = updatePersonalInfo($userid, $fname, $lname, $city, $birthday, $status, $education, $languages);

			include ('info.php');
				
		} else if ($_POST['edit'] == 'cedit') {

			$city = $_POST['city'];
			$state = $_POST['state'];
			$country = $_POST['country'];
			$email = $_POST['email'];
			$web = $_POST['website'];
			$mobile = $_POST['mobile'];

			$success = updateContactInfo($userid, $city, $state, $country, $email, $web, $mobile);

			include ('info.php');
			
		} else {
			include ('info.php');
		}
	}
?>


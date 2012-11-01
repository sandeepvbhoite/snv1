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
	require_once ('model/friends.php');
	require_once ('model/pages.php');
	require_once ('model/posts.php');

	if (!isset($_SESSION['userid'])) {
		include ('loginpage.php');
	} else {	
		$userid = $_SESSION['userid'];
		if (isset($_POST['action'])) {
			$action = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$action = $_GET['action'];
		} else {
			$action = 'showprofile';
		}
		if ($action == 'showprofile') {
			if(isset($_GET['id'])) {
				$userid = $_GET['id'];
				$isFriend = isFriend($_SESSION['userid'], $userid);
			}
			include ('sidebar.php');
			include ('profileinfo.php');
			include ('showprofile.php');
		} else if ($action == 'like') {
			$postID = $_GET['postID'];
			$success = like($_SESSION['userid'], $postID);
			$tmp = 'Location: profile.php' . "#$postID";
			header($tmp);

		} else if ($action == 'unlike') {
			$postID = $_GET['postID'];
			$success = unlike($userid, $postID);
			$tmp = 'Location: profile.php' . "#$postID";
			header($tmp);


		} else if ($action == 'comment') {
			$comment = $_POST['comment'];
			$postID = $_POST['postID'];
			$success = commentOnPost($userid, $postID, $comment);
			$tmp = 'Location: profile.php' . "#$postID";
			header($tmp);
		} else if ($action == 'showinfo') {

			if (isset($_GET['id'])) {
				$userid = $_GET['id'];
			} else {
				$userid = $_SESSION['userid'];
			}
			include ('profileinfo.php');
			include ('userinfo.php');			
		} else if ($action == 'editpi') {
			$userid = $_SESSION['userid'];
			if (isset($_POST['fname'])) {
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
				header('Location: profile.php?action=showinfo');
			}
			$profile = getProfile($userid);
			$fname   = $profile['fname'];
			$lname   = $profile['lname'];
			$email   = $profile['emailAddress'];
			$birthday = $profile['birthday'];
			$education = $profile['education'];
			$status = $profile['status'];
			$languages = $profile['languages'];
			$city = $profile['city'];
			$year = substr($birthday, 0, 4);
			$month = substr($birthday, 5, 2);
			$day = substr($birthday, 8);
			include ('editpi.php');
	
		} else if ($action == 'editci') {
			$userid = $_SESSION['userid'];
			if (isset($_POST['email'])) {
				$city = $_POST['city'];
				$state = $_POST['state'];
				$country = $_POST['country'];
				$email = $_POST['email'];
				$web = $_POST['website'];
				$mobile = $_POST['mobile'];
				$success = updateContactInfo($userid, $city, $state, $country, $email, $web, $mobile);
				header('Location: profile.php?action=showinfo');
			} 
			$profile = getProfile($userid);
			$city = $profile['city'];
			$state = $profile['state'];
			$country = $profile['country'];
			$website = $profile['website'];
			$mobile = $profile['mobile'];
			$email = $profile['emailAddress'];
			include ('editci.php');
			
		} else if ($action == 'changepic'){
			$current_image = getCurrentProfilePic($userid);
			include ('changeimageform.php');
			
		} else if ($action == 'uploadpp') {
			if (isset($_FILES['pic'])) {
				$tmp_name = $_FILES['pic']['tmp_name'];
				$path = 'images/';
				$original_name = $_FILES['pic']['name'];
				$original_name = preg_replace('/\s+/', '', $original_name);
				$name = $_SESSION['userid'] . $original_name;
				$name = $path . $name;
				$success = move_uploaded_file($tmp_name, $name);
				if ($success) {
					$success = changeProfilePic($userid, $name);
					$current_image = getCurrentProfilePic($userid);
					$success = true;
					header ('Location: profile.php');
				} /*else {
					$success = false;
					$current_image = getCurrentProfilePic($userid);
					include ('changeimageform.php');
				} */
			}
		} else if ($action == 'deletepic') {
			$success = removeProfilePic($userid);
			header ('Location: profile.php');
		} else {

		}
	}
?>




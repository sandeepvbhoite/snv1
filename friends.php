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
	require_once ('model/friends.php');
	require_once ('model/userInfo.php');

	if (!isset($_SESSION['userid'])) {
		include ('loginpage.php');
	} else {
		$userid  = $_SESSION['userid'];

		if (isset($_POST['action'])) {
			$action = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$action = $_GET['action'];
		} else {
			$action = 'showfriends';
		}

		if ($action == 'showfriends') {
			$id = $_GET['userid'];
			include ('fetchfriends.php');
			include ('friendslist.php');
		} else if ($action == 'accept')  {
			$id = $_GET['ofUserID'];
			$success = acceptRequest($userid, $id);
			$path = 'Location: friends.php?action=showfriends&userid=' . $_SESSION['userid'];
			header($path);

		} else if ($action == 'reject') {
			$id = $_GET['ofUserID'];
			$success = rejectRequest($userid, $id);
			$path = 'Location: friends.php?action=showfriends&userid=' . $_SESSION['userid'];
			header($path);

		} else if ($action == 'cancel') {
			$id = $_GET['toUserID'];
			$success = cancelRequest($userid, $id);
			$path = 'Location: friends.php?action=showfriends&userid=' . $_SESSION['userid'];
			header($path);

		} else if ($action == 'remove') {
			$id = $_GET['friendID'];
			$success = removeFriend($userid, $id);
			$path = 'Location: friends.php?action=showfriends&userid=' . $_SESSION['userid'];
			header($path);

		} else if ($action == 'add') {
			$isFriend = isFriend($_SESSION['userid'], $_GET['userid']);
			$isRequest = isFriendRequestPresent($_SESSION['userid'], $_GET['userid']);
			if (!$isFriend && !$isRequest):
				$success = sendFriendRequest($_SESSION['userid'], $_GET['userid']);	
			endif;
			$path = 'Location: friends.php?action=showfriends&userid=' . $_SESSION['userid'];
			header($path);
		

		} else {
			include ('fetchfriends.php');
			include ('friendslist.php');
		}

	}
?>




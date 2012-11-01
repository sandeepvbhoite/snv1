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

	$db = database::getDB();

	function getFriendList($userid) {
		global $db;
		$query = "SELECT friendID FROM friends
			WHERE userID = '$userid'";
		$result = $db->query($query);
		$totalFriends = $result->num_rows;
		$friendID = array();
		for ($i=0; $i<$totalFriends; $i++) {
			$row = $result->fetch_assoc();
			$friendID[] = $row['friendID'];
		}
		$result->free();
		return $friendID;
	}

	function sendFriendRequest($sendBy, $sendTo) {
			global $db;
		$query = "INSERT INTO friend_requests
			(fromUserID, toUserID)
			VALUES 
			('$sendBy', '$sendTo')";
		$success = $db->query($query);
		return $success;
	}

	function getReceivedRequests($userid) {
		global $db;
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = '$userid'";
		$success = $db->query($query);
		$requestsReceived = array();
		$total = $success->num_rows;
		for($i=0; $i<$total; $i++) {
			$row = $success->fetch_assoc();
			$requestsReceived[] = $row['fromUserID'];
		}
		$success->free();
		return $requestsReceived;
	}

	function getSentRequests($userid) {
		global $db;
		$query = "SELECT toUserID from friend_requests
				WHERE fromUserID = '$userid'";
		$success = $db->query($query);
		$requestsSent = array();
		$total = $success->num_rows;
		for($i=0; $i<$total; $i++) {
			$row = $success->fetch_assoc();
			$requestsSent[] = $row['toUserID'];
		}
		$success->free();
		return $requestsSent;

	}

	function acceptRequest($userid, $ofUserID) {
		global $db;
		/* let's first check, if there's really such a request! */
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = '$userid' AND fromUserID = '$ofUserID'";
		$success = $db->query($query);
		if ($success->num_rows > 0) {
			$query = "DELETE FROM friend_requests
					WHERE toUserID = '$userid' AND fromUserID = '$ofUserID'";
			$s = $db->query($query);
			$query = "INSERT INTO friends
					(userID, friendID)
					VALUES
					('$userid', '$ofUserID')";
			$s = $db->query($query);
			$query = "INSERT INTO friends
					(userID, friendID)
					VALUES
					('$ofUserID', '$userid')";
			$s = $db->query($query);
		}

	}

	function rejectRequest($userid, $ofUserID) {
		global $db;
		/* let's first check, if there's really such a request! */
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = '$userid' AND fromUserID = '$ofUserID'";
		$success = $db->query($query);
		if ($success->num_rows > 0) {
			$query = "DELETE FROM friend_requests
					WHERE toUserID = '$userid' AND fromUserID = '$ofUserID'";
			$s = $db->query($query);
			
		}
	}

	function cancelRequest($userid, $toUserID) {
		global $db;
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = '$toUserID' AND fromUserID = '$userid'";
		$success = $db->query($query);
		if ($success->num_rows > 0) {
			$query = "DELETE FROM friend_requests
					WHERE toUserID = '$toUserID' AND fromUserID = '$userid'";
			$s = $db->query($query);
		}
	}

	function removeFriend($userid, $friendID) {
		global $db;
		$query = "DELETE FROM friends
				WHERE 
				(userID = '$userid' AND friendID = '$friendID') OR 
				(userID = '$friendID' AND friendID = '$userid')";
		$success = $db->query($query);
		return $success;	
	}
	
	function isFriendRequestPresent($userid, $toUserID) {
		global $db;
		$query = "SELECT COUNT(*) as total FROM friend_requests
			WHERE fromUserID = '$userid' AND toUserID = '$toUserID'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$total = $row['total'];
		$success->free();
		if ($total > 0) {
			return true;
		} else {
			return false;
		}
	}

	function isFriend($userid, $ofuserid) {
		global $db;
		$query = "SELECT COUNT(*) AS total FROM friends
				WHERE (userID = '$userid' AND friendID = '$ofuserid') OR
					(userID = '$ofuserid' AND friendID = '$userid')";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$isFriend = $row['total'];
		$success->free();
		if ($isFriend > 0) {
			return true;
		} else {
			return false;
		}
	}
?>

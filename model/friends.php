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
			WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($friendID);
		$stmt->execute();
		// Array to store all of the friend IDs
		$friendIDs = array();
		// Fetch all available friends
		while ($stmt->fetch()) {
			$friendIDs[] = $friendID;
		}
		$stmt->close();
		return $friendIDs;
	}

	function sendFriendRequest($sendBy, $sendTo) {
		global $db;
		
		$query = "INSERT INTO friend_requests
			(fromUserID, toUserID)
			VALUES 
			(?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii", $sendBy, $sendTo);
		$success = $stmt->execute();
		$stmt->close();
		return $success;
	}

	function getReceivedRequests($userid) {
		global $db;
		
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($fromUserID);
		$success = $stmt->execute();
		// Array to store received friend requests
		$requestsReceived = array();
		
		while ($stmt->fetch()) {
			$requestsReceived[] = $fromUserID;
		}
		$stmt->close();
		return $requestsReceived;
	}

	function getSentRequests($userid) {

		global $db;

		$query = "SELECT toUserID from friend_requests
				WHERE fromUserID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($toUserID);
		$success = $stmt->execute();
		$requestsSent = array();
		
		while ($stmt->fetch()) {
			$requestsSent[] = $toUserID;
		}
		$stmt->close();
		return $requestsSent;
	}

	function acceptRequest($userid, $ofUserID) {
		
		global $db;

		/* let's first check, if there's really such a request! */
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = ? AND fromUserID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("ii", $userid, $ofUserID);
		$stmt->bind_result($fromUID);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();

		// If There exist any request, then $fromUID must contain some value
		if ($fromUID) {
			
			/* Now that we know there is such a request, and user wants to
			 * accept it, then we remove this request from friend_requests
			 * and add this `new friend' to the friends table
			 */
			$query = "DELETE FROM friend_requests
					WHERE toUserID = ? AND fromUserID = ?";

			$stmt = $db->prepare($query);
			$stmt->bind_param("ii",$userid, $ofUserID);
			$stmt->execute();
			$stmt->close(); 

			$query = "INSERT INTO friends
					(userID, friendID)
					VALUES
					(?, ?)";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ii", $userid, $ofUserID);
			$stmt->execute();
			$stmt->close();

			$query = "INSERT INTO friends
					(userID, friendID)
					VALUES
					(?, ?)";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ii", $ofUserID, $userid);
			$stmt->execute();
			$stmt->close();
		}

	}

	function rejectRequest($userid, $ofUserID) {
		
		global $db;
		
		/* let's first check, if there's really such a request! */
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = ? AND fromUserID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii", $userid, $ofUserID);
		$stmt->bind_result($fromUID);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();

		/* now, if there exists such a request, then $fromUID will have
		 * some value.
		 */
		if ($fromUID) {

			// Remove such a friend request entry from friend_requests table
			$query = "DELETE FROM friend_requests
					WHERE toUserID = ? AND fromUserID = ?";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ii", $userid, $ofUserID);
			$stmt->execute();
			$stmt->close();
		}
	}

	/*
	 * Function to cancel already sent request
	 */
	function cancelRequest($userid, $toUserID) {
	
		global $db;
		
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = ? AND fromUserID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii", $toUserID, $userid);
		$stmt->bind_result($fromUID);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();

		// If $fromUID is true..
		if ($fromUID) {

			$query = "DELETE FROM friend_requests
					WHERE toUserID = ? AND fromUserID = ?";
			
			$stmt = $db->prepare($query);
			$stmt->bind_param("ii", $toUserID, $userid);
			$stmt->execute();
			$stmt->close();
		}
	}

	function removeFriend($userid, $friendID) {	
		global $db;
		
		$query = "DELETE FROM friends
				WHERE 
				(userID = ? AND friendID = ?) OR 
				(userID = ? AND friendID = ?)";

		$stmt = $db->prepare($query);
		$stmt->bind_param("iiii", $userid, $friendID, $friendID, $userid);
		$success = $stmt->execute();
		return $success;	
	}
	
	function isFriendRequestPresent($userid, $toUserID) {
		global $db;

		$query = "SELECT COUNT(*) as total FROM friend_requests
			WHERE fromUserID = ? AND toUserID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii", $userid, $toUserID);
		$stmt->bind_result($total);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();

		if ($total > 0) {
			return true;
		} else {
			return false;
		}
	}

	function isFriend($userid, $ofuserid) {
		global $db;
		
		$query = "SELECT COUNT(*) AS total FROM friends
				WHERE (userID = ? AND friendID = ?) OR
					(userID = ? AND friendID = ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("iiii", $userid, $ofuserid, $ofuserid, $userid);
		$stmt->bind_result($total);
		$stmt->execute();
		$stmt->close();

		if ($isFriend > 0) {
			return true;
		} else {
			return false;
		}
	}
?>

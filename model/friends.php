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
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		$row = $stmt->fetch();
		// Array to store all of the friend IDs
		$friendIDs = array();
		// Fetch all available friends
		while ($row != null) {
			$friendID = $row['friendID'];
			$friendIDs[] = $friendID;
			$row = $stmt->fetch();
		}
		$stmt->closeCursor();
		return $friendIDs;
	}

	function sendFriendRequest($sendBy, $sendTo) {
		global $db;
		
		$query = "INSERT INTO friend_requests
			(fromUserID, toUserID)
			VALUES 
			(?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $sendBy);
		$stmt->bindValue(2, $sendTo);
		$success = $stmt->execute();
		$stmt->closeCursor();
		return $success;
	}

	function getReceivedRequests($userid) {
		global $db;
		
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$success = $stmt->execute();
		$row = $stmt->fetch();
		// Array to store received friend requests
		$requestsReceived = array();
		
		while ($row != null) {
			$requestsReceived[] = $fromUserID;
			$row = $stmt->fetch();
		}
		$stmt->closeCursor();
		return $requestsReceived;
	}

	function getSentRequests($userid) {

		global $db;

		$query = "SELECT toUserID from friend_requests
				WHERE fromUserID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$success = $stmt->execute();
		$row = $stmt->fetch();
		$requestsSent = array();
		
		while ($row != null) {
			$requestsSent[] = $toUserID;
			$row = $stmt->fetch();
		}
		$stmt->closeCursor();
		return $requestsSent;
	}

	function acceptRequest($userid, $ofUserID) {
		
		global $db;

		/* let's first check, if there's really such a request! */
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = ? AND fromUserID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("ii", $userid, $ofUserID);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $ofUserID);
		$stmt->execute();
		$row = $stmt->fetch();
		$fromUID = $row['fromUserID'];
		$stmt->closeCursor();

		// If There exist any request, then $fromUID must contain some value
		if ($fromUID) {
			
			/* Now that we know there is such a request, and user wants to
			 * accept it, then we remove this request from friend_requests
			 * and add this `new friend' to the friends table
			 */
			$query = "DELETE FROM friend_requests
					WHERE toUserID = ? AND fromUserID = ?";

			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $ofUserID);
			$stmt->execute();
			$stmt->closeCursor(); 

			$query = "INSERT INTO friends
					(userID, friendID)
					VALUES
					(?, ?)";
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $ofUserID);
			$stmt->execute();
			$stmt->closeCursor();

			$query = "INSERT INTO friends
					(userID, friendID)
					VALUES
					(?, ?)";
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $ofUserID);
			$stmt->bindValue(2, $userid);
			$stmt->execute();
			$stmt->closeCursor();
		}

	}

	function rejectRequest($userid, $ofUserID) {
		
		global $db;
		
		/* let's first check, if there's really such a request! */
		$query = "SELECT fromUserID from friend_requests
				WHERE toUserID = ? AND fromUserID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $ofUserID);
		$stmt->execute();
		$row = $stmt->fetch();
		$fromUID = $row['fromUserID'];
		$stmt->closeCursor();

		/* now, if there exists such a request, then $fromUID will have
		 * some value.
		 */
		if ($fromUID) {

			// Remove such a friend request entry from friend_requests table
			$query = "DELETE FROM friend_requests
					WHERE toUserID = ? AND fromUserID = ?";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $ofUserID);
			$stmt->execute();
			$stmt->closeCursor();
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
		$stmt->bindValue(1, $toUserID);
		$stmt->bindValue(2, $userid);
		$stmt->execute();
		$row = $stmt->fetch();
		$fromUID = $row['fromUserID'];
		$stmt->closeCursor();

		// If $fromUID is true..
		if ($fromUID) {

			$query = "DELETE FROM friend_requests
					WHERE toUserID = ? AND fromUserID = ?";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $toUserID);
			$stmt->bindValue(2, $userid);
			$stmt->execute();
			$stmt->closeCursor();
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
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $friendID);
		$stmt->bindValue(3, $friendID);
		$stmt->bindValue(4, $userid);
		$success = $stmt->execute();
		$stmt->closeCursor;
		return $success;	
	}
	
	function isFriendRequestPresent($userid, $toUserID) {
		global $db;

		$query = "SELECT COUNT(*) as total FROM friend_requests
			WHERE fromUserID = ? AND toUserID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $toUserID);
		$stmt->execute();
		$row = $stmt->fetch();
		$total = $row['total'];
		$stmt->closeCursor();

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
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $ofuserid);
		$stmt->bindValue(3, $ofuserid);
		$stmt->bindValue(4, $userid);

		$stmt->execute();
		$row = $stmt->fetch();
		$isFriend = $row['total'];
		$stmt->closeCursor();

		if ($isFriend > 0) {
			return true;
		} else {
			return false;
		}
	}
?>

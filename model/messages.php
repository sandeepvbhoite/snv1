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
	// Get database connection
	$db = database::getDB();

	function getDialogueList ($userid) {
		global $db;
		/*
		 * NEED A BETTER QUERY HERE
		 */
		$query = "SELECT * FROM message_records
				INNER JOIN messages
				ON message_records.convID = messages.convID
				WHERE user1ID = ? OR user2ID = ?
				ORDER BY onTime";

		$stmt = $db->prepare($query);
		$stmt->bind_param("ii", $userid, $userid);
		$stmt->bind_result($convID, $foo1, $foo2, $foo3, $foo8, $foo4, $foo5,
				$foo6, $foo7);
		$stmt->execute();

		/* Now grab the convIDs from database,
		   Make an array of unique convIDs, 
		   and return them
		*/

		//$totalDialogues = $success->num_rows;
		$convIDs = array();
		while ($stmt->fetch()) {
			
			if (!in_array($convID, $convIDs)) {
				$convIDs[] = $convID;
			}
		}
		$stmt->close();
		return $convIDs;
	}
	
	function getLastMessageWithUser ($userid, $convID) {
		
		global $db;
		
		$query = "SELECT * FROM messages
				WHERE convID = ?
				ORDER BY onTime DESC
				LIMIT 1";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $convID);
		$stmt->bind_result($messageID, $convID, $senderID,
				$receiverID, $msgText, $onTime);
		$stmt->execute();
		$row = $stmt->fetch();
		
		if (!$messageID) {
			echo "<p>Something has gone wrong</p>";
			exit();
		}
		
		$lastMessageWithUser = array();
		$lastMessageWithUser['message'] = $msgText;
		if ($userid != $sender) {
			$lastMessageWithUser['user'] = $senderID;
		} else {
			$lastMessageWithUser['user'] = $receiverID;
		}
		$lastMessageWithUser['timeOn'] = $onTime;
		$stmt->close();
		
		return $lastMessageWithUser;
	}

	function getMessages ($convID) {
		
		global $db;
		
		$query = "SELECT senderID, receiverID, msgText, onTime
				FROM messages
				WHERE convID = ?
				ORDER BY onTime DESC
				LIMIT 6";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $convID);
		$stmt->bind_result($senderID, $receiverID, $msgText, $onTime);
		$stmt->execute();
		$messages = array();
		$message = array(); // Single message
		$stmt->store_result();
		while ($stmt->fetch()) {	
			
			$message['senderID'] = $senderID;
			/* can't run two queries simultaneously using MYSQi,
			 * so, iterate over this array again to get names */
			$message['senderName'] = getUserName($senderID);
			$message['receiverID'] = $receiverID;
			$message['receiverName'] = getUserName($receiverID);
			$message['msgText'] = $msgText;
			$message['onTime'] = $onTime;
			$messages[] = $message;
		}
		

		$stmt->close();
		return $messages;
	}

	function sendMessage ($convID, $userid, $receiverID, $msg) {
		
		global $db;
		$msg = $db->real_escape_string($msg);
		
		$query = "INSERT INTO messages
				(convID, senderID, receiverID, msgText)
				VALUES
				(?, ?, ?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bind_param("iiis", $convID, $userid, $receiverID, $msg);
		$success = $stmt->execute();
		return $success;
	}


	function sendFirstMessage($userid, $toUserID, $msg) {
		
		global $db;
		
		/* First check if there is already two user's pair in message_records */
		$msg = $db->real_escape_string($msg);
		$query = "SELECT COUNT(*) AS total FROM message_records
				WHERE
				(user1ID = ? AND user2ID = ?)
				OR
				(user1ID = ? AND user2ID = ?)";

		$stmt = $db->prepare($query);
		$stmt->bind_param("iiii", $userid, $toUserID, $toUserID, $userid);
		$stmt->bind_result($total);
		$stmt->execute();
		//$result = $db->query($query);
		//$result = $result->fetch_assoc();
		$stmt->fetch();
		$stmt->close();

		if( $total < 1 ) {
			
			/* Now that there does not exist this pair, let's create it, 
			   and store the first message */
			/* First, create new convID */
			$query = "INSERT INTO message_records
					(user1ID, user2ID)
					VALUES
					(?, ?)";
			
			$stmt = $db->prepare($query);
			$stmt->bind_param("ii", $userid, $toUserID);
			$stmt->execute();
			$stmt->close();
			
			/* We will need this newly created convID to store message 
			   in messages table */
			$query = "SELECT * FROM message_records
					WHERE 
					(user1ID = ? AND user2ID = ?)
					OR
					(user1ID = ? AND user2ID = ?)";

			$stmt = $db->prepare($query);
			$stmt->bind_param("iiii", $userid, $toUserID, $toUserID, $userid);
			$stmt->bind_result($convID, $user1ID, $user2ID);
			$stmt->execute();
			// Fetch results
			$stmt->fetch();
			$stmt->close();
			/* The query to store the message */
			$query = "INSERT INTO messages
					(convID, senderID, receiverID, msgText)
					VALUES
					(?, ?, ?, ?)";

			$stmt = $db->prepare($query);
			$stmt->bind_param("iiis", $convID, $userid, $toUserID, $msg);
			$success = $stmt->execute();
			$stmt->close();
			return $success;
		
		} else {
			
			/* If the pair already exists, we just need to store the message */
			$query = "SELECT * FROM message_records
				WHERE 
				(user1ID = ? AND user2ID = ?)
				OR
				(user1ID = ? AND user2ID = ?)";

			$stmt = $db->prepare($query);
			$stmt->bind_param("iiii", $userid, $toUserID, $toUserID, $userid);
			$stmt->bind_result($convID, $user1ID, $user2ID);
			$stmt->execute();
			$stmt->fetch();
			$stmt->close();

			/* The query to store the message */
			$query = "INSERT INTO messages
					(convID, senderID, receiverID, msgText)
					VALUES
					(?, ?, ?, ?)";

			$stmt = $db->prepare($query);
			$stmt->bind_param("iiis", $convID, $userid, $toUserID, $msg);
			$success = $stmt->execute();
			$stmt->close();
			return $success;
	
		}

	}

?>

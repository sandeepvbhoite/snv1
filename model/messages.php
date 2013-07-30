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
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $userid);
		$stmt->execute();

		/* Now grab the convIDs from database,
		   Make an array of unique convIDs, 
		   and return them
		*/
		$row = $stmt->fetch();
		$convIDs = array();
		
		while ($row != null) {
			$convID = $row['convID'];	
			if (!in_array($convID, $convIDs)) {
				$convIDs[] = $convID;
			}
			$row = $stmt->fetch();
		}
		$stmt->closeCursor();
		return $convIDs;
	}
	
	function getLastMessageWithUser ($userid, $convID) {
		
		global $db;
		
		$query = "SELECT * FROM messages
				WHERE convID = ?
				ORDER BY onTime DESC
				LIMIT 1";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $convID);
		$stmt->execute();
		$row = $stmt->fetch();
		
		$messageID = $row['messageID'];

		if (!$messageID) {
			echo "<p>Something has gone wrong</p>";
			exit();
		}
		
		$lastMessageWithUser = array();
		$lastMessageWithUser['message'] = $row['msgText'];

		if ($userid != $sender) {
			$lastMessageWithUser['user'] = $row['senderID'];
		} else {
			$lastMessageWithUser['user'] = $row['receiverID'];
		}

		$lastMessageWithUser['timeOn'] = $row['onTime'];
		$stmt->closeCursor();
		
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
		$stmt->bindValue(1, $convID);
		$stmt->execute();

		$messages = array();
		$message = array(); // Single message
		// Get first row	
		$row = $stmt->fetch();
		while ($row != null) {	
			
			$message['senderID'] = $row['senderID'];
			$message['senderName'] = getUserName($row['senderID']);
			$message['receiverID'] = $row['receiverID'];
			$message['receiverName'] = getUserName($row['receiverID']);
			$message['msgText'] = $row['msgText'];
			$message['onTime'] = $row['onTime'];
			$messages[] = $message;
			$row = $stmt->fetch();
		}
		

		$stmt->closeCursor();
		return $messages;
	}

	function sendMessage ($convID, $userid, $receiverID, $msg) {
		
		global $db;
		$msg = strip_tags($msg);
		
		$query = "INSERT INTO messages
				(convID, senderID, receiverID, msgText)
				VALUES
				(?, ?, ?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $convID);
		$stmt->bindValue(2, $userid);
		$stmt->bindValue(3, $receiverID);
		$stmt->bindValue(4, $msg);
		$success = $stmt->execute();
		return $success;
	}


	function sendFirstMessage($userid, $toUserID, $msg) {
		
		global $db;
		
		/* First check if there is already two user's pair in message_records */
		$msg = strip_tags($msg);
		$query = "SELECT COUNT(*) AS total FROM message_records
				WHERE
				(user1ID = ? AND user2ID = ?)
				OR
				(user1ID = ? AND user2ID = ?)";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $toUserID);
		$stmt->bindValue(3, $toUserID);
		$stmt->bindValue(4, $userid);
		$stmt->execute();
		$row = $stmt->fetch();
		$total = $row['total'];
		$stmt->closeCursor();

		if( $total < 1 ) {	
			/* Now that there does not exist this pair, let's create it, 
			   and store the first message */
			/* First, create new convID */
			$query = "INSERT INTO message_records
					(user1ID, user2ID)
					VALUES
					(?, ?)";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $toUserID);
			$stmt->execute();
			$stmt->closeCursor();
			
			/* We will need this newly created convID to store message 
			   in messages table */
			$query = "SELECT * FROM message_records
					WHERE 
					(user1ID = ? AND user2ID = ?)
					OR
					(user1ID = ? AND user2ID = ?)";

			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $toUserID);
			$stmt->bindValue(3, $toUserID);
			$stmt->bindValue(4, $userid);

			$stmt->execute();
			// Fetch results
			$row = $stmt->fetch();
			$convID = $row['convID'];
			$user1ID = $row['user1ID'];
			$user2ID = $row['user2ID'];
			$stmt->closeCursor();
			/* The query to store the message */
			$query = "INSERT INTO messages
					(convID, senderID, receiverID, msgText)
					VALUES
					(?, ?, ?, ?)";

			$stmt = $db->prepare($query);
			$stmt->bindParam(1, $convID);
			$stmt->bindParam(2, $userid);
			$stmt->bindParam(3, $toUserID);
			$stmt->bindParam(4, $msg);
			$success = $stmt->execute();
			$stmt->closeCursor();
			return $success;
		
		} else {
			
			/* If the pair already exists, we just need to store the message */
			$query = "SELECT * FROM message_records
				WHERE 
				(user1ID = ? AND user2ID = ?)
				OR
				(user1ID = ? AND user2ID = ?)";

			$stmt = $db->prepare($query);
			
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $toUserID);
			$stmt->bindValue(3, $toUserID);
			$stmt->bindValue(4, $userid);

			$stmt->execute();
			$row = $stmt->fetch();
			$convID = $row['convID'];
			$user1ID = $row['user1ID'];
			$user2ID = $row['user2ID'];

			$stmt->closeCursor();

			/* The query to store the message */
			$query = "INSERT INTO messages
					(convID, senderID, receiverID, msgText)
					VALUES
					(?, ?, ?, ?)";

			$stmt = $db->prepare($query);
			// Bind Values
			$stmt->bindValue(1, $convID);
			$stmt->bindValue(2, $userid);
			$stmt->bindValue(3, $toUserID);
			$stmt->bindValue(4, $msg);
			// Execute statement
			$success = $stmt->execute();
			$stmt->closeCursor();
			return $success;
	
		}

	}

?>

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
	$db = database::getDB();
	function getDialogueList ($userid) {
		global $db;
		$query = "SELECT * FROM message_records
				INNER JOIN messages
				ON message_records.convID = messages.convID
				WHERE user1ID = '$userid' OR user2ID = '$userid'
				ORDER BY onTime";
		$success = $db->query($query);

		/* Now grab the conIDs from database,
		   Make an array of unique convIDs, 
		   and return them
		*/

		$totalDialogues = $success->num_rows;
		$convIDs = array();
		for ($i=0; $i<$totalDialogues; $i++) {
			$row = $success->fetch_assoc();
			$convID = $row['convID'];
			if (!in_array($convID, $convIDs)) {
				$convIDs[] = $convID;
			}
		}
		$success->free();
		return $convIDs;

	}
	
	function getLastMessageWithUser ($userid, $convID) {
		global $db;
		$query = "SELECT * FROM messages
				WHERE convID = '$convID'
				ORDER BY onTime DESC
				LIMIT 1";
		$success = $db->query($query);
		if ($success->num_rows > 1) {
			echo "<p>Something has gone wrong</p>";
			exit();
		}
		$row = $success->fetch_assoc();
		$message = $row['msgText'];
		$sender  = $row['senderID'];
		$receiver = $row['receiverID'];
		$timeOn = $row['onTime'];
		$lastMessageWithUser = array();
		$lastMessageWithUser['message'] = $row['msgText'];
		if ($userid != $sender) {
			$lastMessageWithUser['user'] = $sender;
		} else {
			$lastMessageWithUser['user'] = $receiver;
		}
		$lastMessageWithUser['timeOn'] = $timeOn;
		$success->free();
		return $lastMessageWithUser;
	}

	function getMessages ($convID) {
		global $db;
		$query = "SELECT senderID, receiverID, msgText, onTime
				FROM messages
				WHERE convID = '$convID'
				ORDER BY onTime DESC
				LIMIT 6";
		$success = $db->query($query);
		$total   = $success->num_rows;
		$messages = array();
		for ($i=0; $i<$total; $i++) {
			$row = $success->fetch_assoc();
			$messages[$i] = array();
			$messages[$i]['senderID'] = $row['senderID'];
			$messages[$i]['senderName'] = getUserName($row['senderID']);
			$messages[$i]['receiverID'] = $row['receiverID'];
			$messages[$i]['receiverName'] = getUserName($row['receiverID']);
			$messages[$i]['msgText'] = $row['msgText'];
			$messages[$i]['onTime'] = $row['onTime'];
		}
		$success->free();
		return $messages;
	}

	function sendMessage ($convID, $userid, $receiverID, $msg) {
		global $db;
		$msg = $db->real_escape_string($msg);
		$query = "INSERT INTO messages
				(convID, senderID, receiverID, msgText)
				VALUES
				('$convID', '$userid', '$receiverID', '$msg')";
		$success = $db->query($query);
		return $success;
	}


	function sendFirstMessage($userid, $toUserID, $msg) {
		global $db;
		/* First check if there is already two user's pair in message_records */
		$msg = $db->real_escape_string($msg);
		$query = "SELECT COUNT(*) AS total FROM message_records
				WHERE
				(user1ID = '$userid' AND user2ID = '$toUserID')
				OR
				(user1ID = '$toUserID' AND user2ID = '$userid')";
		$result = $db->query($query);
		$result = $result->fetch_assoc();
		if( $result['total'] < 1 ) {
		/* Now that there does not exist this pair, let's create it, and store the first message */
		/* First, create new convID */
			$query = "INSERT INTO message_records
					(user1ID, user2ID)
					VALUES
					('$userid', '$toUserID')";
			$success = $db->query($query);
		/* We will need this newly created convID to store message in messages table */
			$query = "SELECT * FROM message_records
					WHERE 
					(user1ID = '$userid' AND user2ID = '$toUserID')
					OR
					(user1ID = '$toUserID' AND user2ID = '$userid')";
			$success = $db->query($query);
			$row = $success->fetch_assoc();
		/* Here is the convID */
			$convID = $row['convID'];
		/* The query to store the message */
			$query = "INSERT INTO messages
					(convID, senderID, receiverID, msgText)
					VALUES
					('$convID', '$userid', '$toUserID', '$msg')";
			$success = $db->query($query);
			return $convID;
		} else {
		/* If the pair already exists, we just need to store the message */
			$query = "SELECT * FROM message_records
				WHERE 
				(user1ID = '$userid' AND user2ID = '$toUserID')
				OR
				(user1ID = '$toUserID' AND user2ID = '$userid')";
			$success = $db->query($query);
			$row = $success->fetch_assoc();
		/* Here is the convID */
			$convID = $row['convID'];
		/* The query to store the message */
			$query = "INSERT INTO messages
					(convID, senderID, receiverID, msgText)
					VALUES
					('$convID', '$userid', '$toUserID', '$msg')";
			$success = $db->query($query);
			return $convID;
	
		}

	}

?>
	

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
	/* Starting session here */
	session_start();

	require_once ('model/database.php');
	require_once ('model/friends.php');
	require_once ('model/messages.php');
	require_once ('model/userInfo.php');

	if (!isset($_SESSION['userid'])) {
		include ('loginpage.php');
	} else {
		$userid = $_SESSION['userid'];
		if (isset($_POST['action'])) {
			$action = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$action = $_GET['action'];
		} else {
			$action = 'inbox';
		}

		if ($action == 'inbox') {
			$userid  = $_SESSION['userid'];
			/* Get the convIDs of the dialogues from dB */
			$convIDs = getDialogueList ($userid);
			/* Create a conversations array to store all stuff
			   that we want to show on this page */
			$conversations = array();
			/* Count the total conversations user had */
			$totalConversations = count($convIDs);

			/* Also store the number of conversations user had, to process them 
				further on this page 
			*/
	
			/* Now create the associative array with all the details */

			for ($i=0; $i<$totalConversations; $i++) {
				$convID = $convIDs[$i];
				$lastMessageWithUser = getLastMessageWithUser($userid, $convID);
				$user = $lastMessageWithUser['user'];
				$userName = getUserName($user);
				$lastMessageWithUser['fname'] = $userName['fname'];
				$lastMessageWithUser['lname'] = $userName['lname'];
				$conversations[$convID] = array();
				$conversations[$convID]['message'] = $lastMessageWithUser['message'];
				$conversations[$convID]['fname']   = $lastMessageWithUser['fname'];
				$conversations[$convID]['lname']   = $lastMessageWithUser['lname'];
				$conversations[$convID]['userID']  = $user;
				$conversations[$convID]['timeOn']  = $lastMessageWithUser['timeOn'];
			}
			include ('inbox.php');
		} else if ($action == 'showdialogue') {

			if(isset($_GET['convID'])) {
				$convID = $_GET['convID'];
			} else {
				header ('Location: inbox.php');
			}
			$messages = getMessages($convID);
			$user1    = $messages[0]['senderID'];
			$user2    = $messages[0]['receiverID'];
			/* Code to see who is going to receive next sent message */
			if ($user1 == $userid) {

				/* If sender is the logged in user, then receiver is the user sitting 
					at the other end of the connection
				*/
				$recID = $user2;
				/* recID is the receivers (receiver for the next message) userID */

			} else {
				$recID = $user1;
			}

			include ('dialogue.php');

		} else if ($action == 'send') {
			$receiverID = $_POST['receiverID'];
			$msg = $_POST['msg'];
			$convID = $_POST['convID'];
			$success = sendMessage ($convID, $_SESSION['userid'], $receiverID, $msg);

			$url = "Location: " . "messages.php" . "?action=showdialogue&convID=" . $convID;
			header ($url);
		} else if ($action == 'sendfirst') {
			
				if (!isset($_POST['msg'])) {
					$toUserID = $_GET['userid'];
					include ('firstdialogue.php');
				} else {
					$toUserID = $_POST['toUserID'];
					$msg = $_POST['msg'];
					$convID = sendFirstMessage($_SESSION['userid'], $toUserID, $msg);
			$messages = getMessages($convID);
			$user1    = $messages[0]['senderID'];
			$user2    = $messages[0]['receiverID'];
			/* Code to see who is going to receive next sent message */
			if ($user1 == $userid) {

			/* If sender is the logged in user, then receiver is the user sitting 
				at the other end of the connection
			*/
				$recID = $user2;
			/* recID is the receivers (receiver for the next message) userID */
			}

					include ('dialogue.php');
				}


		} else {
			include ('inbox.php');
		}
	}
?> 


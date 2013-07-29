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

	function getComments($postID) {
		
		global $db;
		
		$query = "SELECT userID, postID, commentText, timeOn FROM comments
				WHERE postID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $postID);
		$stmt->bind_result($userID, $postID, $commentText, $timeOn);
		$stmt->execute();
		$stmt->store_result();

		// Array to Store *number* of comments
		$comments = array();
		// Array to store a single comment temporarily
		$comment = array();
		while ($stmt->fetch()) {

			$comment['userID'] = $userID;
			$comment['commentername'] = getUserName($userID);
			$comment['postID'] = $postID;
			$comment['comment'] = $commentText;
			$comment['timeOn'] = $timeOn;
			// Now store this single comment in `comments` array.
			$comments[] = $comment;
		}	
		$stmt->close();
		return $comments;
	}

	function getLikes($postID) {
		
		global $db;
		$query = "SELECT COUNT(*) AS totallikes
				FROM likes
				WHERE postID = ?";

		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $postID);
		$stmt->bind_result($totalLikes);
		$stmt->execute();
		$stmt->fetch();
		// Close stmt 
		$stmt->close();
		// Return total number of likes to the postID
		return $total;
	}

/*
	function getPosts($userid, $friends) {
		
		global $db;
		$totalFriends = count($friends);
		$firstFriend  = $userid;
		
		$query = "SELECT * FROM posts
				WHERE userID = '$firstFriend'";

		for ($i=0; $i<$totalFriends; $i++) {
			$currentFriend = $friends[$i];
			$query = $query . " OR userID = '$currentFriend'";
		}
		
		$query = $query . " ORDER BY timeOn DESC";
		$result = $db->query($query);
		$total = $result->num_rows;
		$posts = array();
		for ($i=0; $i<$total; $i++) {
			$row = $result->fetch_assoc();
			$posts[$i] = array();
			$posts[$i]['postID'] = $row['postID'];
			$posts[$i]['userID'] = $row['userID'];
			$posts[$i]['postername'] = getUserName($row['userID']);
			$posts[$i]['posterpic'] = getCurrentProfilePic($row['userID']);
			$posts[$i]['postText'] = $row['postText'];
			$posts[$i]['ifImage'] = $row['ifImage'];
			$posts[$i]['timeOn'] = $row['timeOn'];
			$posts[$i]['likes'] = getLikes($row['postID']);

		}
		$result->free();
		return $posts;
	}
*/

	function getPosts($userid, $friends) {
		
		global $db;
		$friends[] = $userid;
		$totalFriends = count($friends);
		$query = "SELECT * FROM posts
				WHERE userID in (%s) ORDER BY timeOn DESC";
		$inclause = implode(',', array_fill(0, $totalFriends, '?')); // to fill (?)s in SQL
		$paramtype = implode('', array_fill(0, $totalFriends, 'i')); // no. of ii's

		// Let's build parameters to bind_param
		$bind_param_params = array();
		$bind_param_params[] = $paramtype;
		for($i=0; $i<$totalFriends; $i++) {
			$bind_param_params[] = $friends[$i];
		}

		$prepareQuery = sprintf($query, $inclause);
		$stmt = $db->prepare($prepareQuery);
		//$stmt->bind_param
		call_user_func_array (array($stmt, "bind_param"), $bind_param_params);
		$stmt->execute();
		$stmt->bind_result($postID, $userID, $postText, $ifImage, $timeOn);
		$stmt->store_results();
		$posts = array();
		$post = array();

		while ($stmt->fetch()) {
			$post['postID'] = $postID;
			$post['userID'] = $userID;
			$post['postername'] = getUserName($userID);
			$post['posterpic'] = getCurrentProfilePic($userID);
			$post['postText'] = $postText;
			$post['ifImage'] = $ifImage;
			$post['timeOn'] = $timeOn;
			$post['likes'] = getLikes($postID);

			$posts[] = $post;
		}
		$stmt->close();
		return $posts;
	}

	function postNew($userid, $post) {
		global $db;
		$post = $db->real_escape_string($post);
		$query = "INSERT INTO posts
				(userID, postText)
				VALUES
				('$userid', '$post')";
		$success = $db->query($query);
		return $success;
	}

	function newImagePost($userid, $imagePath, $postText) {
		global $db;
		$postText = $db->real_escape_string($postText);
		$query = "INSERT INTO posts
				(userID, postText, ifImage)
				VALUES
				('$userid', '$postText', '$imagePath')";
		$success = $db->query($query);
		return $success;
	}

	function commentOnPost($userid, $postID, $comment) {
		global $db;
		$comment = $db->real_escape_string($comment);
		$query = "INSERT INTO comments
				(userID, postID, commentText)
				VALUES
				('$userid', '$postID', '$comment')";
		$success = $db->query($query);
		return $success;
	}
	function like($userid, $postID) {
		global $db;
		$query = "INSERT INTO likes
				(userID, postID)
				VALUES
				('$userid', '$postID')";
		$success = $db->query($query);
		return $success;
	}

	function unlike($userid, $postID) {
		global $db;
		$query = "DELETE FROM likes
				WHERE 
				userID = '$userid' AND postID = '$postID'";
		$success = $db->query($query);
		return $success;
	}

	function userLike($userid, $postID) {
		global $db;
		$query = "SELECT * FROM likes
				WHERE (userID = '$userid') AND (postID = '$postID')";
		$success = $db->query($query);
		if ($success == false) {
			echo "<p>db error!</p>";
		}
		$row = $success->num_rows;
		$success->free();
		return $row;
	}

	function lastStatus($userid) {
		global $db;
		$query = "SELECT postID, postText FROM posts
				WHERE userID = '$userid'
				ORDER BY timeOn DESC
				LIMIT 1";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$lastStatus = $row['postText'];
		$success->free();
		return $lastStatus;
	}

	function userPosts($userid) {
		global $db;
		$query = "SELECT * FROM posts
				WHERE userID = '$userid'
				ORDER BY timeOn DESC";
		$result = $db->query($query);
		$total = $result->num_rows;
		$posts = array();
		for ($i=0; $i<$total; $i++) {
			$row = $result->fetch_assoc();
			$posts[$i] = array();
			$posts[$i]['postID'] = $row['postID'];
			$posts[$i]['userID'] = $row['userID'];
			$posts[$i]['postername'] = getUserName($row['userID']);
			$posts[$i]['postText'] = $row['postText'];
			$posts[$i]['ifImage'] = $row['ifImage'];
			$posts[$i]['timeOn'] = $row['timeOn'];
			$posts[$i]['likes'] = getLikes($row['postID']);
		}
	

		return $posts;
	}
?>

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
		//$stmt->bind_param("i", $postID);
		//$stmt->bind_result($userID, $postID, $commentText, $timeOn);
		$stmt->bindValue(1, $postID);
		$stmt->execute();
		$row = $stmt->fetch();
		// Array to Store *number* of comments
		$comments = array();
		// Array to store a single comment temporarily
		$comment = array();
		while ($row != null) {

			$comment['userID'] = $row['userID'];
			$comment['commentername'] = getUserName($row['userID']);
			$comment['postID'] = $row['postID'];
			$comment['comment'] = $row['commentText'];
			$comment['timeOn'] = $row['timeOn'];
			// Now store this single comment in `comments` array.
			$comments[] = $comment;
			$row = $stmt->fetch();
		}	
		$stmt->closeCursor();
		return $comments;
	}

	function getLikes($postID) {
		
		global $db;
		$query = "SELECT COUNT(*) AS totallikes
				FROM likes
				WHERE postID = ?";

		$stmt = $db->prepare($query);
		//$stmt->bind_result($totalLikes);
		$stmt->bindValue(1, $postID);
		$stmt->execute();
		$row = $stmt->fetch();
		// Close stmt 
		$stmt->closeCursor();
		// Return total number of likes to the postID
		return $row['totallikes'];
	}

	function getPosts($userid, $friends) {
		
		global $db;
		$friends[] = $userid;
		$totalFriends = count($friends);

		$query = "SELECT * FROM posts
				WHERE userID in (%s) ORDER BY timeOn DESC";
		
		$inclause = implode(',', array_fill(0, $totalFriends, '?')); // to fill (?)s in SQL
		$prepareQuery = sprintf($query, $inclause);
		
		$stmt = $db->prepare($prepareQuery);
		$stmt->execute($friends);
		
		$posts = array();
		$post = array();
		$row = $stmt->fetch();
		
		while ($row != null) {
			
			$post['postID'] = $row['postID'];
			$post['userID'] = $row['userID'];
			$post['postername'] = getUserName($row['userID']);
			$post['posterpic'] = getCurrentProfilePic($row['userID']);
			$post['postText'] = $row['postText'];
			$post['ifImage'] = $row['ifImage'];
			$post['timeOn'] = $row['timeOn'];
			$post['likes'] = getLikes($row['postID']);

			$posts[] = $post;
			$row = $stmt->fetch();
		}
		$stmt->closeCursor();
		return $posts;
	}

	function postNew($userid, $post) {
		
		global $db;
		$post = strip_tags($post);
		$query = "INSERT INTO posts
				(userID, postText)
				VALUES
				(?, ?)";
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $post);
		$success = $stmt->execute();
		return $success;
	}

	function newImagePost($userid, $imagePath, $postText) {
		
		global $db;
		$postText = strip_tags($postText);
		
		$query = "INSERT INTO posts
				(userID, postText, ifImage)
				VALUES
				(?, ?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $postText);
		$stmt->bindValue(3, $imagePath);

		$success = $stmt->execute();
		return $success;
	}

	function commentOnPost($userid, $postID, $comment) {
		global $db;
		$comment = strip_tags($comment);
		
		$query = "INSERT INTO comments
				(userID, postID, commentText)
				VALUES
				(?, ?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $postID);
		$stmt->bindValue(3, $comment);
		
		$success = $stmt->execute();
		return $success;
	}

	function like($userid, $postID) {
		global $db;
		
		$query = "INSERT INTO likes
				(userID, postID)
				VALUES
				(?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $postID);
		
		$success = $stmt->execute();
		return $success;
	}

	function unlike($userid, $postID) {
		global $db;
		
		$query = "DELETE FROM likes
				WHERE 
				userID = ? AND postID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $postID);
		$success = $stmt->execute();
		return $success;
	}

	function userLike($userid, $postID) {
		global $db;
		
		$query = "SELECT * FROM likes
				WHERE (userID = ?) AND (postID = ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $postID);
		$success = $stmt->execute();
		if ($success == false) {
			echo "<p>db error!</p>";
		}
		$row = $stmt->fetch();
		$stmt->closeCursor();
		return $row;
	}

	function lastStatus($userid) {
		global $db;

		$query = "SELECT postID, postText FROM posts
				WHERE userID = ?
				ORDER BY timeOn DESC
				LIMIT 1";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		$row = $stmt->fetch();
		$lastStatus = $row['postText'];
		$stmt->closeCursor();
		return $lastStatus;
	}

	function userPosts($userid) {
		global $db;
		
		$query = "SELECT * FROM posts
				WHERE userID = ?
				ORDER BY timeOn DESC";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		$row = $stmt->fetch();
		// Array to store all the posts in
		$posts = array();
		// Array to store single post
		
		while ($row != null) {
			
			$post['postID'] = $row['postID'];
			$post['userID'] = $row['userID'];
			$post['postername'] = getUserName($row['userID']);
			$post['postText'] = $row['postText'];
			$post['ifImage'] = $row['ifImage'];
			$post['timeOn'] = $row['timeOn'];
			$post['likes'] = getLikes($row['postID']);
			$posts[] = $post;
			$row = $stmt->fetch();
		}
		// Release resources
		$stmt->closeCursor();
		return $posts;
	}
?>

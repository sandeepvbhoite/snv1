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

	function getComments($postID) {
		global $db;
		$query = "SELECT userID, postID, commentText, timeOn FROM comments
				WHERE postID = '$postID'";
		$success = $db->query($query);
		$total   = $success->num_rows;
		$comments = array();
		for ($i=0; $i<$total; $i++) {
			$row = $success->fetch_assoc();
			$comments[$i] = array();
			$comments[$i]['userID'] = $row['userID'];
			$comments[$i]['commentername'] = getUserName($row['userID']);
			$comments[$i]['postID'] = $row['postID'];
			$comments[$i]['comment'] = $row['commentText'];
			$comments[$i]['timeOn'] = $row['timeOn'];
		}
		$success->free();
		return $comments;
	}

	function getLikes($postID) {
		global $db;
		$query = "SELECT COUNT(*) AS totallikes
				FROM likes
				WHERE postID = '$postID'";
		$success = $db->query($query);
		$total   = $success->fetch_assoc();
		$total   = $total['totallikes'];
		$success->free();
		return $total;
	}


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
/*			$comments = getComments($row['PostID']);
			$total = count($comments);
			for ($i=0; $i<$total; $i++) {
				$posts[$i]['comments']['userID'] = $comment['userID'];
				$posts[$i]['comments']['comment'] = $comment['comment'];
				$posts[$i]['comments']['commentername'] = $comment['commentername'];
				$posts[$i]['comments']['timeOn'] = $comment['timeOn'];
			}
*/		}
		$result->free();
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
/*			$comments = getComments($row['PostID']);
			$total = count($comments);
			for ($i=0; $i<$total; $i++) {
				$posts[$i]['comments']['userID'] = $comment['userID'];
				$posts[$i]['comments']['comment'] = $comment['comment'];
				$posts[$i]['comments']['commentername'] = $comment['commentername'];
				$posts[$i]['comments']['timeOn'] = $comment['timeOn'];
			}
*/		}

		return $posts;
	}
?>

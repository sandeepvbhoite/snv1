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
/*	function getPagePic ($pageID) {
		global $db;
		$query = "SELECT pic FROM pages
				WHERE pageID = '$pageID'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$pic = $row['pic'];
		return $pic;
	}
*/	function getPagesList($userid) {
		global $db;
		$query = "SELECT userID, pageID FROM pages_likes
				WHERE userID = '$userid'";
		$success = $db->query($query);
		$total   = $success->num_rows;
		$pages   = array();
		for ($i=0; $i<$total; $i++) {
			$row = $success->fetch_assoc();
			$pages[] = $row['pageID'];
		}
		$success->free();
		return $pages;
	}
	
	function likeNewPage($userid, $pageID) {
		global $db;
		$query = "INSERT INTO pages_likes
				(userID, pageID)
				VALUES
				('$userid', '$pageID')";
		$success = $db->query($query);
		return $success;
	}

	function unlikeOldPage($userid, $pageID) {
		global $db;
		$query = "DELETE FROM pages_likes
				WHERE
				userID = '$userid' AND pageID = '$pageID'";
		$success = $db->query($query);
		return $success;
		
	}

	function getOwnedPagesList($userid) {  
		global $db;
		$query = "SELECT pageID FROM pages
				WHERE ownerID = '$userid'";
		$success = $db->query($query);
		$total = $success->num_rows;
		$pages = array();
		for ($i=0; $i<$total; $i++) {
			$row = $success->fetch_assoc();
			$pages[] = $row['pageID'];
		}
		$success->free();
		return $pages;
	}

	function getPageName($pageID) {
		global $db;
		$query = "SELECT name FROM pages
				WHERE pageID = '$pageID'";
		$success = $db->query($query);
		$row     = $success->fetch_assoc();
		$name    = $row['name'];
		$success->free();
		return $name;
	}

	function getPagePic($pageID) {
		global $db;
		$query = "SELECT pic FROM pages
				WHERE pageID = '$pageID'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$pagePic = $row['pic'];
		return $pagePic;
	}

	function getCommentsOfPagePost($postID) {
		global $db;
		$query = "SELECT userID, commentText, timeOn FROM page_post_comments
				WHERE postID = '$postID'";
		$success = $db->query($query);
		$comments = array();
		$total = $success->num_rows;
		for ($i=0; $i<$total; $i++) {
			$row = $success->fetch_assoc();
			$comments[$i] = array();
			$comments[$i]['userID'] = $row['userID'];
			$comments[$i]['commentername'] =  getUserName($row['userID']);
			$comments[$i]['comment'] = $row['commentText'];
			$comments[$i]['timeOn'] = $row['timeOn'];
		}
		$success->free();
		return $comments;
	}

	function getPagePostLikes($postID) {
		global $db;
		$query = "SELECT COUNT(*) AS totallikes
				FROM page_post_likes
				WHERE postID = '$postID'";
		$success = $db->query($query);
		$total   = $success->fetch_assoc();
		$total   = $total['totallikes'];
		$success->free();
		return $total;
	}


	function isLiked($userid, $pageID) {
		global $db;
		$query = "SELECT COUNT(*) AS total FROM pages_likes
				WHERE userID = '$userid' AND pageID = '$pageID'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$isLiked = $row['total'];
		$success->free();
		if ($isLiked > 0) {
			return true;
		} else {
			return false;
		}
	}


	function getPostsOfPages($pages) {
		global $db;
		$totalPages = count($pages);
		$firstPage  = $pages[0];
		$query = "SELECT * FROM page_posts
				WHERE pageID = '$firstPage'";

		for ($i=1; $i<$totalPages; $i++) {
			$currentPage = $pages[$i];
			$query = $query . " OR pageID = '$currentPage'";
		}

		$query = $query . " ORDER BY timeOn DESC";
		$result = $db->query($query);
		$totalPosts = $result->num_rows;
		$posts = array();
		for ($i=0; $i<$totalPosts; $i++) {
			$posts[$i] = array();
			$row = $result->fetch_assoc();
			$pageID = $row['pageID'];
			$posts[$i]['pageID'] = $pageID;
			$posts[$i]['postID'] = $row['postID'];
			$posts[$i]['pagename'] = getPageName($pageID);
			$posts[$i]['totallikes'] = getPagePostLikes($row['postID']);
			$posts[$i]['postText'] = $row['postText'];
			$posts[$i]['ifImage'] = $row['ifImage'];
			$posts[$i]['timeOn'] = $row['timeOn'];
		}
		$result->free();
		return $posts;
	}
	
	function commentOnPagePost($userid, $postID, $comment) {
		global $db;
		$comment = $db->real_escape_string($comment);
		$query = "INSERT INTO page_post_comments
				(userID, postID, commentText)
				VALUES
				('$userid', '$postID', '$comment')";
		$success = $db->query($query);
		return $success;
	}
	

	function likePagePost($userid, $postID) {
		global $db;
		$query = "INSERT INTO page_post_likes
				(postID, userID)
				VALUES
				('$postID', '$userid')";
		$success = $db->query($query);
		return $success;
	}

	function unlikePagePost($userid, $postID) {
		global $db;
		$query = "DELETE FROM page_post_likes
				WHERE userID = '$userid' AND postID = '$postID'";
		$success = $db->query($query);
		return $success;
	}
	
	function islikedPagePost($userid, $postID) {
		global $db;
		$query = "SELECT COUNT(*) as total
				FROM page_post_likes
				WHERE postID = '$postID' AND userID = '$userid'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$like = $row['total'];
		$success->free();
		if($like) {
			return true;
		} else {
			return false;
		}
	}

	function existanceOfPage($pageID) {
		global $db;
		$query = "SELECT COUNT(*) AS total
				FROM pages
				WHERE pageID = '$pageID'";
		$success = $db->query($query);
		$total   = $success->fetch_assoc();
		$total = $total['total'];
		$success->free();
		if ($total == 1):
			return true;
		else:
			return false;
		endif;
	}

	function pagePosts($pageID) {
		global $db;
		$query = "SELECT * FROM page_posts
				WHERE pageID = '$pageID'
				ORDER BY timeOn DESC";
		$success = $db->query($query);
		$totalPosts = $success->num_rows;
		$posts = array();
		for ($i=0; $i<$totalPosts; $i++) {
			$posts[$i] = array();
			$row = $success->fetch_assoc();
			$posts[$i]['postID'] = $row['postID'];
			$posts[$i]['postText'] = $row['postText'];
			$posts[$i]['ifImage'] = $row['ifImage'];
			$posts[$i]['timeOn'] = $row['timeOn'];
		}
		$success->free();
		return $posts;
	}

	function isOwner($userid, $pageID) {
		global $db;
		$query = "SELECT ownerID, pageID FROM pages
				WHERE ownerID = '$userid' AND pageID = '$pageID'";
		$success = $db->query($query);
		$isOwner = $success->num_rows;
		$success->free();
		if ($isOwner) {
			return true;
		} else {
			return false;
		}
	}

	function usersPagePostLike($userid, $postID) {
		global $db;
		$query = "SELECT COUNT(*) AS total FROM page_post_likes
				WHERE userID = '$userid' AND postID = '$postID'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$total = $row['total'];
		$success->free();
		if ($total) {
			return true;
		} else {
			return false;
		}
	}

	function postOnPage($pageID, $newpost) {
		global $db;
		$newpost = $db->real_escape_string($newpost);
		$query = "INSERT INTO page_posts
				(pageID, postText)
				VALUES
				('$pageID', '$newpost')";
		$success = $db->query($query);
		return $success;
	}

	function createCelebPage($userid, $about, $name, $imagePath, $birthday, $city, $state, $country, $website, $telephone, $email, $history) {
		global $db;
		$query = "INSERT INTO pages
				(typeID, ownerID, name, pic, about, born, city, state, country, web, tele, email, history)
				VALUES
				(1, '$userid', '$name', '$imagePath', '$about', '$birthday', '$city', '$state', '$country', '$website', '$telephone', '$email','$history')";
		$success = $db->query($query);
		if ($success) {
			$query = "SELECT pageID FROM pages
					WHERE ownerID = '$userid' AND email = '$email' AND name = '$name' AND tele = '$telephone'";
			$success = $db->query($query);
			$row = $success->fetch_assoc();
			$newpageID = $row['pageID'];
			$query = "INSERT INTO pages_likes
				(userID, pageID)
				VALUES
				('$userid', '$newpageID')";
			$success = $db->query($query);
			return $newpageID;
		} else {
			return false;
		}
	}
	
	function getCelebInfo($pageID) {
		global $db;
		$query = "SELECT typeID, ownerID, name, about, born, city, state, country, web, tele, email, history 
				FROM pages
				WHERE pageID= '$pageID'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$page = array();
		$page['typeID'] = $row['typeID'];
		$page['ownerID'] = $row['ownerID'];
		$page['name'] = $row['name'];
		$page['about'] = $row['about'];
		$page['born'] = $row['born'];
		$page['city'] = $row['city'];
		$page['state'] = $row['state'];
		$page['country'] = $row['country'];
		$page['web'] = $row['web'];
		$page['tele'] = $row['tele'];
		$page['email'] = $row['email'];
		$page['history'] = $row['history'];
		$success->free();
		return $page;
	}

	function createCorpPage($userid, $name, $imagePath, $about, $year, $product, $city, $state, $country, $website, $tele, $email, $history) {
		global $db;
		$query = "INSERT INTO pages
				(typeID, ownerID, name, pic, about, started, product, city, state, country, web, tele, email, history)
				VALUES
				(2, '$userid', '$name', '$imagePath', '$about', '$year', '$product', '$city', '$state', '$country', '$website', '$tele', '$email', '$history')";
		$success = $db->query($query);
		if ($success) {
			$query = "SELECT pageID FROM pages
				WHERE ownerID = '$userid' AND email = '$email' AND name = '$name' AND tele = '$tele'";
			$success = $db->query($query);
			$row = $success->fetch_assoc();
			$newpageID = $row['pageID'];
			$query = "INSERT INTO pages_likes
				(userID, pageID)
				VALUES
				('$userid', '$newpageID')";
			$success = $db->query($query);
			return $newpageID;
		} else {
			return false;
		}
	}
	
	function getCorpInfo($pageID) {
		global $db;
		$query = "SELECT typeID, ownerID, name, about, started, product, city, state, country, web, tele, email, history
				FROM pages
				WHERE pageID = '$pageID'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$page = array();
		$page['typeID'] = $row['typeID'];
		$page['ownerID'] = $row['ownerID'];
		$page['name'] = $row['name'];
		$page['about'] = $row['about'];
		$page['started'] = $row['started'];
		$page['product'] = $row['product'];
		$page['city'] = $row['city'];
		$page['state'] = $row['state'];
		$page['country'] = $row['country'];
		$page['web'] = $row['web'];
		$page['tele'] = $row['tele'];
		$page['email'] = $row['email'];
		$page['history'] = $row['history'];
		$success->free();
		return $page;
	}

	function getTypeOfPage($pageID) {
		global $db;
		$query = "SELECT typeID FROM pages
				WHERE pageID = '$pageID'";
		$success = $db->query($query);
		$row = $success->fetch_assoc();
		$type = $row['typeID'];
		$success->free();
		return $type;
	}
	
	function newImagePostOnPage($pageID, $ifImage, $postText) {
		global $db;
		$postText = $db->real_escape_string($postText);
		$query = "INSERT INTO page_posts
				(pageID, postText, ifImage)
				VALUES
				('$pageID', '$postText', '$ifImage')";
		$success = $db->query($query);
		return $success;
	}
?>

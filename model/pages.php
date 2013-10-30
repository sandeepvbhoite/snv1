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

	function getPagesList($userid) {
		global $db;	
		$query = "SELECT userID, pageID FROM pages_likes
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		// Fetch first row
		$row = $stmt->fetch();
		$pages = array();

		while ($row != null) {
			$pages[] = $row['pageID'];
			$row = $stmt->fetch();
		}
		return $pages;
	}

	function getDislikedPagesList($userid) {
		global $db;	
		$query = "SELECT userID, pageID FROM pages_dislikes
				WHERE userID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->execute();
		// Fetch first row
		$row = $stmt->fetch();
		$pages = array();

		while ($row != null) {
			$pages[] = $row['pageID'];
			$row = $stmt->fetch();
		}
		return $pages;
	}

	function likeNewPage($userid, $pageID) {
		global $db;
		$query = "INSERT INTO pages_likes
				(userID, pageID)
				VALUES
				(?, ?)";
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $pageID);
		$success = $stmt->execute();
		return $success;
	}

    function dislikeNewPage($userid, $pageID) {
        global $db;

        $query = "INSERT INTO pages_dislikes
                (userID, pageID)
                VALUES
                (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $userid);
        $stmt->bindValue(2, $pageID);
        $success = $stmt->execute();
        return $success;
    }

    function removeOldDislike($userid, $pageID) {
        global $db;
        $query = "DELETE FROM pages_dislikes
                WHERE
                userID = ? AND pageID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $userid);
        $stmt->bindValue(2, $pageID);
        $success = $stmt->execute();
        return $success;
    }

	function unlikeOldPage($userid, $pageID) {
		global $db;
		$query = "DELETE FROM pages_likes
				WHERE
				userID = ? AND pageID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $pageID);
		$success = $stmt->execute();
		return $success;
	}

	function getOwnedPagesList($userid) {
		global $db;

		$query = "SELECT pageID FROM pages
				WHERE ownerID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$success = $stmt->execute();
		$row = $stmt->fetch();
		$pages = array();
		while ($row != null) {
			$pages[] = $row['pageID'];
			$row = $stmt->fetch();
		}
		$stmt->closeCursor();
		return $pages;
	}

	function getPageName($pageID) {
		global $db;

		$query = "SELECT name FROM pages
				WHERE pageID = ?";
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$stmt->execute();
		$row = $stmt->fetch();
		$name    = $row['name'];
		$stmt->closeCursor();
		return $name;
	}

	function getPagePic($pageID) {
		global $db;

		$query = "SELECT pic FROM pages
				WHERE pageID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$stmt->execute();
		$row = $stmt->fetch();
		$pagePic = $row['pic'];
		return $pagePic;
	}

	function getCommentsOfPagePost($postID) {
		global $db;

		$query = "SELECT userID, commentText, timeOn FROM page_post_comments
				WHERE postID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindParam(1, $postID);
		$success = $stmt->execute();
		$row = $stmt->fetch();
		$comments = array();
		$comment = array();
		while ($row != null) {
			$comment['userID'] = $row['userID'];
			$comment['commentername'] =  getUserName($row['userID']);
			$comment['comment'] = $row['commentText'];
			$comment['timeOn'] = $row['timeOn'];
			$comments[] = $comment;
			$row = $stmt->fetch();
		}
		$stmt->closeCursor;
		return $comments;
	}

	function getPagePostLikes($postID) {
		global $db;

		$query = "SELECT COUNT(*) AS totallikes
				FROM page_post_likes
				WHERE postID = ?";
		$stmt = $db->prepare($query);
		$stmt->bindParam(1, $postID);
		$stmt->execute();
		// Fetch that row
		$row = $stmt->fetch();
		// Get total number of likes for the postID
		$total   = $row['totallikes'];
		// Release resources
		$stmt->closeCursor();
		return $total;
	}

	function isDisLiked($userid, $pageID) {
		global $db;

		$query = "SELECT COUNT(*) AS total FROM pages_dislikes
				WHERE userID = ? AND pageID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $pageID);

		$success = $stmt->execute();
		$row = $stmt->fetch();
		$isDisliked = $row['total'];
		$stmt->closeCursor();
		if ($isDisliked) {
			return true;
		} else {
			return false;
		}
	}

	function isLiked($userid, $pageID) {
		global $db;

		$query = "SELECT COUNT(*) AS total FROM pages_likes
				WHERE userID = ? AND pageID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $pageID);

		$success = $stmt->execute();
		$row = $stmt->fetch();
		$isLiked = $row['total'];
		$stmt->closeCursor();
		if ($isLiked) {
			return true;
		} else {
			return false;
		}
	}


	function getPostsOfPages($pages) {
		
		global $db;
		/*
		 * This pageID - 1 has nothing to do with user's page likes.
		 * It's just a dirty hack to get array_fill function working.
		 * array_fill needs $total to be greater than 0.
		 */
		$pages[] = 1;
		$total = count($pages);
		
		$query = "SELECT * FROM page_posts
				WHERE pageID in (%s) ORDER BY timeOn DESC
				LIMIT 10";
		
		$inclause = implode(',', array_fill(0, $total, '?')); // Fill ?s
		$prepareQuery = sprintf($query, $inclause);

		$stmt = $db->prepare($prepareQuery);
		$stmt->execute($pages);
		$row = $stmt->fetch();
		
		$posts = array();
		$post = array();

		while ($row != null) {
			
			$pageID = $row['pageID'];
			$post['pageID'] = $pageID;
			$post['postID'] = $row['postID'];
			$post['pagename'] = getPageName($pageID);
			$post['totallikes'] = getPagePostLikes($row['postID']);
			$post['postText'] = $row['postText'];
			$post['ifImage'] = $row['ifImage'];
			$post['timeOn'] = $row['timeOn'];
			// Save this post in posts array
			$posts[] = $post;
			// Get next post
			$row = $stmt->fetch();
		}
		$stmt->closeCursor();
		return $posts;
	}
	
	function commentOnPagePost($userid, $postID, $comment) 
	{	
		global $db;
		$comment = strip_tags($comment);
		
		$query = "INSERT INTO page_post_comments
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
	

	function likePagePost($userid, $postID) 
	{
		global $db;
		
		$query = "INSERT INTO page_post_likes
				(postID, userID)
				VALUES
				(?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $postID);
		$stmt->bindValue(2, $userid);

		$success = $stmt->execute();
		return $success;
	}

	function unlikePagePost($userid, $postID) 
	{
		global $db;
		
		$query = "DELETE FROM page_post_likes
				WHERE userID = ? AND postID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $postID);
		$success = $stmt->execute();
		return $success;
	}
	
	function islikedPagePost($userid, $postID) 
	{
		global $db;
		
		$query = "SELECT COUNT(*) as total
				FROM page_post_likes
				WHERE postID = ? AND userID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $postID);
		$stmt->bindValue(2, $userid);
		$stmt->execute();
		$row = $stmt->fetch();
		$like = $row['total'];
		$stmt->closeCursor();
		if($like) {
			return true;
		} else {
			return false;
		}
	}

	function existanceOfPage($pageID) 
	{
		global $db;
		
		$query = "SELECT COUNT(*) AS total
				FROM pages
				WHERE pageID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$stmt->execute();
		$total   = $stmt->fetch();
		$total = $total['total'];
		$success->free();
		if ($total == 1):
			return true;
		else:
			return false;
		endif;
	}

	function pagePosts($pageID) 
	{
		global $db;
		
		$query = "SELECT * FROM page_posts
				WHERE pageID = ?
				ORDER BY timeOn DESC";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$stmt->execute();
		$row = $stmt->fetch();
		$posts = array();
		$post = array();	
		while ($row != null) {

			$post['postID'] = $row['postID'];
			$post['postText'] = $row['postText'];
			$post['ifImage'] = $row['ifImage'];
			$post['timeOn'] = $row['timeOn'];
			$posts[] = $post;
			$row = $stmt->fetch();
		}
		$stmt->closeCursor();
		return $posts;
	}

	function isOwner($userid, $pageID) 
	{
		global $db;
		
		$query = "SELECT COUNT(*) AS total FROM pages
				WHERE ownerID = ? AND pageID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $pageID);
		$stmt->execute();
		$row = $stmt->fetch();
		$total = $row['total'];
		$stmt->closeCursor();
		
		/* total should be 1 if the given userid is the owner 
		 * of the given pageID */
		if ($total>0) {
			return true;
		} else {
			return false;
		}
	}

	function usersPagePostLike($userid, $postID) 
	{
		global $db;
		
		$query = "SELECT COUNT(*) AS total FROM page_post_likes
				WHERE userID = ? AND postID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $postID);
		$stmt->execute();
		$row = $stmt->fetch();
		$total = $row['total'];
		$stmt->closeCursor();
		// If total>0, user has liked postID post
		if ($total) {
			return true;
		} else {
			return false;
		}
	}

	function postOnPage($pageID, $newpost) 
	{
		global $db;
		$newpost = strip_tags($newpost);
		$query = "INSERT INTO page_posts
				(pageID, postText)
				VALUES
				(?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$stmt->bindValue(2, $newpost);
		$success = $stmt->execute();
		return $success;
	}

	function createCelebPage($userid, $about, $name, $imagePath, $birthday, 
			$city, $state, $country, $website, $telephone, $email, $history) 
	{
		global $db;
		
		$query = "INSERT INTO pages
				(typeID, ownerID, name, pic, about, born, city, state, country, 
				 web, tele, email, history)
				VALUES
				(1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $name);
		$stmt->bindValue(3, $imagePath);
		$stmt->bindValue(4, $about);
		$stmt->bindValue(5, $birthday);
		$stmt->bindValue(6, $city);
		$stmt->bindValue(7, $state);
		$stmt->bindValue(8, $country);
		$stmt->bindValue(9, $website);
		$stmt->bindValue(10, $telephone);
		$stmt->bindValue(11, $email);
		$stmt->bindValue(12, $history);
		$success = $stmt->execute();
		$stmt->closeCursor();

		if ($success) {
			// Get pageID of this created page
			$query = "SELECT pageID FROM pages
					WHERE ownerID = ? AND email = ? 
					AND name = ? AND tele = ?";
		
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $email);
			$stmt->bindValue(3, $name);
			$stmt->bindValue(4, $telephone);

			$success = $stmt->execute();
			$row = $stmt->fetch();
			$stmt->closeCursor();
			$newpageID = $row['pageID'];
			
			// Admin of the page has `like'd this page by-default, so...
			$query = "INSERT INTO pages_likes
				(userID, pageID)
				VALUES
				(?, ?)";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $newpageID);
			$success = $stmt->execute();
			$stmt->closeCursor();
			return $newpageID;
		} else {
			return false;
		}
	}
	
	function getCelebInfo($pageID) 
	{
		global $db;

		$query = "SELECT typeID, ownerID, name, about, born, city, state, 
				country, web, tele, email, history 
				FROM pages
				WHERE pageID= ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$stmt->execute();
		$row = $stmt->fetch();
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
		$stmt->closeCursor();
		return $page;
	}

	function createCorpPage($userid, $name, $imagePath, $about, $year, 
			$product, $city, $state, $country, $website, $tele, $email, $history) 
	{
		global $db;
		$query = "INSERT INTO pages
				(typeID, ownerID, name, pic, about, started, product, city, 
				 state, country, web, tele, email, history)
				VALUES
				(2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $userid);
		$stmt->bindValue(2, $name);
		$stmt->bindValue(3, $imagePath);
		$stmt->bindValue(4, $about);
		$stmt->bindValue(5, $year);
		$stmt->bindValue(6, $product);
		$stmt->bindValue(7, $city);
		$stmt->bindValue(8, $state);
		$stmt->bindValue(9, $country);
		$stmt->bindValue(10, $website);
		$stmt->bindValue(11, $tele);
		$stmt->bindValue(12, $email);
		$stmt->bindValue(13, $history);
		$success = $stmt->execute();
		$stmt->closeCursor();

		if ($success) {
			$query = "SELECT pageID FROM pages
				WHERE ownerID = ? AND email = ? 
				AND name = ? AND tele = ?";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $email);
			$stmt->bindValue(3, $name);
			$stmt->bindValue(4, $tele);

			$stmt->execute();
			$row = $stmt->fetch();
			$stmt->closeCursor();
			$newpageID = $row['pageID'];
			
			$query = "INSERT INTO pages_likes
				(userID, pageID)
				VALUES
				(?, ?)";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $userid);
			$stmt->bindValue(2, $newpageID);
			$success = $stmt->execute();
			return $newpageID;
		} else {
			return false;
		}
	}
	
	function getCorpInfo($pageID) 
	{
		global $db;
		$query = "SELECT typeID, ownerID, name, about, started, product, 
				city, state, country, web, tele, email, history
				FROM pages
				WHERE pageID = ?";

		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$stmt->execute();
		$row = $stmt->fetch();
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
		$stmt->closeCursor();
		return $page;
	}

	function getTypeOfPage($pageID) 
	{
		global $db;
		
		$query = "SELECT typeID FROM pages
				WHERE pageID = ?";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$success = $stmt->execute();
		$row = $stmt->fetch();
		$type = $row['typeID'];
		return $type;
	}
	
	function newImagePostOnPage($pageID, $ifImage, $postText) 
	{
		global $db;
		$postText = strip_tags($postText);
		
		$query = "INSERT INTO page_posts
				(pageID, postText, ifImage)
				VALUES
				('$pageID', '$postText', '$ifImage')";
		
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $pageID);
		$stmt->bindValue(2, $postText);
		$stmt->bindValue(3, $ifImage);
		$success = $stmt->execute();
		$stmt->closeCursor();
		return $success;
	}
?>

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
?>
<?php
	/* Starting session here */
	session_set_cookie_params(0);
	session_start();

	require_once ('model/database.php');
	require_once ('model/friends.php');
	require_once ('model/userInfo.php');
	require_once ('model/posts.php');
	require_once ('model/pages.php');
	require_once ('model/search.php');

	if (!isset($_SESSION['userid'])) {
		include ('loginpage.php');
	} else 	{
		$userid = $_SESSION['userid'];
		$currentUserName = getUserName($userid);
		if (isset($_POST['action'])) {
			$action = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$action = $_GET['action'];
		} else {
			$action = 'showhome';
		}
		if ($action == 'showhome') {
			include ('privateposts.php');
			include ('sidebar.php');
			include ('home.php');

		} else if ($action == 'changestream') {
			if ($_GET['stream'] == 1) {
				include ('privateposts.php');
				include ('sidebar.php');
				include ('home.php');
			} else {
				include ('publicposts.php');
				include ('sidebar.php');
				include ('home.php');
			}
		} else if ($action == 'newpost') {
			$post = $_POST['status'];
			$success = postNew($userid, $post);
			header('Location: .');

		} else if ($action == 'imagepost') {
			include ('privateposts.php');
			include ('sidebar.php');
			include ('homewithimage.php');
		} else if ($action == 'newpostwithimage') {
			if(isset($_FILES['pic'])) {
				$tmp_name = $_FILES['pic']['tmp_name'];
				$path = 'images/';
				$original_name = $_FILES['pic']['name'];
				$original_name = preg_replace('/\s+/', '', $original_name);
				$name = $_SESSION['userid'] . $original_name;
				$name = $path . $name;
				$success = move_uploaded_file($tmp_name, $name);
				$postText = $_POST['status'];
				$success = newImagePost($_SESSION['userid'], $name, $postText);
				if ($success) {
					header('Location: index.php?action=imagepost');
				}
			}	
		} else if ($action == 'like') {
			$postID = $_GET['postID'];
			$success = like($_SESSION['userid'], $postID);
			$tmp = 'Location: .' . "#$postID";
			header($tmp);

		} else if ($action == 'unlike') {
			$postID = $_GET['postID'];
			$success = unlike($userid, $postID);
			$tmp = 'Location: .' . "#$postID";
			header($tmp);


		} else if ($action == 'comment') {
			$comment = $_POST['comment'];
			$postID = $_POST['postID'];
			$success = commentOnPost($userid, $postID, $comment);
			$tmp = 'Location: .' . "#$postID";
			header($tmp);


		} else if ($action == 'likepagepost') {
			$pagepostID = $_GET['pagepostID'];
			$success = likePagePost($userid, $pagepostID);
			$tmp = 'Location: .?action=changestream&stream=2' . "#$pagepostID";
			header($tmp);


		} else if ($action == 'unlikepagepost') {
			$pagepostID = $_GET['pagepostID'];
			$success = unlikePagePost($userid, $pagepostID);
			$tmp = 'Location: .?action=changestream&stream=2' . "#$pagepostID";
			header($tmp);


		} else if ($action == 'commentonpage') {
			$comment = $_POST['comment'];
			$pagepostID = $_POST['pagepostID'];
			$success = commentOnPagePost($userid, $pagepostID, $comment);
			$tmp = 'Location: .?action=changestream&stream=2' . "#$pagepostID";
			header($tmp);

		} else if ($action == 'search') {
			$userid = $_SESSION['userid'];
			$query = $_GET['query'];
			if ( (!isset($_GET['type'])) || ($_GET['type'] == 'people') ):
				$people = true;
				$pages = false;
				$results = searchPeople($query);
				include ('searched.php');
			else:
				$people = false;
				$pages = true;
				$results = searchPages($query);
				include ('searchedpages2.php');
			endif;
		} else {
			include ('privateposts.php');
			include ('sidebar.php');
			include ('home.php');
		}
	}
?>


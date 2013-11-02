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

	session_start();
	require_once ('model/database.php');
	require_once ('model/pages.php');
	require_once ('model/userInfo.php');

	if (!isset($_SESSION['userid'])):
		include ('loginpage.php');
	else:
		$userid = $_SESSION['userid'];
		if (isset($_POST['action'])) {
			$action = $_POST['action'];
		} else if (isset($_GET['action'])) {
			$action = $_GET['action'];
		} else {
			if (isset($_GET['id'])) {
				$action = 'showpage';
			} else {
				$action = 'newpage';
			}
		}

		if ($action == 'showpage') {
			$pageID = $_GET['id'];
			include ('pageposts.php');
			include ('sidebar.php');
			include ('page.php');
		} else if ($action == 'likepage') {
			$pageID = $_GET['id'];
			$success = likeNewPage($userid, $pageID);
			include ('pageposts.php');
			include ('sidebar.php');
			include ('page.php');
		} else if ($action == 'unlikepage') {
			$pageID = $_GET['id'];
			$success = unlikeOldPage($userid, $pageID);
			include ('pageposts.php');
			include ('sidebar.php');
			include ('page.php');
        } else if ($action == 'dislikepage') {
            $pageID = $_GET['id'];
            $success = dislikeNewPage($userid, $pageID);
            include ('pageposts.php');
            include ('sidebar.php');
            include ('page.php');
        } else if ($action == 'removedislike') {
            $pageID = $_GET['id'];
            $success = removeOldDislike($userid, $pageID);
            include ('pageposts.php');
            include ('sidebar.php');
            include ('page.php'); 
        } else if ($action == 'post') {
			$newpost = $_POST['status']; 
			$pageID  = $_POST['pageID'];
			$isOwner = isOwner($userid, $pageID);
			if ($isOwner) {
				$success = postOnPage($pageID, stripslashes($newpost));
				include ('pageposts.php');
				include ('sidebar.php');
				include ('page.php');
			}

		} else if ($action == 'topicpost') {
			$pageID = $_GET['id'];
			include ('pageposts.php');
			include ('sidebar.php');
			include ('pagewithimage.php');
		} else if ($action == 'picpost') {
			$pageID = $_POST['pageID'];
			$isOwner = isOwner($userid, $pageID);
			if ($isOwner):
			if(isset($_FILES['pic'])) {
				$tmp_name = $_FILES['pic']['tmp_name'];
				$path = 'images/';
				$original_name = $_FILES['pic']['name'];
				$original_name = preg_replace('/\s+/', '', $original_name);
				$name = $_SESSION['userid'] . $original_name;
				$name = $path . $name;
				$success = move_uploaded_file($tmp_name, $name);
				$postText = stripslashes($_POST['status']);
				$success = newImagePostOnPage($pageID, $name, $postText);
				if ($success) {
					$path = 'Location: pages.php?action=topicpost&id=' . $pageID;
					header($path);
				}
			}
			endif;
		} else if ($action == 'like' || $action == 'unlike') {
			$pageID = $_GET['pageID'];
			if ($action == 'like'):
				$postID = $_GET['postID'];
				$success = likePagePost($userid, $postID);
			else:
				$postID = $_GET['postID'];
				$success = unlikePagePost($userid, $postID);
			endif;	
			$type = getTypeOfPage($pageID);
			include ('pageposts.php');
			include ('sidebar.php');
			include ('page.php');
			
		} else if ($action == 'comment') {
			$comment = stripslashes($_POST['comment']);
			$postID  = $_POST['postID'];
			$pageID = $_POST['pageID'];
			$success = commentOnPagePost($userid, $postID, $comment);
			include ('pageposts.php');
			include ('sidebar.php');
			include ('page.php');

		} else if ($action == 'newpage') {
			$type = $_POST['type'];
			if ($type == 'celeb') {
				include ('celeb.php');
			} else if ($type == 'corp') {
				include ('corp.php');
			} else {
				include ('newpage.php');
			}
		} else if ($action == 'createpageceleb') {
			$type = 1;
			$about = stripslashes($_POST['about']);
			$name = stripslashes($_POST['name']);
			$year  = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$city = stripslashes($_POST['city']);
			$state = stripslashes($_POST['state']);
			$country = stripslashes($_POST['country']);
			$website = $_POST['website'];
			$telephone = $_POST['telephone'];
			$email = $_POST['email'];
			$history = stripslashes($_POST['history']);
			$birthday = $year . '-' . $month . '-' . $day;
			/* Let's get that uploaded image */
			if (isset($_FILES['pic'])) {
				$tmp_name = $_FILES['pic']['tmp_name'];
				$path = 'images/';
				$original_name = $_FILES['pic']['name'];
				$original_name = preg_replace('/\s+/', '', $original_name);
				$newname = $_SESSION['userid'] . $original_name;
				$newname = $path . $newname;
				$success = move_uploaded_file($tmp_name, $newname);
			}
			$pageID = createCelebPage($userid, $about, $name, $newname, $birthday, 
					$city, $state, $country, $website, $telephone, $email, $history);
			if ($type == '2') {
				$pagename = getPageName($pageID);
			} else {
				$celebname = getPageName($pageID);
			}
			include ('pageposts.php');
			include ('sidebar.php');
			include ('page.php');

		} else if ($action == 'createpagecorp') {

			$type = 2;
			$name = $_POST['name'];
			$about = $_POST['about'];
			$year = $_POST['year'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$date = $year . '-' . $month . '-' . $day;
			$product = $_POST['product'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$country = $_POST['country'];
			$website = $_POST['website'];
			$tele = $_POST['telephone'];
			$email = $_POST['email'];
			$history = $_POST['history'];
			if (isset($_FILES['pic'])) {
				$tmp_name = $_FILES['pic']['tmp_name'];
				$path = 'images/';
				$original_name = $_FILES['pic']['name'];
				$original_name = preg_replace('/\s+/', '', $original_name);
				$newname = $_SESSION['userid'] . $original_name;
				$newname = $path . $newname;
				$success = move_uploaded_file($tmp_name, $newname);
			}

			$pageID = createCorpPage($userid, $name, $newname, $about, $date, $product, 
					$city, $state, $country, $website, $tele, $email, $history);
			include ('pageposts.php');
			include ('sidebar.php');
			include ('page.php');


		} else if ($action == 'showinfo') {
			$pageID = $_GET['pageID'];
			$type = getTypeOfPage($pageID);
			if ($type == '2') {
				$page = getCorpInfo($pageID);
				include ('corpinfo.php');
			} else {
				$page = getCelebInfo($pageID);
				include ('celebinfo.php');
			}

		} else {
			
			include ('newpage.php');
		}

	endif;

?>

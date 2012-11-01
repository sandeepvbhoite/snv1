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
			$private = true;
			$public = false;
			$userid = $_SESSION['userid'];
			$pic = getCurrentProfilePic($userid);
			$friends = getFriendList($userid);
			$posts = getPosts($userid, $friends);
			$total = count($posts);
			for ($i=0; $i<$total; $i++) { 
				$postID = $posts[$i]['postID'];
				$posts[$i]['userlike'] = userLike($userid, $postID);
			}
			for ($i=0; $i<$total; $i++) {
				$postID = $posts[$i]['postID'];
				$posts[$i]['comments'] = array();
				$comments = getComments($postID);
				$totalcomments = count($comments);
				for ($j=0; $j<$totalcomments; $j++) {
					$posts[$i]['comments'][$j] = array();
					$posts[$i]['comments'][$j]['userID'] = $comments[$j]['userID'];
					$posts[$i]['comments'][$j]['commentername'] = $comments[$j]['commentername'];
					$posts[$i]['comments'][$j]['commenterpic'] = getCurrentProfilePic($comments[$j]['userID']);
					$posts[$i]['comments'][$j]['postID'] = $comments[$j]['postID'];
					$posts[$i]['comments'][$j]['comment'] = $comments[$j]['comment'];
					$posts[$i]['comments'][$j]['timeOn'] = $comments[$j]['timeOn'];
				}
			}

?>

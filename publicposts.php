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
				
				$public = true;
				$private = false;
				$userid = $_SESSION['userid'];
				$pic = getCurrentProfilePic($userid);
				$pages = getPagesList($userid);
				$pub_posts = getPostsOfPages($pages);
				$total = count($pub_posts);
				for ($i=0; $i<$total; $i++) {
					$postID = $pub_posts[$i]['postID'];
					$pub_posts[$i]['userlike'] = islikedPagePost($userid, $postID);
				}
				for ($i=0; $i<$total; $i++) {
					$postID = $pub_posts[$i]['postID'];
					$pub_posts[$i]['comments'] = array();
					$comments = getCommentsOfPagePost($postID);
					$total_comments = count($comments);
					for ($j=0; $j<$total_comments; $j++) {
						$pub_posts[$i]['comments'][$j] = array();
						$pub_posts[$i]['comments'][$j]['userID'] = $comments[$j]['userID'];
						$pub_posts[$i]['comments'][$j]['commentername'] = $comments[$j]['commentername'];
						$pub_posts[$i]['comments'][$j]['commenterpic'] = getCurrentProfilePic($comments[$j]['userID']);
						$pub_posts[$i]['comments'][$j]['comment'] = $comments[$j]['comment'];
						$pub_posts[$i]['comments'][$j]['timeOn'] = $comments[$j]['timeOn'];
					}
				}


?>

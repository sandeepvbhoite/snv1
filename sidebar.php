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
            /* Check if there are any "liked" pages, and return them */
			$pagesLiked = getPagesList($userid);
			if (count($pagesLiked) == 0) {
				$pagesLiked = false;
			} else {
				$total = count($pagesLiked);
				$pagesL = array();
				for ($i=0; $i<$total; $i++) {
					$pagesL[$i] = array();
					$pagesL[$i]['page_ID']   = $pagesLiked[$i];
					$pagesL[$i]['page_name'] = getPageName($pagesLiked[$i]);
				}
            }

            /* Check if there are any pages user own, and return them */
			$pagesOwned = getOwnedPagesList($userid);
			if (count($pagesOwned) == 0) { 
				$pagesOwned = false;
			} else {
				$total = count($pagesOwned);
				$pagesO = array();
				for ($i=0; $i<$total; $i++) {
					$pagesO[$i] = array();
					$pagesO[$i]['page_ID'] = $pagesOwned[$i];
					$pagesO[$i]['page_name'] = getPageName($pagesOwned[$i]);
				}
            }

            /* Check if there any pages user "dislikes", and return them */
            $pagesDisliked = getDislikedPagesList($userid);
            if(count($pagesDisliked) == 0) {
                $pagesDisliked = false;
            } else {
                $total = count($pagesDisliked);
                $pagesD = array();
                for ($i=0; $i<$total; $i++) {
                    $pagesD[$i] = array();
                    $pagesD[$i]['page_ID'] = $pagesDisliked[$i];
                    $pagesD[$i]['page_name'] = getPageName($pagesDisliked[$i]);
                }
            }

?>

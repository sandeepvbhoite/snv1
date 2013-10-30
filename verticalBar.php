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
<div id="vertical">
                             <!-- pages liked -->                   
                     <div id="pages_label1">
                           <p>Pages Liked</p>
                     </div>
			 <!--page list starts here -->
			 <?php if ($pagesLiked): ?>

			 <?php $total = count($pagesliked); ?>
			 <?php foreach ($pagesL as $index => $pageL):
			 			$page_name = $pageL['page_name'];
						$page_ID = $pageL['page_ID'];
			 ?>
                    <a href="pages.php?action=showpage&id=<?php echo $page_ID; ?>"><div class="page-list">
                               <img src="images/page-icon.jpg" width="15" height="15"/>
                               <p><?php echo $page_name; ?></p>
                               </div>
                    </a>
			<?php endforeach ?>
			<?php else: ?>
					<div class="page_list">
						<p> You have not liked any pages yet</p>
					</div>
			<?php endif; ?>

                         <!-- pages disliked -->
                     <div id="pages_label2">
                           <p>Pages Disliked</p>
                     </div>
			 <!--page list starts here -->
			 <?php if ($pagesDisliked): ?>

			 <?php $total = count($pagesDisliked); ?>
			 <?php foreach ($pagesD as $index => $pageD):
			 			$page_name = $pageD['page_name'];
						$page_ID = $pageD['page_ID'];
			 ?>
                    <a href="pages.php?action=showpage&id=<?php echo $page_ID; ?>"><div class="page-list">
                               <img src="images/page-icon.jpg" width="15" height="15"/>
                               <p><?php echo $page_name; ?></p>
                               </div>
                    </a>
			<?php endforeach ?>
			<?php else: ?>
					<div class="page_list">
						<p> You have not disliked any pages yet</p>
					</div>
			<?php endif; ?>


                         <!-- pages you own -->
                     <div id="pages_label3">
                           <p>Pages You Own</p>
                     </div>	
                            <!--page list starts here -->
			<?php if ($pagesOwned): ?>
			<?php $total = count($pagesOwned); ?>
			<?php foreach ($pagesO as $index => $pageO):
					$page_name = $pageO['page_name'];
					$page_ID = $pageO['page_ID'];
			?>
                     <a href="pages.php?action=showpage&id=<?php echo $page_ID; ?>"><div class="page-list">
                                <img src="images/page-icon.jpg" width="15" height="15"/>
                                <p><?php echo $page_name; ?></p>
                                </div>
                     </a>
			<?php endforeach; ?>
			<?php else: ?>
				<div class="page_list">
					<p>You don't own any pages</p>
				</div>
			<?php endif; ?>
                        <!-- create new page-->
                     <a href="pages.php"><div id="pages_label3">
                                <p>Create New Page</p>
                                </div>
                     </a>
                     </div>   <!--vertical ends-->


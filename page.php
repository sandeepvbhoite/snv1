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
<!DOCTYPE html>
<html>
	<?php include('view/header.html'); ?>  
   <body>
   <div id="main">
		<?php include('view/panel.html'); ?>            
         <div id="page">
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
                               <img src="images/page-icon.png" width="15" height="15"/>
                               <p><?php echo $page_name; ?></p>
                               </div>
                    </a>
			<?php endforeach ?>
			<?php else: ?>
					<div class="page_list">
						<p> This user has not liked any pages yet</p>
					</div>
			<?php endif; ?>
                         <!-- pages you own -->
                     <div id="pages_label2">
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
                                <img src="images/page-icon.png" width="15" height="15"/>
                                <p><?php echo $page_name; ?></p>
                                </div>
                     </a>
			<?php endforeach; ?>
			<?php else: ?>
				<div class="page_list">
					<p>This user doesn't own any pages</p>
				</div>
			<?php endif; ?>
                        <!-- create new page-->
                     <a href="pages.php"><div id="pages_label3">
                                <p>Create New Page</p>
                                </div>                     
                     </a>  
                                 
                     </div>   <!--vertical ends-->









            <div id="page_info">
            			<img src="<?php echo $pagepic; ?>" alt="" width="150" height="150"/>
                    <p><?php echo $pagename; ?></p>
                    <div id="page-button">

					<?php if (!$isOwner): ?>
						<?php if (!$isLiked): ?>
    	            	    <a href="pages.php?id=<?php echo $pageID; ?>&action=likepage" class="like-btn" title="Like This Page">Like</a>
						<?php else: ?>
            		        <a href="pages.php?id=<?php echo $pageID; ?>&action=unlikepage" class="like-btn" title="Unlike This Page">Unlike</a>
						<?php endif; ?>
					<?php endif; ?>

                    <a href="pages.php?action=showinfo&pageID=<?php echo $pageID; ?>" class="about-btn" title="Information of the Page">About</a>
                    </div>

            </div> 
            <div id="page_stream">
                
         <!--to post on page --> 
				<?php if ($isOwner): ?>
                   <div id="page-post-box">  
                       <div id="page-post">   
                          <img src="<?php echo $pagepic; ?>" alt="" width="50	" height="50"/>
		                    <div id="types">
		                        <ul>
		                            <li><a href="#" >Text/Link</a></li>
	             	                <li><a href="pages.php?action=topicpost&id=<?php echo $pageID; ?>">Image</a></li>
		                        </ul>
	                       </div>
                          <div id="box">
		                          <form id="status-form" action="pages.php" method="post" >
		                          <div id="textBox" >
		                          <input type="text" name="status" id="share-text" class="share-text" title="What's on your mind ? "/>
								  <input type="hidden" name="action" value="post" />
								  <input type="hidden" name="pageID" value="<?php echo $pageID; ?>" />
	                             </div>
		                          <input type="submit" id="share-button" class="share-text" value="post" title="share" />	
		                          <div id="dynaform"></div>
	       	                    </form>
      	                  </div>
                       </div>   <!--page-post closed-->
                     </div>
				<?php endif; ?>



                     <div id="page-posts">
						
					<?php
						$total = count($posts);
						foreach ($posts as $index => $post):
							$postID = $post['postID'];
							$postText = $post['postText'];
							$ifImage = $post['ifImage'];
							$timeOn = $post['timeOn'];
					?>
			              <div class="post" id="<?php echo $postID; ?>">
			                     <div class="pdata">
                                     <div class="entry">
                                     			<a href="#" class="entry2"><img src="<?php echo $pagepic; ?>" alt="userx" height="60" width="60" /></a>
                                             <a href="#" class="puser"><p><?php echo $pagename; ?></p></a>
                                             <div id="postbox"><p><?php echo $postText; ?></p><?php if($ifImage):?> <img src="<?php echo $ifImage; ?>" alt="" height="300" width="300" /><?php endif; ?></div>
                                             <div class="bottom-bar">
				                                       <div id="bottom_post">
				                                            <p><?php echo $timeOn; ?></p>
															<?php 
																$current_user = $_SESSION['userid'];
																$hasLikedPost = usersPagePostLike($current_user, $postID);
															?>
															<?php if ($hasLikedPost): ?>
					                                          <p>&nbsp;&nbsp;.&nbsp;&nbsp;<a href="pages.php?pageID=<?php echo $pageID; ?>&postID=<?php echo $postID; ?>&action=unlike" title="Unlike this post">Unlike</a>&nbsp;.</p>
															<?php else: ?>
					                                          <p>&nbsp;&nbsp;.&nbsp;&nbsp;<a href="pages.php?pageID=<?php echo $pageID; ?>&postID=<?php echo $postID; ?>&action=like" title="Like this post">Like</a>&nbsp;.</p>
															<?php endif; ?>
					                                    </div>
															<?php
																$likes = getPagePostLikes($postID);
																if ($likes >= 1):
															?>
					                                    <div id="likes" ><p><?php echo $likes; ?> People liked this</p></div>
															<?php else: ?>
														<div id="likes"><p>Likes yet to come<p></div>
															<?php endif; ?>
															<?php
																/* Fetch comments of current post from the database : */
																$comments = getCommentsOfPagePost($postID);
																$total = count($comments);
																foreach ($comments as $index => $comment):
																	$posterID = $comment['userID'];
																	$commentText = $comment['comment'];
																	$commentTime = $comment['timeOn'];
																	$nameOfCommenter = getUserName($posterID);
																	$picOfCommenter = getCurrentProfilePic($posterID);
																	$fname = $nameOfCommenter['fname'];
																	$lname = $nameOfCommenter['lname'];
															?>
					                                    <div class="comments">
															<img src="<?php echo $picOfCommenter; ?>" alt="<?php echo "$fname $lname"; ?>" height="30" width="30"/>
															<a href="profile.php?id=<?php echo $posterID; ?>" class="cuser"><p><?php echo " $fname $lname"?></p></a><p><?php echo $commentText; ?></p>
					                                          <div id="bottom_post" >
				                                                   <p><?php echo " $timeOn"; ?></p>
					                                          </div>
					                                     </div> 
														 <?php  endforeach; ?>
                                                   <div id="comment_box">
				                                            <p><img src="<?php echo $mypic; ?>" alt="<?php echo "$currentUserfname $currentUserlname"; ?>" height="30" width="30"/>
															<form action="pages.php" method="post" >
															 	<input type="text" name="comment" class="comment" />
																<input type="hidden" name="action" value="comment" />
																<input type="hidden" name="pageID" value="<?php echo $pageID; ?>" />
																<input type="hidden" name="postID" value="<?php echo $postID; ?>" />
															</form>
															</p>
				                                       </div> 				                            
				                                 </div>    
				                          </div>			                 
			                      </div> 
			              </div>


									<?php endforeach; ?>

<!--



			              <div class="post">
			                      <div class="pdata">
                                      <div class="entry">
                                             <a href="#" class="puser"><p>Page Owner</p></a>
                                             <div id="postbox"><p> ganpati bappa morya !! jai ganesh deva !</p><img src="bappa.jpg" alt="" height="300"width="300"></div>
                                             <div class="bottom-bar">
				                                       <div id="bottom_post">
				                                             <p> Friday, 28 Sept.2012</p><p>5:30 pm</p>
					                                          <p>&nbsp;&nbsp;.&nbsp;&nbsp;<a href="#" title="Like this post">Like</a>&nbsp;.</p>
					                                          <p><a href="#" title="">Comment</a>&nbsp;</p>
					                                    </div>
					                                    <div id="likes" ><p>10 people likes this</p></div>
					                                    <div class="comments"><img src="profile.jpg"alt="name" height="30" width="30"/><a href="" class="cuser"><p>Sandeep Bhoite</p></a><p>Ganpati Bappa Morya !!!</p>
					                                           <div id="bottom_post">
				                                                   <p> Friday, 28 Sept.2012 &nbsp;6:30 pm</p>
					                                                
					                                           </div>
					                                    </div> 
                                                   <div id="comment_box">
				                                             <p><img src="profile.jpg"alt="name" height="30" width="30"/><form action="#" method="post"><input type="text" name="comment" class="comment" value="write your comment here..."/></form></p>
				                                       </div> 				                            
				                                 </div>    
				                           </div>			                 
			                      </div>
			              </div> 
	-->		         </div>
                   
             </div>    <!-- page stream closed-->
		<?php include('view/footer.html'); ?>             
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

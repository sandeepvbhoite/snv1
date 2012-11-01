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
               <!-- profile page-->  
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
						<?php if($userid == $_SESSION['userid']): ?>
						<p> You have not liked any pages yet</p>
						<?php else: ?>
						<p> This user has not liked any pages</p>
						<?php endif; ?>
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
                                <img src="images/page-icon.jpg" width="15" height="15"/>
                                <p><?php echo $page_name; ?></p>
                                </div>
                     </a>
			<?php endforeach; ?>
			<?php else: ?>
				<div class="page_list">
					<?php if($userid != $_SESSION['userid']): ?>
					<p>This user doesn't own any pages</p>
					<?php else: ?>
					<p>You don't own any pages</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
                        <!-- create new page-->
                     <a href="pages.php"><div id="pages_label3">
                                <p>Create New Page</p>
                                </div>                     
                     </a>  
                                 
                     </div>   <!--vertical ends-->                
                   <div id="profile">
                    
                          <!-- Basic info -->          
                         <div id="basic_info" >
                                <div id="top" >
			                             <h2 class="top" class="title"><?php echo "$fname $lname"; ?></h2>		
		                                <p class="top"><?php echo $lastStatus; ?></p>
		                          </div>
		                         <div class="basicInfo">	
			                      <a href="#" ><img src="<?php echo $pic; ?>" alt="name of the person" height="160" width="150" /></a>
                               <p class="name"><b>Name:</b><?php echo " $fname $lname"; ?></p> 
			                      <p class="city"><b>Lives in:</b><?php echo " $city, $state, $country"; ?></p>
			                      <p class="sex"><b>Sex:</b><?php if($gender == 'm'){echo " Male";} else {echo " Female"; } ?></p>
			                      <p class="status"><b>Relationship Status:</b><?php echo " $status"; ?></p>
			                      <p class="dob"><b>Birthday:</b><?php echo " $birthday"; ?></p>
								  <?php $currentUser = $_SESSION['userid'];
								  		if ($currentUser == $userid):
									?>
								  <a href="profile.php?action=changepic" >Change Picture</a>
								  <a href="profile.php?action=deletepic" >Remove Pitcure</a>
								  <?php
								  		endif;
								  ?>

			                      </div>
		                   </div>
		                   
		                   <div id="connect">
						   			<?php 
										  if ($currentUser != $userid):
									?>

			                         <a href="messages.php?action=sendfirst&userid=<?php echo $userid; ?>">Send a Message</a>
									<?php if(!$isFriend): ?>
			                         <a href="friends.php?action=add&userid=<?php echo $userid; ?>">Send Friend Request</a>
									<?php else: ?>
									 <a href="friends.php?action=remove&friendID=<?php echo $userid; ?>">Remove Friend</a>
									<?php endif; ?>
									 <?php
									 	endif;
									 ?>
			                         <a href="profile.php?action=showinfo&id=<?php echo $userid; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Info&nbsp;&nbsp;&nbsp;&nbsp;</a>
			                         <a href="friends.php?userid=<?php echo $userid; ?>">&nbsp;&nbsp;Friends&nbsp;&nbsp;</a>
		                   </div>

	                    	 <div id="user-post-log">
	                    	       <div id="activity-title">
                                     <p>User Posts:</p>	                    	       
	                    	       </div>
						<?php 
							foreach ($posts as $index => $post):
								$postID = $post['postID'];
								$posterID = $post['userID'];
								$postText = $post['postText'];
								$ifImage = $post['ifImage'];
								$time = $post['timeOn'];
								$postername = $post['postername'];
								$posterFName = $postername['fname'];
								$posterLName = $postername['lname'];
								$comments = $post['comments'];
								$likes = $post['likes'];
								$userlike = $post['userlike'];
						?>

			            <div class="post" id="<?php echo $postID; ?>">
			            	<div class="pdata">
                        	<div class="entry">
                           	<a href="profile.php?id=<?php echo $posterID; ?>" class="entry2">
                              	<img src="<?php echo $pic; ?>" alt="<?php echo "$posterFName $posterLName"; ?>" height="60" width="60" /> 
                              </a>
                              <a href="profile.php?id=<?php echo $posterID; ?>" class="puser"><p><?php echo "$posterFName $posterLName"; ?></p></a>
                              	<div id="postbox"><p><?php echo $postText; ?></p><?php if ($ifImage): ?> <img src="<?php echo $ifImage; ?>" alt="" height="300" width="300" /><?php endif; ?> </div>
                                 	<div class="bottom-bar">
													<div id="bottom_post">
				                           	<p> <?php echo $time; ?></p>
					                           	<p>&nbsp;&nbsp;.&nbsp;&nbsp;
													<?php if ($userlike): ?> <a href="profile.php?action=unlike&postID=<?php echo $postID; ?>" title="Unlike this post">Unlike</a>
													<?php else: ?>			<a href="profile.php?action=like&postID=<?php echo $postID; ?>" title="Like this post">Like</a>
													<?php endif; ?>
												&nbsp;.</p>
					                        </div>
											
					                        <div id="likes" >
												<p><?php if ($likes > 0) : echo $likes; ?> people liked this<p>
												<?php else: ?>
												<p>Likes yet to come</p>
												<?php endif; ?>
											</div>
												<?php foreach($comments as $index => $comment): ?>
												<?php 	$userID   = $comment['userID'];
														$username = $comment['commentername'];
														$fname    = $username['fname'];
														$lname    = $username['lname'];
														$cp = $comment['cp'];
														$text     = $comment['comment'];
														$timeOn   = $comment['timeOn'];
												?>
												<div class="comments">
										
														<img src="<?php echo $cp; ?>" alt="<?php echo "$fname $lname"; ?>" height="30" width="30"/>
														<a href="" class="cuser"> <p><?php echo "$fname $lname"; ?></p></a>
														<p><?php echo $text; ?></p>
					                           <div id="bottom_post">
				                              	<p> <?php echo $timeOn; ?></p>
					                                    
					                           </div>
					                        </div>
											<?php 	endforeach; ?>
											<?php
													$ufname = $currentUserName['fname'];
													$ulname = $currentUserName['lname'];
											?>
                                       		<div id="comment_box">
				                           			<p>
												   		<img src="<?php echo $pic; ?>" alt="<?php echo "$ufname $ulname"; ?>" height="30" width="30"/>
															<form action="profile.php" method="post">
																<input type="hidden" name="action" value="comment" />
																<input type="hidden" name="postID" value="<?php echo $postID ?>" />
																<input type="text" name="comment" class="comment" />
												   		</form>
												   	</p>
				                           </div> 				                            
				                        </div>    
				            	</div>			                 
			               </div>
			            </div>
			           
			      <?php endforeach;?>

		            </div>  
					<?php include('view/footer.html'); ?>
             </div>   <!--page closed -->  
         </div>  <!-- main closed -->  
   </body>
</html> 

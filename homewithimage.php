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
			<?php include('verticalBar.php'); ?>
              <div id="share-box-end">  
                 <div id="share">  
                      <img src="<?php echo $pic; ?>" alt="profile pic" width="50" height="50"/>
		                 <div id="types">
		                     <ul>
		                         <li><a href="index.php" >Text/Link</a></li>
	             	             <li><a href="homewithimage.php">Image</a></li>
		                     </ul>
	                    </div>
                 <div id="box">
		                      <form id="status-form" action="index.php" method="post" enctype="multipart/form-data"  >
		                      <div id="textBox" >
		                         <input type="text" name="status" id="share-text" class="share-text" title="What's on your mind ? "/>
						         	 <input type="hidden" name="action" value="newpostwithimage" />
	                           </div>
		                         <input type="submit" id="share-button" class="share-text" value="post" title="share" />	
								 
				                			 
							    	  <input type="file" name="pic" size="19" class="img_file" title="browse for file"/>
								
								  <!-- <div id="dynaform"></div>-->
	       	                </form>
      	        </div>  <!-- #box closed -->
                 </div>   <!--share closed-->
               </div>
                      
        <div id="slink">
					<?php
						if($private) {
							$private_active = "class=\"active\"";
							$public_active  = "";
						} else {
							$private_active = "";
							$public_active  = "class=\"active\"";
						}
					?>
				    <a href=".?action=changestream&stream=1" <?php echo $private_active; ?>>PRIVATE</a> <!--<p>&nbsp;|&nbsp;</p>-->
				    <a href=".?action=changestream&stream=2" <?php echo $public_active; ?>>PUBLIC</a>		
	    </div>        
        <div id="stream">
			    <!-- starting posts  -->
	           <div id="posts">
	           		<?php
							if ($private):
						?>
						<?php 
							foreach ($posts as $index => $post):
								$postID = $post['postID'];
								$posterID = $post['userID'];
								$postText = $post['postText'];
								$time = $post['timeOn'];
								$postername = $post['postername'];
								$posterFName = $postername['fname'];
								$posterLName = $postername['lname'];
								$comments = $post['comments'];
								$likes = $post['likes'];
								$ifImage = $post['ifImage'];
								$userlike = $post['userlike'];
								$posterpic = $post['posterpic'];
						?>

			            <div class="post" id="<?php echo $postID; ?>">
			            	<div class="pdata">
                        	<div class="entry">
                           	<a href="profile.php?id=<?php echo $posterID; ?>" class="entry2">
                              	<img src="<?php echo $posterpic; ?>" alt="<?php echo "$posterFName $posterLName"; ?>" height="60" width="60" /> 
                              </a>
                              <a href="profile.php?id=<?php echo $posterID; ?>" class="puser"><p><?php echo "$posterFName $posterLName"; ?></p></a>
											<div id="postbox"><p><?php echo $postText; ?></p><?php if($ifImage):?> <img src="<?php echo $ifImage; ?>" alt="" height="300"width="300"><?php endif; ?></div>
                                 	<div class="bottom-bar">
													<div id="bottom_post">
				                           	<p> <?php echo $time; ?></p>
					                           	<p>&nbsp;&nbsp;.&nbsp;&nbsp;
													<?php if ($userlike): ?> <a href="index.php?action=unlike&postID=<?php echo $postID; ?>" title="Unlike this post">Unlike</a>
													<?php else: ?>			<a href="index.php?action=like&postID=<?php echo $postID; ?>" title="Like this post">Like</a>
													<?php endif; ?>
												&nbsp;.</p>
					                        </div>
											
					                        <div id="likes" >
												<p><?php if ($likes > 0) : echo $likes; ?> people liked this<?php endif; ?></p>
											</div>
												<?php foreach($comments as $index => $comment): ?>
												<?php 	$userID   = $comment['userID'];
														$username = $comment['commentername'];
														$fname    = $username['fname'];
														$lname    = $username['lname'];
														$commenterpic = $comment['commenterpic'];
														$text     = $comment['comment'];
														$timeOn   = $comment['timeOn'];
												?>
												<div class="comments">
										
														<img src="<?php echo $commenterpic; ?>" alt="<?php echo "$fname $lname"; ?>" height="30" width="30"/>
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
															<form action="index.php" method="post">
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
					<?php else:  ?>

					<?php
			
						foreach ($pub_posts as $index => $post):
							$postID = $post['postID'];
							$pageID = $post['pageID'];
							$postText = $post['postText'];
							$time = $post['timeOn'];
							$name = $post['pagename'];
							$comments = $post['comments'];
							$likes = $post['totallikes'];
							$userlike = $post['userlike'];

					?>
			            <div class="post" id="<?php echo $postID; ?>">
			                 <div class="pdata">
                                  <div class="entry">
                                         <a href="pages.php?id=<?php echo $pageID; ?>" class="entry2"><img src="sample.png" alt="<?php echo "$name"; ?>" height="60" width="60" /></a>
                                         <a href="pages.php?id=<?php echo $pageID; ?>" class="puser"><p><?php echo "$name"; ?></p></a>
                                         <div id="postbox">
                                         	<p><?php echo $postText; ?></p>
                                         </div>
                                          <div class="bottom-bar">
				                                    <div id="bottom_post">
				                                          <p><?php echo $time; ?></p>
					                                       <p>&nbsp;&nbsp;.&nbsp;&nbsp;

													<?php if ($userlike): ?> <a href="index.php?action=unlikepagepost&pagepostID=<?php echo $postID; ?>" title="Unlike this post">Unlike</a>
													<?php else: ?>			<a href="index.php?action=likepagepost&pagepostID=<?php echo $postID; ?>" title="Like this post">Like</a>
													<?php endif; ?>
		 
														   &nbsp;.</p>
					                                 </div>
													<div id="likes" ><p><?php if ($likes > 0) : echo $likes; ?> people liked this<?php endif; ?></p></div>
													 <?php foreach ($comments as $index => $comment): ?>
													 <?php 		$userID = $comment['userID'];
													 			$name   = $comment['commentername'];
																$fname  = $name['fname'];
																$lname  = $name['lname'];
																$commentText = $comment['comment'];
																$time = $comment['timeOn'];
													 ?>
					                                 <div class="comments"><img src="sample.png" alt="<?php echo "$fname $lname"; ?>" height="30" width="30"/>
													 	<a href="profile.php?id=<?php echo $userID; ?>" class="cuser"><p><?php echo "$fname $lname"; ?></p></a>
														<p><?php echo $commentText; ?></p>
					                                  <div id="bottom_post">
				                                          <p><?php echo $time; ?></p>
					                                  </div>
					                                 </div>
													 <?php endforeach; ?>
													 <?php 
															$ufname = $currentUserName['fname'];
															$ulname = $currentUserName['lname'];
													 ?>
                                                  <div id="comment_box">
				                                   <p>
												   	<img src="<?php echo $pic; ?>" alt="<?php echo "$ufname $ulname"; ?>" height="30" width="30"/>
														<form action="index.php" method="post">
															<input type="hidden" name="action" value="commentonpage" />
															<input type="text" name="comment" class="comment" />
															<input type="hidden" name="pagepostID" value="<?php echo $postID; ?>" />
														</form>
												   </p>
				                                  </div> 				                            
				                             </div>    
				                                                          
                                  </div>			                 
			                 </div>
			                       
			           </div>
				<?php endforeach;?>
				<?php endif; ?>

			                       
			           </div>
			         
			        
	      	                                           
	     </div>	      <!-- stream closed -->          
       	<?php include('view/footer.html'); ?>	
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>


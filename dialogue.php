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
               <div id="message-dialogue">
					<hr />
					<h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="messages.php?action=showdialogue&convID=<?php echo $convID; ?>" >Refresh Page</a>
					</h5>
					<hr />
                     <fieldset>
                             	<ol>
								<?php
									$total = count($messages);
									for( $i=$total-1; $i>-1; --$i):
										$senderID = $messages[$i]['senderID'];
										$receiverID = $messages[$i]['receiverID'];
										$message    = $messages[$i]['msgText'];
										$time       = $messages[$i]['onTime'];
										$senderName = $messages[$i]['senderName'];
										$senderfname = $senderName['fname'];
										$senderlname = $senderName['lname'];
										$receiverName = $messages[$i]['receiverName'];
								?>

                                  <li>
                                       <div class="dialogue_entry">
                                               <img src="<?php echo getCurrentProfilePic($senderID); ?>" alt="<?php echo "$senderfname $senderlname"; ?>" height="40" width="40"/>
                                               <a href="profile.php?id=<?php echo $senderID; ?>" class=""><p><?php echo "$senderfname $senderlname"; ?></p></a>
                                               <p class="dialogue-data"><?php echo " $message"; ?></p>
					                                <div id="bottom_post">
				                                        <p><?php echo " $time"; ?></p>
					                                </div>
					                         </div> 
                                 </li>
								<?php 
									endfor;
								?>
                                                  	
                           	</ol>
                           	<ol>
                                    <li>
                                         <div class="reply">
                                             
                                             <form action="messages.php" method="post">
                                                 <input type="text" name="msg" class="repmsg"/> 
												 <input type="hidden" name="receiverID" value="<?php echo $recID; ?>" />
												 <input type="hidden" name="convID" value="<?php echo $convID; ?>" />
												 <input type="hidden" name="action" value="send" />
                                                 <input type="submit" name="send_reply" value="Send" class="sendbtn"/>
                                             </form>                                       
                                         </div>	                                    
                                    </li>                           	
                           	
                           	
                           	</ol>
                     </fieldset>
               </div>         
          
         <?php include ('view/footer.html'); ?>
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

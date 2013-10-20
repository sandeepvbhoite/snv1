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
               <div id="message">    
                            <div id="Inbox_label"><p>Inbox</p></div>
                 
							<?php 
								foreach ( $conversations as $convID => $conversation ):
									$fname = $conversation['fname'];
									$lname = $conversation['lname'];
									$msg   = $conversation['message'];
									$timeOn = $conversation['timeOn'];
									$userID = $conversation['userID'];
									$pic = getCurrentProfilePic($userID);
							?>


                            <!--  message entry-->                                 
                                 <a href="messages.php?action=showdialogue&convID=<?php echo $convID; ?>"><div class="message_entry"><img src="<?php echo $pic; ?>"  height="30" width="30">
                                             <p  class="msender"><?php echo "$fname $lname"; ?></p>
                                             <div id="mesg-data"><p><?php echo $msg; ?></p></div>
          		                              <div id="bottom_post"> 
				                                      <p><?php echo " $timeOn"; ?></p>
					                              </div>
					                              </div>
					                  </a>
							<?php
								endforeach;
							?>
				             
              </div>         

		<?php include('view/footer.html'); ?>
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

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
                <div id="friend-requests">
                       <h2>Friend Requests:</h2>
 				<?php 
					$totalRequests = count($requestsReceived);
					for ($i=0; $i<$totalRequests; $i++):
						$id = $requestsReceived[$i];
						$friend = getUserName($id);
						$fname  = $friend['fname'];
						$lname  = $friend['lname'];
				?>
       
                             <ul id="friends_main1">	
                             	  <li><p><img src="<?php echo getCurrentProfilePic($id); ?>" width="100" height="110" alt="" /></p>
                             	  <p class="desc"><a href="profile.php?id=<?php echo $requestsReceived[$i]; ?>"><?php echo "$fname $lname"; ?></a></p>    
                                <p class="accept"><a href="friends.php?ofUserID=<?php echo $requestsReceived[$i]; ?>&action=accept">Accept</a></p>
                                <p class="reject"><a href="friends.php?ofUserID=<?php echo $requestsReceived[$i]; ?>&action=reject" >Reject</a></p>                             
                           	  </li>
	                         </ul>
				<?php endfor; ?>

               </div>
               <div id="friend-requested">
                      <h2>Friend Requests Sent:</h2>
     			<?php
					$totalRequests = count($requestsSent);
					for ($i=0; $i<$totalRequests; $i++):
						$id = $requestsSent[$i];
						$friend = getUserName($id);
						$fname  = $friend['fname'];
						$lname  = $friend['lname'];
				?>
 
                           <ul id="friends_main2">	
                             	  <li><p><img src="<?php echo getCurrentProfilePic($id); ?>" width="100" height="110" alt="" /></p>
                             	  <p class="desc"><a href="profile.php?id=<?php echo $requestsSent[$i]; ?>"><?php echo "$fname $lname"; ?></a></p>    
                                <p class="cancel"><a href="friends.php?toUserID=<?php echo $requestsSent[$i]; ?>&action=cancel">Cancel</a></p>
                                </li>
	   
                          	</ul>
				<?php endfor; ?>

                       </div>
                               
               <div id="friends">
                      <h2>Friends:</h2>
                      
      			<?php 
					$totalFriends = count($friends);
					for ($i=0; $i<$totalFriends; $i++):
						$id = $friends[$i];
						$friend = getUserName($id);
						$fname  = $friend['fname'];
						$lname  = $friend['lname'];
				?>

                           <ul id="friends_main3">	
                             	  <li><p><img src="<?php echo getCurrentProfilePic($id); ?>" width="100" height="110" alt="" /></p>
                             	  <p class="desc"><a href="profile.php?id=<?php echo $friends[$i]; ?>"><?php echo "$fname $lname"; ?></a></p>    
                                <p class="remove"><a href="friends.php?friendID=<?php echo $friends[$i]; ?>&action=remove">Remove</a></p>
                                </li>
	   
                          	</ul>
                <?php endfor; ?>
                  </div>   
				<?php include('view/footer.html'); ?>
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>


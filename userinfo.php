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
         	   <div id="Info"> 
         	         <div id="personal_info">
         	                   <p class=""><b>Personal Information</b></p> 
							   <?php if ($userid == $_SESSION['userid']): ?>
							   <a href="profile.php?action=editpi" class="edit">Edit Info</a>
	    					   <?php	endif; ?> 
			                      <p class=""><b>Name:</b><?php echo " $fname $lname"; ?></p>
                               <p class=""><b>Sex:</b><?php if($gender == 'm') {echo " Male";} else {echo " Female";} ?><p>  			                     
			                      <p class=""><b>Lives In:</b><?php echo " $city, $country"; ?></p>
                               <p class=""><b>Birthday:</b><?php echo " $birthday"; ?></p>  
                               <p class=""><b>Relationship Status:</b><?php echo " $status"; ?></p>        
			                      <p class=""><b>Education:</b><?php echo " $education"; ?></p>
			                      <p class=""><b>Languages Known:</b><?php echo " $languages"; ?></p>  		
		               </div>
		             
         	         
         	  	      <div id="contact_info">
			                      <p class="type"><b>Contact Information</b></p> 
								  <?php if ($userid == $_SESSION['userid']): ?>
								  <a href="profile.php?action=editci" class="edit">Edit Info</a>
								  <?php endif; ?>
			                      <p class="address"><b>Address:</b><?php echo " $city, $state, $country"; ?></p>
                        		 <p class="email"><b>E-Mail:</b><?php echo " $emailAddress"; ?></p>
			                      <p class="website"><b>Website:</b><?php echo " $website"; ?></p>
			                      <p class="mobile"><b>Mobile:</b><?php echo " $mobile"; ?></p>		
		               </div>
		         </div>      
			<?php include('view/footer.html'); ?>
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>


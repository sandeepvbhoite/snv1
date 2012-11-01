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
             <div id="search-page-peoples">
                        <p class="allresults">All Results :</p>    
                        <div id="search-link">
   				               <a href="index.php?action=search&query=<?php echo $query; ?>&type=people" <?php if($people): ?>class="active"<?php endif; ?>>PEOPLE</a> <!--<p>&nbsp;|&nbsp;</p>-->
                               <a href="index.php?action=search&query=<?php echo $query; ?>&type=pages" <?php if($pages): ?> class="active"<?php endif; ?>>PAGES</a>		
	                     </div>                                
                               <hr><hr>
                               
                         <div id="search_entry">
                               <ol>
							   	<?php
									foreach ($results as $index => $result):
										$userID = $result['userID'];
										$fname = $result['fname'];
										$lname = $result['lname'];
										$pic = $result['pic'];
										$city = $result['city'];
										$age = $result['age'];
								?>
                                   <li>
                                        <img src="<?php echo $pic; ?>" alt="<?php echo "$fname $lname"; ?>" height="60" width="60" />
                                        <a href="profile.php?id=<?php echo $userID; ?>" class="fname"><?php echo "$fname $lname"; ?></a>
                                        <p>Lives in : <?php echo $city; ?></p>
                                        <p>Age : <?php echo $age; ?> years old</p>
                                        <div id="task-bar">
                                             <a href="messages.php?action=sendfirst&userid=<?php echo $userID; ?>" >Send Message</a>                                        
                                        </div>                                 
                                   </li> 
								<?php
									endforeach;
								?>
                                                                 
                               </ol>
                                                      
                         </div>
             </div>
			<?php include('view/footer.html'); ?>	
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

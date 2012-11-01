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
                <div id="page-info-display">
                                
                            <label> About  </label>
                             <hr>
         	                        <p class=""><b>About:</b>&nbsp;&nbsp;<div id="info-text"><?php echo $page['about']; ?></div></p>
			                   <label> Basic Info.</label> 	
			                   <hr>
                                     <p class=""><b>Name:</b>&nbsp;&nbsp; <?php echo $page['name']; ?></p>
                                     <p class=""><b>Born:</b>&nbsp;&nbsp; <?php echo $page['born']; ?></p>     
			                            <p class=""><b>City:</b>&nbsp;&nbsp; <?php echo $page['city']; ?></p>
			                            <p class=""><b>State:</b>&nbsp;&nbsp; <?php echo $page['state']; ?></p>  	    	                     
			                            <p class=""><b>Country:</b>&nbsp;&nbsp; <?php echo $page['country']; ?></p>
			                  <label>Contact Info.</label>  
                           <hr>              
                                     <p class=""><b>Website:</b>&nbsp;&nbsp; <?php echo $page['web']; ?></p>  
                                     <p class=""><b>Contact No.:</b>&nbsp;&nbsp; <?php echo $page['tele']; ?></p>        
			                            <p class=""><b>E-mail:</b>&nbsp;&nbsp; <?php echo $page['email']; ?></p>
			                  <label>History</label>
                            <hr>			                     
			                            <p class=""><b>History:</b>&nbsp;&nbsp;<div id="info-text"><?php echo $page['history']; ?></div></p>  	
              </div>          
         
         
         
         
        <?php include ('view/footer.html'); ?> 
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

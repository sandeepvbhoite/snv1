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
              <div id="update">
                        <fieldset>
                             <legend>Update Your Contact Info </legend>
                                <form action="profile.php" method="post" class="setForm">
                                 <ol>
                                   <li>
									  <label>City:</label>
									  <input type="text" name="city" value="<?php echo $city ?>" />
                                   </li>
								   <li>
								   		<label>State:</label>
										<input type="text" name="state" value="<?php echo $state; ?>" />
								   </li>
								   <li>
										<label>Country:</label>
										<input type="text" name="country" value="<?php echo $country; ?>" />
								   </li>
		
                                   <li>
                                      <label>E-mail: </label>
                                      <input type="text" name="email" value="<?php echo $email; ?>" />
                                   </li>
                                   <li>
                                       <label>Website:</label>
                                       <input type="text" name="website" value="<?php echo $website; ?>" />
                                   </li>
                                   <li>
                                       <label>Mobile:</label>
                                       <input type="text" name="mobile" value="<?php echo $mobile; ?>" />
                                  </li>
                                  </ol>				
								  						<input type="hidden" name="action" value="editci" />
    	    											<input type="submit" id="send" value="Submit" />
        									  </form>	
		                      
                        </fieldset>			
                         
              </div>
          
		<? include('view/footer.html'); ?>	
        </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

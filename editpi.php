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
                             <legend>Update Your Personal Info </legend>
                                <form action="profile.php" method="post" class="setForm">
                                 <ol>
                                   <li>
                                      <label>First Name: </label>
                                      <input type="text" name="fname" value="<?php echo $fname; ?>" />
                                   </li>
								   <li>
								   		<label>Last Name: </label>
										<input type="text" name="lname" value="<?php echo $lname; ?>" />
                                   <li>
                                       <label>Current City:</label>
                                       <input type="text" name="city" value="<?php echo $city; ?>"/>
                                   </li>
                                   <li>
                                       <label>Birthday:</label>
									<select name="year">
                             		<?php for($i=1999; $i>1900; $i--) { ?>
										<option value="<?php echo $i; ?>" <?php if($year == $i) { echo "selected=\"selected\""; }?>><?php echo $i;?></option>
									<?php } ?>
									</select>
									<select name="month">
									<?php for($i=12; $i>=1; $i--) { ?>
										<option value="<?php echo $i; ?>" <?php if($month == $i) { echo "selected=\"selected\""; }?>><?php echo $i;?></option>
									<?php } ?>
									</select>
									<select name="day">
									<?php for($i=1; $i<=31; $i++) { ?>
										<option value="<?php echo $i; ?>" <?php if($day == $i) { echo "selected=\"selected\""; }?>><?php echo $i;?></option>
									<?php } ?>
									</select>

                                   </li>
                                   <li>
                                       <label>Relationship Status:</label>
                                       <select name="status" >
                                    		<option value="Single" <?php if ($status == 'Single') { echo "selected=\"selected\""; }?>>Single</option>
                                       		<option value="In a relation" <?php if ($status == 'In Relationship') { echo "selected=\"selected\""; }?>>In Relationship</option>
                                      		<option value="Complicated" <?php if ($status == 'Complicated') { echo "selected=\"selected\""; }?>>Complicated</option>
                                       		<option value="Married" <?php if ($status == 'Married') { echo "selected=\"selected\""; }?>>Married</option>
                                       </select>
                                  </li>
                                  <li>
                                       <label>Education:</label>
                                       <input type="text" name="education" value="<?php echo $education; ?>" />
                                  </li>
                                  <li>	
                                      <label>Languages Known:</label>
                                      <input type="text" name="languages" value="<?php echo $languages; ?>" />
                                  </li>
                                  </ol>					<input type="hidden" name="action" value="editpi" />
    	    											<input type="submit" value="Submit" id="send" />
        									  </form>	
		                      
                        </fieldset>			
                         
              </div>
         <?php include('view/footer.html'); ?> 
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

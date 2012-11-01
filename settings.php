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
<?php

	session_start();
	require_once ('model/database.php');
	require_once ('model/userInfo.php');
	if (!isset($_SESSION['userid'])) {
		include ('loginpage.php');
	} else {
		$userid = $_SESSION['userid'];

	
?>

<!DOCTYPE html>
<html>
	<?php include('view/header.html'); ?> 
   <body>
   <div id="main">
		<?php include('view/panel.html'); ?>           
         <div id="page">
               <div id="settings">
			   <?php echo $msg; ?>
                    <div id="password">
                         <fieldset >
		                             <legend>Change your Password</legend>
	                                <form action="changeSetting.php" method="post" class="setForm">
		                                      <ol>
											  					<li>
																	<label>Old password</label>
																<input type="password" name="old" class=p1" />
																</li>

	    												    	<li>
	        														<label>New password</label>
    		   													<input type="password" name="password" class="p1" />
        													   </li>
	        											      <li>
	        													   <label>Confirm</label>
    		   													<input type="password" name="password2" class="p1" />
        														</li>        		
    	    											  </ol>	
    	    														<button type="submit" id="send">Update</button>
    	    														<button type="reset" id="">Reset</button>
        									  </form>	
		                    </fieldset>
	                 </div>	
               </div>         
              </div>
			<?php include('view/footer.html'); ?>	
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>
<?php
	}
?>

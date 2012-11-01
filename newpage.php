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
               <div id="newpage">
                     <fieldset>
                             <p>Please Select Category Of Page : </p>
                                  <form method="post" action="pages.php" >
                                        <p><select name="type" > 
                                                 <option value="celeb" >Celebrity</option>
                                                 <option value="corp" >Organisation/Company</option>
                                                 
                                           </select></p>
                                           
										   <input type="hidden" name="action" value="newpage" />
                                           <p><input type="submit" value="Continue" class="submit-btn"/></p>	
                                     </form>
                                  
                     </fieldset>
               </div>    
		<?php include('view/footer.html'); ?>
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

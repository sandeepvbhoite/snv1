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
                     <fieldset>
                             	<ol>
                             <p>Send your first message to this user!</p>                   	
                           	</ol>
                           	<ol>
                                    <li>
                                         <div class="reply">
                                             
                                             <form action="messages.php" method="post">
                                                 <input type="text" name="msg" class="repmsg"/> 
												 <input type="hidden" name="toUserID" value="<?php echo $toUserID; ?>" />
												 <input type="hidden" name="action" value="sendfirst" />
                                                 <input type="submit" name="send_reply" value="Send" class="sendbtn"/>
                                             </form>                                       
                                         </div>	                                    
                                    </li>                           	
                           	
                           	
                           	</ol>
                     </fieldset>
               </div>         
         <?php include('view/footer.html'); ?> 
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

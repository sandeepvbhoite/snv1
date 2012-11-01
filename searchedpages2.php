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
                                   			$pageID = $result['pageID'];
                                   			$name = $result['name'];
                                   	?>
                                   	<li>
                                        <img src="<?php echo getPagePic($pageID); ?>" alt="" height="60" width="60" >
                                        <a href="pages.php?action=showpage&id=<?php echo $pageID; ?>" class="pagename"><?php echo $name; ?></a>
										<?php $type = getTypeOfPage($pageID) ?>
										<?php if ($type == '1'): ?>
                                        <p>Type : Celebrity</p>
										<?php else: ?>
										<p>Type : Corporation</p>
										<?php endif; ?>
                                        <div id="task-bar">
                                        	<?php if(!isOwner($userid, $pageID)): ?>
                                        		<?php if(!isLiked($userid, $pageID)): ?>
                                       		        <a href="pages.php?action=likepage&id=<?php echo $pageID; ?>" >Like This Page</a>
                                           		 <?php else: ?>
                                             		<a href="pages.php?action=unlikepage&id=<?php echo $pageID; ?>" >Unlike This Page</a>	
                                            	<?php endif; ?>   
                                            <?php endif; ?>                                     
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

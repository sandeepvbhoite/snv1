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
               <div id="newpage_inputdata">
                     <fieldset>
                          <form method="post" action="pages.php" class="setform" enctype="multipart/form-data">
						  	 <ol>
							 		<label><p>Select an image</p></label>
									<li>
									<label>Select:</label>
									<input type="file" name="pic" />
									</li>
							 </ol>
                              <ol>
                                       <label><p>About</p></label>
    	    								   
    	    								   <li>  
                                        <label>About:</label>    	    								      
    	    								       <textarea rows="2" cols="40" name="about" ></textarea>  
    	    								   </li>			
    	    											
    	    						 </ol>                             
                              <ol>
                                        <label><p>Basic Information</p></label>
                                  <li>
                                       <label>Name:</label>
                                       <input type="text" name="name"/>
                                       
                                   </li>
                                        
                                   <li>
                                      <label>Born: </label>
                                   		<select name="year">
											<?php for($i=1999; $i>1900; $i--) { ?>
											<option value="<?php echo $i; ?>"><?php echo $i;?></option>
											<?php } ?>
										</select>
									<select name="month">
										<?php for($i=12; $i>=1; $i--) { ?>
										<option value="<?php echo $i; ?>"><?php echo $i;?></option>
										<?php } ?>
									</select>
									<select name="day">
										<?php for($i=1; $i<=31; $i++) { ?>
										<option value="<?php echo $i; ?>"><?php echo $i;?></option>
										<?php } ?>
									</select>

                                   </li>
                                   <li>
                                       <label>City:</label>
                                       <input type="text" name="city" />
                                   </li>
                                   <li>
                                       <label>State:</label>
                                       <input type="text" name="state" />
                                  </li>
                                   <li>
                                       <label>Country:</label>
                                       <input type="text" name="country" />
                                  </li>                             
                             </ol>	
                             
    	    						 <ol>
                                     <label><p>Contact Information</p></label>    	    						 
                                
                                    <li>
                                       <label>Website:</label>
                                       <input type="text" name="website" />
                                    </li>
                                    <li> 
                                        <label>Contact No.:</label>
                                        <input type="text" name="telephone" />
                                    </li> 
                                    <li> 
                                        <label>E-mail:</label>
                                        <input type="text" name="email" />
                                    </li> 	    						        
    	    						        
    	    						 </ol>	
    	    						 <ol>
                                       <label><p>History</p></label>
    	    								   
    	    								   <li>  
                                        <label>History:</label>    	    								      
    	    								       <textarea rows="1" cols="40" name="history" > </textarea>  
    	    								   </li>			
    	    											
    	    						 </ol>		
    	    											
  									<input type="hidden" name="action" value="createpageceleb" />  	    											
    	    											
    	    											
    	    											<button type="submit" id="send">Submit</button>
    	    				    						<button type="reset" id="">Reset</button>
        							</form>
                                  
                     </fieldset>
               </div>    
			   <?php include('view/footer.html'); ?>
         </div> <!--page closed-->          
       </div> <!-- main closed--> 
   </body>
</html>

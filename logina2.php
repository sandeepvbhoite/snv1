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
<html>
  <head>
        <title>SNv1 : Try again!</title>
        <style type="text/css">
              body{
	                   margin:0;
                      padding:0;
	                   border:0;		       /* This removes the border around the viewport in old versions of IE */
	                   width:100%;
                      min-width:600px;		/* Minimum width of layout - remove line if not required */
	                   				         /* The min-width property does not work in old versions of Internet Explorer */
	                   font-size:90%;
                      background-image:url('images/login-background.jpeg');                    
                   }        
               #main{
	                    width: 100em;
	                  
                    }
               #panel{
                     	width: 100%;
                     	height: 32px;
                     	background-color: #3e3e3e;
                     }   
              #login{  
                       padding:10px;
                       margin-top:45px;
                       margin-left:200px;
                       background-color:#efefef; 
                       width: 360px;
                       border-radius:10px;
                       opacity:.5;
                     }    
                     #signup-error{  
                       padding:10px;
                       margin-top:70px;
                       float: right;
                       margin-right:450px;
                       background-color:#efefef; 
                       width: 360px;
                       border-radius:10px;
                       opacity:.5;
                     }     
                     #login #form-login{
                       background-image:url('images/white.png'); 
                       padding:10px;
                       opacity:1; 
                       border-radius:5px;                     
                       background-color:#fff;  
                       margin:5px; 
                     }  
                     #error-msg{
                       background-image:url('images/white.png'); 
                       padding:10px;
                       line-height:15px; 
                       color: red;
                       font-weight:bold; 
                       border-radius:5px;                     
                       background-color:#fff;  
                       margin:5px; 
                     }    
                     .fname_error{
                      margin-top:10px;                    
                     }   
                     .email_error{
                     margin-top:90px; }      
               #login form{
                         width:250px; 
                         margin-left:10px;
                     }
                     .username{
                     height:30px;
                     padding-left:5px;
                     width:300px;
                     color:#000;
                     font-size:15px;
                     font-weight:bold;   
                     border:1px solid #999;
                     border-radius:5px; 
                     background-color:#fff;
                     margin-bottom:5px;
                      }
                    .password{
                      height:30px;
                     width:200px;
                     color:#000;
                     padding-left:5px;
                     font-size:15px;
                     font-weight:bold;   
                     border-radius:5px; 
                     border:1px solid #999;
                     background-color:#fff;
                     }
                     .signin{
                      float: right;
                      margin-right:-30px;                     
                      margin-top:5px;
                      padding:8px 10px;
                      background-image:url('images/blue.png'); 
                      font-weight:bold;
                      border:none;
                      border-radius:5px;
                       }
                     #signup{
                     padding:10px;
                       margin-top:10px;
                       margin-left:200px;
                       background-color:#dedede;
                       width: 360px;
                       border-radius:10px;
                       opacity:.7;
                     }
                     #signup #form-signup{
                       opacity:1;
                      padding:10px 10px 15px 10px;
                      border-radius:5px;                     
                      background-image:url('images/white.png');                      
                      background-color:#fff;  
                     margin:5px; 
                     
                     }
                      #signup #form-signup p{
                      font-size:17px;
                      margin-bottom:25px; 
                      color:#aa00bb; 
                      font-weight:bold;
                      opacity: 1;
                      }
                     #signup #form-signup label{
                     font-size:14px;
                     font-weight:bold; 
                     }
                                                    
                    .year{     
            
                      margin-bottom:5px;
                      margin-left:28px;
                   padding:7px; 
                   font-weight: bold;   
                     
                    }
                    .day,.month{   margin-bottom:5px;  padding:7px; font-weight: bold;   
                     }
                    .gender { margin-left:60px; font-weight: bold;   
                    padding:7px;  margin-bottom:5px;
                    }
                    .lastname { padding-left:5px; 
                     font-size:13px;
                     font-weight:bold;
                     border-radius:5px;                     
                     background-color:#fff; 
                     color:#000;height: 25px;border:1px solid #999;  margin-bottom:5px; margin-left:17px;
                     }
                    .firstname{ 
                            padding-left:5px; 
                     font-size:13px;
                     border:1px solid #999; 
                     font-weight:bold;
                     border-radius:5px;                     
                      background-color:#fff; 
                     color:#000; height: 25px;margin-left:15px;  margin-bottom:5px;
                     }
                   .email{ 
                     padding-left:5px; 
                     font-size:13px;
                     font-weight:bold;
                     border-radius:5px;                     
                     background-color:#fff; 
                     color:#000; height: 25px;margin-left:43px;border:1px solid #999;  margin-bottom:5px;
                     }	
                     .signuppassword{     padding-left:5px; 
                     font-size:13	px;
                     font-weight:bold;    
                     border-radius:5px;                     
                     background-color:#fff; 
                     color:#000; height: 25px;margin-left:21px;border:1px solid #999;  margin-bottom:5px;
                     }
                      .signupsubmit{font-weight: bold;   border:none;
                      border-radius:5px;margin-bottom:5px;  float: right;	margin-top: 7px;padding:8px 10px;background-image:url('images/green.png'); 
                       }
                       #footer {
                            
                              	width: 1200px;
	                               height: 35px;
                              	 margin:0 auto;	
	                              padding: 0; 
                                  margin-top:15px; 	                          
	                             border-top: 1px solid #eee;
                                }
                      #footer p {
                               	margin: 0;
                              	padding: 15px 0px 0px 0px;
	                              text-align: center;
                                	line-height: normal;
	                              color: #444;
                              	font-size: 12px;
                                }
          </style>    
 </head>
    <body> 
   <div id="main">
         <div id="panel"></div>
                 
                  <div id="login">
                      <div id="form-login">
                                       
                       <form action="login.php"  method="post">
                           <input type="text" name="email" class="username"/>
                           <input type="password" name="password" class="password"/>
                           <input type="submit" value="Sign In" class="signin" title="Sign In"/>
                       </form>
                      </div>
                 </div>
                 <!--error part-->
                 <div id="signup-error">
                    <div id="error-msg">
                          <p class="fname_error"><?php echo $fnameerror; ?></p>  
                          <p class="lname_error"><?php echo $lnameerror; ?></p> 
                          <p class="dob_error"><?php echo $dateError; ?></p>
                          <p class="email_error"><?php echo $emailerror; ?></p>  
                          <p class="fname_error"><?php echo $passworderror; ?></p>  
                	                  
                                                                      
                    </div>
                 </div>
                 <div id="signup">
                       <div id="form-signup">
                        <p>New Member ? &nbsp;Sign up</p>
     <form action="signup.php" method="post">
		<label>First Name:</label>
	   <input type="text" name="firstName" class="firstname"/>
	   <br />
		<label>Last Name:</label>
		<input type="text" name="lastName" class="lastname"/>
		<br />
		<label>Birthday:</label> 
		<select name="year">
				<option value="false">Year:</option>
			<?php for($i=1999; $i>1900; $i--) { ?>
				<option value="<?php echo $i; ?>"><?php echo $i;?></option>
			<?php } ?>
		</select>
		<select name="month">
				<option value="false">Month:</option>
			<?php for($i=12; $i>=1; $i--) { ?>
				<option value="<?php echo $i; ?>"><?php echo $i;?></option>
			<?php } ?>
		</select>
		<select name="day">
				<option value="false">Day:</option>
			<?php for($i=1; $i<=31; $i++) { ?>
				<option value="<?php echo $i; ?>"><?php echo $i;?></option>
			<?php } ?>
		</select>


		<br />
		<label>Sex:</label>
		<select name="gender" class="gender">
			<option value="m">Male</option>
			<option value="f">Female</option>
		</select>
		<br />
		<label>Email: </label>
		<input type="text" name="emailAddress" class="email" />
		<br />
		<label>Password: </label>
		<input type="password" name="password" class="signuppassword" />
		<input type="submit" value="Submit"  class="signupsubmit" title="Sign up" />
		<br />
		<br />
	</form>

                       </div>
                 </div>   <!-- sign up closed -->
               
           <div id="footer">
   		        <p>Copyright (c) 2012 SNv1. All rights reserved.</p>
           </div>
	
          </div> 
   </body>
</html>

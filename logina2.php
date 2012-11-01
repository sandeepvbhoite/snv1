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
        <title>SocialNetwork/Login/Signup/errorpage</title>
        <style type="text/css">
              body{
	                   margin:0;
                      padding:0;
	                   border:0;		       /* This removes the border around the viewport in old versions of IE */
	                   width:100%;
                      min-width:600px;		/* Minimum width of layout - remove line if not required */
	                   				         /* The min-width property does not work in old versions of Internet Explorer */
	                   font-size:90%;
                      background-image:url('login-background.jpeg');                    
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
                       background-image:url('white.png'); 
                       padding:10px;
                       opacity:1; 
                       border-radius:5px;                     
                       background-color:#fff;  
                       margin:5px; 
                     }  
                     #error-msg{
                       background-image:url('white.png'); 
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
                      background-image:url('blue.png'); 
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
                      background-image:url('white.png');                      
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
                      border-radius:5px;margin-bottom:5px;  float: right;	margin-top: 7px;padding:8px 10px;background-image:url('green.png'); 
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
    <body 
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
		<select name="year" class="year" title="Year">
							<option value="1999">1999</option>
							<option value="1998">1998</option>
							<option value="1997">1997</option>
							<option value="1996">1996</option>
							<option value="1995">1995</option>
							<option value="1994">1994</option>
							<option value="1993">1993</option>
							<option value="1992">1992</option>
							<option value="1991">1991</option>
							<option value="1990">1990</option>
							<option value="1989">1989</option>
							<option value="1988">1988</option>
							<option value="1987">1987</option>
							<option value="1986">1986</option>
							<option value="1985">1985</option>
							<option value="1984">1984</option>
							<option value="1983">1983</option>
							<option value="1982">1982</option>
							<option value="1981">1981</option>
							<option value="1980">1980</option>
							<option value="1979">1979</option>
							<option value="1978">1978</option>
							<option value="1977">1977</option>
							<option value="1976">1976</option>
							<option value="1975">1975</option>
							<option value="1974">1974</option>
							<option value="1973">1973</option>
							<option value="1972">1972</option>
							<option value="1971">1971</option>
							<option value="1970">1970</option>
							<option value="1969">1969</option>
							<option value="1968">1968</option>
							<option value="1967">1967</option>
							<option value="1966">1966</option>
							<option value="1965">1965</option>
							<option value="1964">1964</option>
							<option value="1963">1963</option>
							<option value="1962">1962</option>
							<option value="1961">1961</option>
							<option value="1960">1960</option>
							<option value="1959">1959</option>
							<option value="1958">1958</option>
							<option value="1957">1957</option>
							<option value="1956">1956</option>
							<option value="1955">1955</option>
							<option value="1954">1954</option>
							<option value="1953">1953</option>
							<option value="1952">1952</option>
							<option value="1951">1951</option>
							<option value="1950">1950</option>
							<option value="1949">1949</option>
							<option value="1948">1948</option>
							<option value="1947">1947</option>
							<option value="1946">1946</option>
							<option value="1945">1945</option>
							<option value="1944">1944</option>
							<option value="1943">1943</option>
							<option value="1942">1942</option>
							<option value="1941">1941</option>
							<option value="1940">1940</option>
							<option value="1939">1939</option>
							<option value="1938">1938</option>
							<option value="1937">1937</option>
							<option value="1936">1936</option>
							<option value="1935">1935</option>
							<option value="1934">1934</option>
							<option value="1933">1933</option>
							<option value="1932">1932</option>
							<option value="1931">1931</option>
							<option value="1930">1930</option>
							<option value="1929">1929</option>
							<option value="1928">1928</option>
							<option value="1927">1927</option>
							<option value="1926">1926</option>
							<option value="1925">1925</option>
							<option value="1924">1924</option>
							<option value="1923">1923</option>
							<option value="1922">1922</option>
							<option value="1921">1921</option>
							<option value="1920">1920</option>
							<option value="1919">1919</option>
							<option value="1918">1918</option>
							<option value="1917">1917</option>
							<option value="1916">1916</option>
							<option value="1915">1915</option>
							<option value="1914">1914</option>
							<option value="1913">1913</option>
							<option value="1912">1912</option>
							<option value="1911">1911</option>
							<option value="1910">1910</option>
							<option value="1909">1909</option>
							<option value="1908">1908</option>
							<option value="1907">1907</option>
							<option value="1906">1906</option>
							<option value="1905">1905</option>
							<option value="1904">1904</option>
							<option value="1903">1903</option>
							<option value="1902">1902</option>
							<option value="1901">1901</option>
					</select>
		<select name="month" class="month" title="Month">
							<option value="12">12</option>
							<option value="11">11</option>
							<option value="10">10</option>
							<option value="9">9</option>
							<option value="8">8</option>
							<option value="7">7</option>
							<option value="6">6</option>
							<option value="5">5</option>
							<option value="4">4</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
					</select>
		<select name="day" class="day" title="Day"> 
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
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

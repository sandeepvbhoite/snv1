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
	date_default_timezone_set('UTC');
	if (!isset($_SESSION['userid'])) {
		include ('loginpage.php');
	} else {
		$_SESSION = array();
		$name   = session_name();
		$expire = strtotime('-1 year');
		$params = session_get_cookie_params();
		$path   = $params['path'];
		$domain = $params['domain'];
		$secure = $params['secure'];
		$httponly = $params['httponly'];

		setcookie($name, '', $expire, $path, $domain, $secure, $httponly);

		session_destroy();

		include ('loginpage.php');
	}

?>

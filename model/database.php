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
?><?php 

class database {
	private static $host = 'your host'; //Probably localhost
	private static $username = 'sntester'; //Username for the database, here sntester
	private static $password = 'snt3st3rv1'; // Password for the account
	private static $dbname   = 'snv1'; // Database name
	private static $db;

	
	private function __construct() { }

	public static function getDB () {
		if (!isset(self::$db)) {
			self::$db = new mysqli(self::$host, self::$username, self::$password, self::$dbname);
			$connectionError = self::$db->connect_error;
			if ($connectionError != null) {
				echo "<p> Connection error : $connectionError</p>";
				exit();
			}
		}
		return self::$db;
	}
}

?>

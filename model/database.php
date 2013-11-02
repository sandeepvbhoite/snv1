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


class database 
{
	private static $db;
	// Username for the database
	private static $username = 'sntester';
	// Password of the user
	private static $password = 'snt3st3rv1';
	private static $dsn = 'mysql:dbname=snv1;host=127.0.0.1;charset=utf8';

	private function __construct() { }

	public static function getDB ()
	{
		if (!isset(self::$db)) {
			// Try to get a new PDO
			try {
				self::$db = new PDO(self::$dsn, self::$username, self::$password);

				// Sets emulating prepared statements in PHP to false
				self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
			} catch (PDOException $e) {
				$error_message = $e->getMessage();
				echo "<p>Error connecting database: $error_message </p>";
				exit();
			}
		}

		return self::$db;
	}
}
?>

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
	
	$db = database::getDB();

	function searchPeople($query) {
		global $db;
		/* Let's first check if there's any space between the search string */
	
		$space = strpos($query, ' ');
	
		/* Now, if $space is false, there are most prolly two words */
		/* Let's grab them up */
		
		if ($space):
			$firstpart = substr($query, 0, $space);
			$secondpart = substr($query, $i);
		endif;
	
		/* Now we need to search $firstpart both in firstName and lastName, 
		same for the $secondpart And the same for pages also.. 
		In case of pages, we are saving just a 'name' in the database, 
		So, we will take the $firstpart and search in the database for it 
		(Limited to pages only)
	
		However, in case we have only one word string, we will search for 
		firstName and lastName against that query, if found, return results
		Easy for pages, if true! ;)
		*/
		
		if ($firstpart):
			$query = "SELECT userID, firstName, lastName, pic FROM users
				WHERE 
				(firstName LIKE '$firstpart' OR lastName LIKE '$firstpart') OR
				(firstName LIKE '$secondpart' OR lastName LIKE '$secondpart')";
			$success = $db->query($query);
			$total = $success->num_rows;
			$results = array();
			for ($i=0; $i<$total; $i++):
				$row = $success->fetch_assoc();
				$results[$i] = array();
				$results[$i]['userID'] = $row['userID'];
				$results[$i]['fname'] = $row['firstName'];
				$results[$i]['lname'] = $row['lastName'];
				$results[$i]['pic'] = $row['pic'];
				$tmp = getCityAndAge($row['userID']);
				$results[$i]['city'] = $tmp['city'];
				$results[$i]['age'] = $tmp['age'];
			endfor;
			$success->free();
			return $results;
		else:
			$query = "SELECT userID, firstName, lastName, pic FROM users
				WHERE 
				(firstName LIKE '$query' OR lastName LIKE '$query')";
			$success = $db->query($query);
			$total = $success->num_rows;
			$results = array();
			for ($i=0; $i<$total; $i++):
				$row = $success->fetch_assoc();
				$results[$i] = array();
				$results[$i]['userID'] = $row['userID'];
				$results[$i]['fname'] = $row['firstName'];
				$results[$i]['lname'] = $row['lastName'];
				$results[$i]['pic'] = $row['pic'];
				$tmp = getCityAndAge($row['userID']);
				$results[$i]['city'] = $tmp['city'];
				$results[$i]['age'] = $tmp['age'];

			endfor;
			$success->free();
			return $results;
		endif;
	/* Okay, decided to write another function to search from pages. */
	}
	
	function searchPages($query) {
		global $db;
		/* Let's first check if there's any space between the search string */
	
		$space = strpos($query, ' ');
	
		/* Now, if $space is false, there are most prolly two words */
		/* Let's grab them up */
		
		if ($space):
			$firstpart = substr($query, 0, $space);
			$secondpart = substr($query, $i);
		endif;

		if ($firstpart):
			$query = "SELECT pageID, name FROM pages
					WHERE name LIKE '%$firstpart%' OR name LIKE '%$secondpart%'";
			$success = $db->query($query);
			$total = $success->num_rows;
			$results = array();
			for ($i=0; $i<$total; $i++):
				$results[$i] = array();
				$row = $success->fetch_assoc();
				$results[$i]['pageID'] = $row['pageID'];
				$results[$i]['name'] = $row['name'];
			endfor;
			$success->free();
			return $results;
		else:
			$query = "SELECT pageID, name FROM pages
					WHERE name LIKE '%$query%'";
			$success = $db->query($query);
			$total = $success->num_rows;
			$results = array();
			for ($i=0; $i<$total; $i++):
				$results[$i] = array();
				$row = $success->fetch_assoc();
				$results[$i]['pageID'] = $row['pageID'];
				$results[$i]['name'] = $row['name'];
			endfor;
			$success->free();
			return $results;
		endif;
		
	}

?>

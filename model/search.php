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
		
		/* saving search query in $q to avoid confusion while dealing with
		 * the SQL statements.
		 */
		$q = $query;

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
				(firstName LIKE ? OR lastName LIKE ?) OR
				(firstName LIKE ? OR lastName LIKE ?)";
			
			// Prepare SQL statements
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $firstpart);
			$stmt->bindValue(2, $firstpart);
			$stmt->bindValue(3, $secondpart);
			$stmt->bindValue(4, $secondpart);

			$success = $stmt->execute();
			$row = $stmt->fetch();
			$results = array();
			$result = array();
			while ($row != null):
				$result['userID'] = $row['userID'];
				$result['fname'] = $row['firstName'];
				$result['lname'] = $row['lastName'];
				$result['pic'] = $row['pic'];
				$tmp = getCityAndAge($row['userID']);
				$result['city'] = $tmp['city'];
				$result['age'] = $tmp['age'];
				// put this $result in $results
				$results[] = $result;
				// fetch next row from the result set
				$row = $stmt->fetch();
			endwhile;
			$stmt->closeCursor();
			return $results;
		else:
			$query = "SELECT userID, firstName, lastName, pic FROM users
				WHERE 
				(firstName LIKE ? OR lastName LIKE ?)";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $q);
			$stmt->bindValue(2, $q);
			$stmt->execute();
			// Get first row from the result set
			$row = $stmt->fetch();
			$results = array();
			$result = array();
			while ($row != null):
				
				$result['userID'] = $row['userID'];
				$result['fname'] = $row['firstName'];
				$result['lname'] = $row['lastName'];
				$result['pic'] = $row['pic'];
				$tmp = getCityAndAge($row['userID']);
				$result['city'] = $tmp['city'];
				$result['age'] = $tmp['age'];
				// Now put this single result in $results
				$results[] = $result;
				// fetch next row
				$row = $stmt->fetch();

			endwhile;
			// Release statement
			$stmt->closeCursor();
			return $results;
		endif;
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
					WHERE name LIKE '%?%' OR name LIKE '%?%'";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $firstpart);
			$stmt->bindValue(2, $secondpart);
			$stmt->execute();
			$row = $stmt->fetch();

			$results = array();
			$result = array();
			
			while ($row != null):
				$result['pageID'] = $row['pageID'];
				$result['name'] = $row['name'];
				// Store this result in $results
				$results[] = $result;
				// Fetch next row
				$row = $stmt->fetch();
			endwhile;	
			$stmt->closeCursor();
			return $results;
		
		else:
			$query = "SELECT pageID, name FROM pages
					WHERE name LIKE '%?%'";
			
			$stmt = $db->prepare($query);
			$stmt->bindValue(1, $q);
			$success = $stmt->execute();
			$row = $stmt->fetch();
			$results = array();
			$result = array();
			while ($row != null):
				$result['pageID'] = $row['pageID'];
				$result['name'] = $row['name'];
				$results[] = $result;
				$row = $stmt->fetch();
			endwhile;
			$stmt->closeCursor();
			return $results;
		endif;
		
	}

?>

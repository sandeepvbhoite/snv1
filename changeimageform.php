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
	if (!isset($_SESSION['userid'])):
		include ('loginpage.php');	
	else:
?>

<!DOCTYPE html>
<html>
	<img src="<?php echo $current_image; ?>" height="500" width="400" />
	<form action="profile.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="uploadpp" />
		<input type="file" name="pic"> <br/>
		<input type="submit" value="Upload" />
	</form>
	<?php
		if ($success):
	?>
		<p>Yeah! Your profile picture has been succefully changed!</p> <br />
		<a href="profile.php"><p>Show my new look</p></a>
	<?php
		endif;
	?>
</html>
<?php
	endif;
?>

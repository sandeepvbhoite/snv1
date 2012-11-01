snv1
====

This is a basic social networking site, which covers almost all basic functionalities. Also, this introduces a new unique feature keep-your-stuff-outta-my-sight. Read further to know more...

This project by Rohitt Shinde is licensed under GNU General Public License [ http://www.gnu.org/licenses/gpl.html ]

Features :
  - Connect with other users by 'adding as a friend'
  - Once the other user 'accepts' your friend request, you become a 'friend' of him/her
  - Now that you are 'friend' with other user, you get to see things (text/image) posted by that user
  - Oh yes, you can post 'things', too
  - There are 'pages' too. You can create a page for your organisation, company, or a favorite celebrity
  - Now that you want to search your friend 'Kevin Mitnick', there is a search bar at the top bar, use it
  - You can search pages, too. Just click on the tab 'pages' in the search results 
  - Oh, there is messaging, too
  - You can like posts, comment on them
  - NOW, THE UNIQUE FEATURE I WAS TALKING ABOUT ~
  - I've introduced a new feature, which keeps all those unwanted posts/texts/images posted by pages, for example,
  - If you have a single friend on this site, and you have liked a hundred pages, and if we had a single page
  - in which you would see all those posts, you would have definitely lost that one important post/text/image posted
  - by that your single friend. So that, I have differentiated all those posts in two streams. They are as follows :
  - 1. Private :
  -   This is your default stream. Obviously you want to see things posted by your friend first. Pages are secondary.
  -   So, you get to see things posted by your friends in here. Nothing else would be included.
  - 2. Public :
  -   Now this is where all crap(?) material lies. Have fun with it when none of your friend is active. You can comment
  -   on these posts, too
  -   
  - Little more about pages : You have to 'like' a page to get subscribed to the posts of it. Only admin (owner)
  - of the page can make new posts on the page. 

Installation :
  I have built and tested this porject under Arch linux. You can use the SQL script which is under `setup` directory
  to create the database, and tables in it. This will also create a user and grant access to it on this database.
  
  
  
  =================================================================================================================
                                          Feel free to develop it further
  =================================================================================================================
  
  Things to do :
  - There is no single line of Java Script in this project. We've got to write JS for validating data
  - Refreshing page on every post, comment, like is really weird. We need to 'Ajaxify' it
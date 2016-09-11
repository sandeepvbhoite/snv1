#SNv1

**Note: This was an academic project, built for the purpose of learning.**

This is a basic social networking site, which covers almost all basic functionalities. Also, this introduces a new unique feature keep-your-stuff-outta-my-sight.

This project is licensed under GNU General Public License [ http://www.gnu.org/licenses/gpl.html ]

###Features:

* Connect with other users by adding them as friend(s)
* Once the other user *accepts* your friend request, you become a *friend* of him/her
* Now that you are friend with other user, you get to see things (text/images) posted by that user
* Oh yes, there are *pages* too. You can create a page for your organisation, company, or a favorite celebrity
* Now that you want to search your friend x-y-z, there is a search bar at the top bar
* You can search pages, too. Just click on the tab pages in the search results 
* There is messaging, too
* You can *like* posts, or make comments on them

####That special feature:

There is a feature which keeps all the posts made by page owners out of your sight by-default. For example,
If you have a single friend, and you have liked a hundred pages, and suppose each page updates their status, 
then it makes total 100 posts, compared to a single post from your friend, you would definitely miss that one important post by that friend. So, I have differentiated all those posts in two streams. They are as follows :

######1. Private:

This is your default stream. Obviously you want to see things posted by your friends first. Pages are secondary.
So, you get to see things posted by your friends in here. Nothing else would be included.

######2. Public:

Here the user will see the posts made by the pages she has liked (/ subscribed to)
  
Little more about pages : You have to **like** a page to get subscribed to the posts of it. Only admin (owner)
of the page can make new posts on the page. 

###Installation:
  We built and tested this porject under GNU/Linux. You can use the SQL script which is under `setup` directory
  to create the database. This will also create a user and grant access to it on this database.
  
  
  
---


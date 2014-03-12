
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Drop the database it it is already present

DROP DATABASE IF EXISTS snv1;

-- Create the database `snv1`
CREATE DATABASE `snv1`;

USE `snv1`;

-- We need to create an user to access this database
CREATE user 'sntester'@'localhost' IDENTIFIED BY 'snt3st3rv1';

-- Grant powers to the user to perform following actions
-- on the database.

GRANT SELECT, INSERT, DELETE, UPDATE
ON snv1.*
TO 'sntester'@'localhost'
IDENTIFIED BY 'snt3st3rv1';
--
-- Database: `snv1`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `commentText` varchar(80) NOT NULL,
  `timeOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  KEY `postID` (`postID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `connectionID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `friendID` int(11) NOT NULL,
  PRIMARY KEY (`connectionID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE IF NOT EXISTS `friend_requests` (
  `requestID` int(11) NOT NULL AUTO_INCREMENT,
  `fromUserID` int(11) NOT NULL,
  `toUserID` int(11) NOT NULL,
  PRIMARY KEY (`requestID`),
  KEY `fromUserID` (`fromUserID`),
  KEY `toUserID` (`toUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `likeID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  PRIMARY KEY (`likeID`),
  KEY `userID` (`userID`),
  KEY `postID` (`postID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `convID` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `msgText` varchar(160) NOT NULL,
  `onTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`messageID`),
  KEY `convID` (`convID`),
  KEY `msgText` (`msgText`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_records`
--

CREATE TABLE IF NOT EXISTS `message_records` (
  `convID` int(11) NOT NULL AUTO_INCREMENT,
  `user1ID` int(11) NOT NULL,
  `user2ID` int(11) NOT NULL,
  PRIMARY KEY (`convID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageID` int(11) NOT NULL AUTO_INCREMENT,
  `typeID` int(11) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `about` varchar(1024) NOT NULL,
  `started` date DEFAULT NULL,
  `product` varchar(20) DEFAULT NULL,
  `born` date DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `web` varchar(255) NOT NULL,
  `tele` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `history` varchar(2048) NOT NULL,
  `pic` varchar(255) NOT NULL DEFAULT 'images/page-icon.png',
  PRIMARY KEY (`pageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages_likes`
--

CREATE TABLE IF NOT EXISTS `pages_likes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `page_posts`
--

CREATE TABLE IF NOT EXISTS `page_posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `pageID` int(11) NOT NULL,
  `postText` varchar(240) NOT NULL,
  `ifImage` varchar(255) DEFAULT NULL,
  `timeOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `page_post_comments`
--

CREATE TABLE IF NOT EXISTS `page_post_comments` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `commentText` varchar(180) NOT NULL,
  `timeOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `page_post_likes`
--

CREATE TABLE IF NOT EXISTS `page_post_likes` (
  `likeID` int(11) NOT NULL AUTO_INCREMENT,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`likeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `page_type`
--

CREATE TABLE IF NOT EXISTS `page_type` (
  `typeID` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`typeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `page_type`
--

INSERT INTO `page_type` (`typeID`, `type`) VALUES
(1, 'celeb'),
(2, 'corp');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `postText` varchar(160) NOT NULL,
  `ifImage` varchar(255) DEFAULT NULL,
  `timeOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`postID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(20) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `pic` varchar(255) NOT NULL DEFAULT 'images/sample.png',
  `gender` char(1) DEFAULT 'M',
  `birthday` date NOT NULL,
  `education` varchar(20) DEFAULT NULL,
  `languages` varchar(128) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `mobile` varchar(13) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `userFrom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `emailAddress` (`emailAddress`),
  KEY `userID` (`userID`),
  KEY `firstName` (`firstName`),
  KEY `lastName` (`lastName`),
  KEY `emailAddress_2` (`emailAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Table structure for table `pages_dislikes`
--

CREATE TABLE IF NOT EXISTS `pages_dislikes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------



CREATE TABLE `bully_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `desco` text DEFAULT NULL,
  `creator_userid` text DEFAULT NULL,
  `creator_fullname` varchar(200) DEFAULT NULL,
  `creator_photo` varchar(200) DEFAULT NULL,
  `timing` varchar(200) DEFAULT NULL,
  `bully_word` text DEFAULT NULL,
  `bully_status` varchar(20) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `timer1` varchar(100) DEFAULT NULL,
  `userid` text DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `data` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `post_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `like_count` text DEFAULT NULL,
  `timer1` varchar(100) DEFAULT NULL,
  `userid` text DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `title_seo` varchar(200) DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timer` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `userphoto` text DEFAULT NULL,
  `userid` text DEFAULT NULL,
  `total_comments` varchar(100) DEFAULT NULL,
  `total_like` varchar(20) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `bully_word` text DEFAULT NULL,
  `bully_status` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) DEFAULT NULL,
  `fullname` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `timing` varchar(200) DEFAULT NULL,
  `userid` varchar(200) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

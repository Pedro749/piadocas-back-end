
CREATE DATABASE piadocas;

USE piadocas;

/*Table structure for table `likes` */

DROP TABLE IF EXISTS `likes`;

CREATE TABLE `likes` (
  `IdUserLike` int(11) NOT NULL,
  `IdPost` int(11) NOT NULL,
  `DataCriacao` date NOT NULL,
  `md5_hash` varchar(255) NOT NULL,
  KEY `IdUserLike` (`IdUserLike`),
  KEY `IdPost` (`IdPost`),
  CONSTRAINT `IdPost` FOREIGN KEY (`IdPost`) REFERENCES `posts` (`IdPost`),
  CONSTRAINT `IdUserLike` FOREIGN KEY (`IdUserLike`) REFERENCES `users` (`IdUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `IdPost` int(11) NOT NULL AUTO_INCREMENT,
  `IdUser` int(11) NOT NULL,
  `Post` varchar(255) NOT NULL,
  `Likes` int(11) DEFAULT NULL,
  `DataCriacao` date DEFAULT NULL,
  PRIMARY KEY (`IdPost`),
  KEY `IdUser` (`IdUser`),
  CONSTRAINT `IdUser` FOREIGN KEY (`IdUser`) REFERENCES `users` (`IdUser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `IdUser` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DataCriacao` date NOT NULL,
  PRIMARY KEY (`IdUser`,`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;


DROP PROCEDURE IF EXISTS  `deleteUser`;

DELIMITER $$

 CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser`(Id INT)
BEGIN
	SET FOREIGN_KEY_CHECKS=OFF; 
	if (select count(*) from likes where IdUserLike = Id ) > 0 then
		DELETE FROM likes WHERE IdUserLike = Id;
	End If;
	IF (SELECT COUNT(*) FROM posts WHERE IdUser = Id) > 0 THEN
		DELETE FROM posts WHERE IdUser = Id;
	END IF;
	IF (SELECT COUNT(*) FROM users WHERE IdUser = Id ) > 0 THEN
		DELETE FROM users WHERE IdUser = Id;
	END IF;
	SET FOREIGN_KEY_CHECKS=ON;
    END $$
DELIMITER ;

/* Procedure structure for procedure `likeUpdate` */

DROP PROCEDURE IF EXISTS  `likeUpdate`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `likeUpdate`(LikeIdUser int, PostLikedId int)
BEGIN
	if (select count(*) from likes where IdUserLike = LikeIdUser and IdPost = PostLikedId) = 0 then
	Insert into likes (IdUserLike, IdPost, DataCriacao, md5_hash) 
		values
	(LikeIdUser, PostLikedId, now(), md5(concat(LikeIdUser, "-", PostLikedId)));
	update posts set likes = (select count(*) from likes WHERE IdPost = PostLikedId) where
	posts.IdPost = PostLikedId;
	end if;
    END $$
DELIMITER ;

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`piadocas` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `piadocas`;

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

/* Procedure structure for procedure `deleteUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `deleteUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser`(Id INT)
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
    END */$$
DELIMITER ;

/* Procedure structure for procedure `likeUpdate` */

/*!50003 DROP PROCEDURE IF EXISTS  `likeUpdate` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `likeUpdate`(LikeIdUser int, PostLikedId int)
BEGIN
	if (select count(*) from likes where IdUserLike = LikeIdUser and IdPost = PostLikedId) = 0 then
	Insert into likes (IdUserLike, IdPost, DataCriacao, md5_hash) 
		values
	(LikeIdUser, PostLikedId, now(), md5(concat(LikeIdUser, "-", PostLikedId)));
	update posts set likes = (select count(*) from likes WHERE IdPost = PostLikedId) where
	posts.IdPost = PostLikedId;
	end if;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
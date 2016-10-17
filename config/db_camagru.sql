-- DROP DATABASE IF EXISTS DB_CAMAGRU;

-- CREATE DATABASE DB_CAMAGRU;

CREATE TABLE `com` (
  `id_com` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_usr` int(10) UNSIGNED NOT NULL,
  `id_img` int(10) UNSIGNED NOT NULL,
  `date_com` date NOT NULL,
  `com` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `images` (
  `id_img` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `path_img` varchar(255) NOT NULL,
  `id_usr` int(10) NOT NULL,
  `date_img` date NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `likes` (
  `id_like` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_usr` int(10) UNSIGNED NOT NULL,
  `id_img` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `usr` (
  `id_usr` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `login` varchar(15) NOT NULL,
  `passwd` char(64) NOT NULL,
  `mail` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `usr` (`id_usr`, `login`, `passwd`, `mail`) VALUES (NULL, 'pconin', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'pconin@gmail.com');
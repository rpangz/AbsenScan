-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.32-community


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema dealer
--

CREATE DATABASE IF NOT EXISTS dealer;
USE dealer;

--
-- Definition of table `master_department`
--

DROP TABLE IF EXISTS `master_department`;
CREATE TABLE `master_department` (
  `dept_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(45) NOT NULL,
  `createuser` varchar(45) NOT NULL,
  `createtime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_department`
--

/*!40000 ALTER TABLE `master_department` DISABLE KEYS */;
INSERT INTO `master_department` (`dept_id`,`dept_name`,`createuser`,`createtime`,`status`) VALUES 
 (1,'SYSADMIN','SYSTEM','2019-09-02 00:00:00',1),
 (2,'ADMIN','SYSTEM','2019-09-02 00:00:00',1),
 (3,'AKUNTING','SYSTEM','2019-09-02 00:00:00',1);
/*!40000 ALTER TABLE `master_department` ENABLE KEYS */;


--
-- Definition of table `master_jabatan`
--

DROP TABLE IF EXISTS `master_jabatan`;
CREATE TABLE `master_jabatan` (
  `jabatan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jabatan_name` varchar(45) NOT NULL,
  `createuser` varchar(45) NOT NULL,
  `createtime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`jabatan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_jabatan`
--

/*!40000 ALTER TABLE `master_jabatan` DISABLE KEYS */;
INSERT INTO `master_jabatan` (`jabatan_id`,`jabatan_name`,`createuser`,`createtime`,`status`) VALUES 
 (1,'HEAD','SYSTEM','2019-09-02 00:00:00',1),
 (2,'STAFF','SYSTEM','2019-09-02 00:00:00',1);
/*!40000 ALTER TABLE `master_jabatan` ENABLE KEYS */;


--
-- Definition of table `secure_form_akses`
--

DROP TABLE IF EXISTS `secure_form_akses`;
CREATE TABLE `secure_form_akses` (
  `id_form` int(10) unsigned NOT NULL,
  `formdepartment` int(10) unsigned NOT NULL,
  `formjabatan` int(10) unsigned NOT NULL,
  `formstatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_form`,`formdepartment`,`formjabatan`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secure_form_akses`
--

/*!40000 ALTER TABLE `secure_form_akses` DISABLE KEYS */;
INSERT INTO `secure_form_akses` (`id_form`,`formdepartment`,`formjabatan`,`formstatus`) VALUES 
 (1,1,1,1),
 (2,1,1,1),
 (3,1,1,1);
/*!40000 ALTER TABLE `secure_form_akses` ENABLE KEYS */;


--
-- Definition of table `secure_form_register`
--

DROP TABLE IF EXISTS `secure_form_register`;
CREATE TABLE `secure_form_register` (
  `id_form` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `formname` varchar(45) NOT NULL,
  `formtitle` varchar(45) NOT NULL,
  `formheader` varchar(45) NOT NULL,
  `formstatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_form`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secure_form_register`
--

/*!40000 ALTER TABLE `secure_form_register` DISABLE KEYS */;
INSERT INTO `secure_form_register` (`id_form`,`formname`,`formtitle`,`formheader`,`formstatus`) VALUES 
 (1,'Master_User','Master User','Master',1),
 (2,'Master_Department','Master Department','Master',1),
 (3,'Master_Jabatan','Master Jabatan','Master',1),
 (4,'Master_Kendaraan','Master Kendaraan','Master',1);
/*!40000 ALTER TABLE `secure_form_register` ENABLE KEYS */;


--
-- Definition of table `secure_user_register`
--

DROP TABLE IF EXISTS `secure_user_register`;
CREATE TABLE `secure_user_register` (
  `userid` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `department` varchar(45) NOT NULL,
  `jabatan` varchar(45) NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secure_user_register`
--

/*!40000 ALTER TABLE `secure_user_register` DISABLE KEYS */;
/*!40000 ALTER TABLE `secure_user_register` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

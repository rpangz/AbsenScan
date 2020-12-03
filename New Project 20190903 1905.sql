SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=NO_AUTO_VALUE_ON_ZERO */;


CREATE DATABASE /*!32312 IF NOT EXISTS*/ `dealer`;
USE `dealer`;
CREATE TABLE `master_department` (
  `dept_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(45) NOT NULL,
  `createuser` varchar(45) NOT NULL,
  `createtime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
INSERT INTO `master_department` (`dept_id`,`dept_name`,`createuser`,`createtime`,`status`) VALUES (1,'SYSADMIN','SYSTEM','2019-09-02 00:00:00',1),(2,'ADMIN','SYSTEM','2019-09-02 00:00:00',1),(3,'AKUNTING','SYSTEM','2019-09-02 00:00:00',1);
CREATE TABLE `master_formheader` (
  `id_form` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `headername` varchar(45) NOT NULL DEFAULT '',
  `glyph` varchar(45) DEFAULT NULL,
  `ordinal` int(10) unsigned NOT NULL DEFAULT '0',
  `createuser` varchar(45) NOT NULL DEFAULT '',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `formstatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_form`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
INSERT INTO `master_formheader` (`id_form`,`headername`,`glyph`,`ordinal`,`createuser`,`createtime`,`formstatus`) VALUES (1,'Master','ti-crown',1,'SYSTEM','2019-09-03 00:00:00',1),(2,'Transaksi','ti-credit-card',2,'SYSTEM','2019-09-03 00:00:00',1),(3,'Laporan','ti-files',3,'SYSTEM','2019-09-03 00:00:00',1),(4,'Support','ti-headphone-alt',4,'SYSTEM','2019-09-03 00:00:00',1);
CREATE TABLE `master_jabatan` (
  `jabatan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jabatan_name` varchar(45) NOT NULL,
  `createuser` varchar(45) NOT NULL,
  `createtime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`jabatan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `master_jabatan` (`jabatan_id`,`jabatan_name`,`createuser`,`createtime`,`status`) VALUES (1,'HEAD','SYSTEM','2019-09-02 00:00:00',1),(2,'STAFF','SYSTEM','2019-09-02 00:00:00',1);
CREATE TABLE `secure_form_akses` (
  `id_form` int(10) unsigned NOT NULL,
  `formdepartment` int(10) unsigned NOT NULL,
  `formjabatan` int(10) unsigned NOT NULL,
  `formstatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_form`,`formdepartment`,`formjabatan`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `secure_form_akses` (`id_form`,`formdepartment`,`formjabatan`,`formstatus`) VALUES (1,1,1,1),(2,1,1,1),(3,1,1,1),(4,1,1,1),(5,1,1,1),(6,1,1,1),(7,1,1,1);
CREATE TABLE `secure_form_register` (
  `id_form` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `formname` varchar(45) NOT NULL,
  `formtitle` varchar(45) NOT NULL,
  `formheader` varchar(5) NOT NULL DEFAULT '',
  `formstatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_form`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
INSERT INTO `secure_form_register` (`id_form`,`formname`,`formtitle`,`formheader`,`formstatus`) VALUES (1,'Master_User','Master User','1',1),(2,'Master_Department','Master Department','1',1),(3,'Master_Jabatan','Master Jabatan','1',1),(4,'Master_Kendaraan','Master Kendaraan','1',1),(5,'Master_Header','Master Header','1',1),(6,'Support_Form_Register','Form Register Akses','4',1),(7,'Transaksi_Penjualan','Penjualan','2',1);
CREATE TABLE `secure_user_register` (
  `nik` varchar(5) NOT NULL DEFAULT '',
  `nama` varchar(45) NOT NULL DEFAULT '',
  `password` varchar(45) NOT NULL,
  `department` varchar(5) NOT NULL DEFAULT '',
  `jabatan` varchar(5) NOT NULL DEFAULT '',
  `status` varchar(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `secure_user_register` (`nik`,`nama`,`password`,`department`,`jabatan`,`status`) VALUES ('5144','RONALDO PANGASIAN','123456','1','1','1');
CREATE TABLE `list_status` (
  `id_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statusname` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `list_status` (`id_status`,`statusname`) VALUES (1,'ACTIVE'),(2,'INACTIVE');
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

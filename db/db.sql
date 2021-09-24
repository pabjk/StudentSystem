-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.17-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6251
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for studentgroupingsystem
DROP DATABASE IF EXISTS `groupset`;
CREATE DATABASE IF NOT EXISTS `groupset` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `groupset`;

-- Dumping structure for table studentgroupingsystem.assignment
DROP TABLE IF EXISTS `assignment`;
CREATE TABLE IF NOT EXISTS `assignment` (
  `assignID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับการมอบหมายงาน',
  `regisID` int(11) NOT NULL COMMENT 'รหัสลำดับรายวิชาที่เปิดสอน',
  `groupTypeID` int(11) NOT NULL COMMENT 'รหัสลำดับประเภทการจับกลุ่ม',
  `assignTitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'หัวข้อการมอบหมายงาน',
  `assignDescription` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดการมอบหมายงาน',
  `assignDate` datetime NOT NULL COMMENT 'วันที่เวลามอบหมายงาน',
  `deadline` datetime DEFAULT NULL COMMENT 'วันที่เวลากำหนดส่ง ค่าว่าง คือ ไม่กำหนด',
  `numGroup` int(11) NOT NULL DEFAULT 1 COMMENT 'จำนวนกลุ่ม ขั้นต่ำ 1 กลุ่ม',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'สถานะการใช้งาน 0 ระงัย 1 ใช้งาน',
  PRIMARY KEY (`assignID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลการมอบหมายงาน';

-- Dumping data for table studentgroupingsystem.assignment: ~6 rows (approximately)
DELETE FROM `assignment`;
/*!40000 ALTER TABLE `assignment` DISABLE KEYS */;
INSERT INTO `assignment` (`assignID`, `regisID`, `groupTypeID`, `assignTitle`, `assignDescription`, `assignDate`, `deadline`, `numGroup`, `status`) VALUES
	(1, 2, 1, '1', '1', '2021-03-26 21:45:00', '2021-03-26 21:45:00', 3, 1),
	(2, 2, 2, '2', '2', '2021-03-26 21:45:00', '2021-03-28 21:45:00', 3, 1),
	(3, 2, 3, '3', '3', '2021-03-26 21:45:00', '2021-03-26 21:45:00', 3, 1),
	(4, 1, 1, '4', '4', '2021-03-26 21:46:00', '2021-03-26 21:46:00', 4, 1),
	(5, 1, 2, '5', '5', '2021-03-26 21:46:00', '2021-03-26 21:46:00', 4, 1),
	(6, 1, 3, '6', '6', '2021-03-26 21:47:00', '2021-03-26 21:47:00', 4, 1);
/*!40000 ALTER TABLE `assignment` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.course_information
DROP TABLE IF EXISTS `course_information`;
CREATE TABLE IF NOT EXISTS `course_information` (
  `courseID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับรายวิชา',
  `courseCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'รหัสวิชา',
  `courseName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ชื่อวิชา',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'สถานะการใช้งาน 0 ระงัย 1 ใช้งาน',
  PRIMARY KEY (`courseID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลรายวิชา';

-- Dumping data for table studentgroupingsystem.course_information: ~2 rows (approximately)
DELETE FROM `course_information`;
/*!40000 ALTER TABLE `course_information` DISABLE KEYS */;
INSERT INTO `course_information` (`courseID`, `courseCode`, `courseName`, `status`) VALUES
	(1, 'INT 353', 'Information Technology Project I', 1),
	(2, 'ENG 600', 'English for communication', 1);
/*!40000 ALTER TABLE `course_information` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.discussion
DROP TABLE IF EXISTS `discussion`;
CREATE TABLE IF NOT EXISTS `discussion` (
  `discussID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับการอภิปรายผล',
  `assignID` int(11) NOT NULL COMMENT 'รหัสลำดับการมอบหมายงาน',
  `groupNum` int(11) NOT NULL COMMENT 'รหัสกลุ่ม',
  `userID` int(11) NOT NULL COMMENT 'รหัสลำดับข้อมูลผู้ใช้',
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ข้อมูลข้อความ',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ข้อมูลรูปภาพ',
  `dateTimeSend` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่และเวลาที่ส่งข้อมูล',
  PRIMARY KEY (`discussID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลการอภิปรายผล';

-- Dumping data for table studentgroupingsystem.discussion: ~7 rows (approximately)
DELETE FROM `discussion`;
/*!40000 ALTER TABLE `discussion` DISABLE KEYS */;
INSERT INTO `discussion` (`discussID`, `assignID`, `groupNum`, `userID`, `message`, `photo`, `dateTimeSend`) VALUES
	(1, 3, 1, 4, 'test', NULL, '2021-03-29 10:51:49'),
	(2, 3, 1, 5, 'test2', NULL, '2021-03-29 10:52:11'),
	(3, 3, 1, 2, 'ttt', NULL, '2021-03-29 11:08:36'),
	(4, 3, 1, 2, 'test', NULL, '2021-03-29 11:28:07'),
	(5, 3, 2, 2, 'test', NULL, '2021-03-30 12:14:34'),
	(6, 3, 3, 2, 'group 3', NULL, '2021-04-21 11:37:17'),
	(7, 3, 2, 2, 'group 2', NULL, '2021-04-21 11:37:30'),
	(8, 3, 1, 2, 'group 1', NULL, '2021-04-21 11:37:39');
/*!40000 ALTER TABLE `discussion` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.evaluation_answer
DROP TABLE IF EXISTS `evaluation_answer`;
CREATE TABLE IF NOT EXISTS `evaluation_answer` (
  `answerID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับคำตอบ',
  `questionNo` int(11) NOT NULL COMMENT 'รหัสลำดับข้อคำถาม',
  `assignID` int(11) NOT NULL COMMENT 'รหัสลำดับการมอบหมายงาน',
  `groupNum` int(11) NOT NULL COMMENT 'รหัสกลุ่ม เลขที่กลุ่ม',
  `assessorID` int(11) NOT NULL COMMENT 'รหัสผู้ประเมิน',
  `userID` int(11) NOT NULL COMMENT 'รหัสลำดับข้อมูลผู้ใช้ (ผู้ถูกประเมิน)',
  `answer` int(11) DEFAULT NULL COMMENT 'ข้อคำตอบ',
  `suggestion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ข้อเสนอแนะ',
  PRIMARY KEY (`answerID`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลคำตอบประเมินผลการปฏิบัติงาน';

-- Dumping data for table studentgroupingsystem.evaluation_answer: ~24 rows (approximately)
DELETE FROM `evaluation_answer`;
/*!40000 ALTER TABLE `evaluation_answer` DISABLE KEYS */;
INSERT INTO `evaluation_answer` (`answerID`, `questionNo`, `assignID`, `groupNum`, `assessorID`, `userID`, `answer`, `suggestion`) VALUES
	(13, 1, 3, 1, 3, 5, 4, ''),
	(14, 2, 3, 1, 3, 5, 4, ''),
	(15, 3, 3, 1, 3, 5, 4, ''),
	(16, 4, 3, 1, 3, 5, 4, ''),
	(17, 5, 3, 1, 3, 5, 4, ''),
	(18, 6, 3, 1, 3, 5, 0, ''),
	(19, 1, 3, 1, 3, 6, 2, ''),
	(20, 2, 3, 1, 3, 6, 2, ''),
	(21, 3, 3, 1, 3, 6, 2, ''),
	(22, 4, 3, 1, 3, 6, 2, ''),
	(23, 5, 3, 1, 3, 6, 2, ''),
	(24, 6, 3, 1, 3, 6, 0, ''),
	(31, 1, 3, 1, 5, 3, 4, ''),
	(32, 2, 3, 1, 5, 3, 4, ''),
	(33, 3, 3, 1, 5, 3, 4, ''),
	(34, 4, 3, 1, 5, 3, 4, ''),
	(35, 5, 3, 1, 5, 3, 4, ''),
	(36, 6, 3, 1, 5, 3, 0, ''),
	(37, 1, 3, 1, 3, 3, 4, ''),
	(38, 2, 3, 1, 3, 3, 4, ''),
	(39, 3, 3, 1, 3, 3, 4, ''),
	(40, 4, 3, 1, 3, 3, 4, ''),
	(41, 5, 3, 1, 3, 3, 4, ''),
	(42, 6, 3, 1, 3, 3, 0, 'good');
/*!40000 ALTER TABLE `evaluation_answer` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.evaluation_question
DROP TABLE IF EXISTS `evaluation_question`;
CREATE TABLE IF NOT EXISTS `evaluation_question` (
  `questionID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับข้อคำถาม',
  `questionNo` int(11) NOT NULL DEFAULT 0 COMMENT 'คำถามข้อที่',
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ข้อคำถาม',
  PRIMARY KEY (`questionID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลคำถามประเมินผลการปฏิบัติงาน';

-- Dumping data for table studentgroupingsystem.evaluation_question: ~6 rows (approximately)
DELETE FROM `evaluation_question`;
/*!40000 ALTER TABLE `evaluation_question` DISABLE KEYS */;
INSERT INTO `evaluation_question` (`questionID`, `questionNo`, `question`) VALUES
	(1, 1, 'การมาทำงาน'),
	(2, 2, 'ผลงานเป็นที่ยอมรับ'),
	(3, 3, 'คุณภาพของงาน'),
	(4, 4, 'ปริมาณงาน'),
	(5, 5, 'ความสัมพันธ์กับผู้อื่น'),
	(6, 6, 'ข้อเสนอแนะ');
/*!40000 ALTER TABLE `evaluation_question` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.group_information
DROP TABLE IF EXISTS `group_information`;
CREATE TABLE IF NOT EXISTS `group_information` (
  `groupInfoID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับการจับกลุ่ม',
  `assignID` int(11) NOT NULL COMMENT 'รหัสลำดับการมอบหมายงาน',
  `groupNum` int(11) NOT NULL COMMENT 'รหัสกลุ่ม เลขที่กลุ่ม',
  `userID` int(11) NOT NULL COMMENT 'รหัสลำดับข้อมูลผู้ใช้ (นักศึกษา)',
  `responsibility` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'หน้าที่รับผิดชอบภายในกลุ่ม',
  PRIMARY KEY (`groupInfoID`) USING BTREE,
  KEY `assignID` (`assignID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลการจับกลุ่มของนักศึกษา';

-- Dumping data for table studentgroupingsystem.group_information: ~12 rows (approximately)
DELETE FROM `group_information`;
/*!40000 ALTER TABLE `group_information` DISABLE KEYS */;
INSERT INTO `group_information` (`groupInfoID`, `assignID`, `groupNum`, `userID`, `responsibility`) VALUES
	(1, 3, 1, 5, NULL),
	(2, 3, 1, 7, NULL),
	(3, 3, 2, 8, NULL),
	(4, 3, 2, 3, NULL),
	(5, 3, 3, 6, NULL),
	(6, 3, 3, 4, NULL),
	(7, 6, 1, 5, NULL),
	(8, 6, 1, 3, NULL),
	(9, 6, 2, 8, NULL),
	(10, 6, 2, 4, NULL),
	(11, 6, 3, 6, NULL),
	(12, 6, 4, 7, NULL),
	(13, 5, 2, 3, NULL);
/*!40000 ALTER TABLE `group_information` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.group_type
DROP TABLE IF EXISTS `group_type`;
CREATE TABLE IF NOT EXISTS `group_type` (
  `groupTypeID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับประเภทการจับกลุ่ม',
  `groupType` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ประเภทการจับกลุ่ม',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'สถานะการใช้งาน 0 ระงัย 1 ใช้งาน',
  PRIMARY KEY (`groupTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลประเภทการจับกลุ่ม';

-- Dumping data for table studentgroupingsystem.group_type: ~3 rows (approximately)
DELETE FROM `group_type`;
/*!40000 ALTER TABLE `group_type` DISABLE KEYS */;
INSERT INTO `group_type` (`groupTypeID`, `groupType`, `status`) VALUES
	(1, 'Voluntary grouping', 1),
	(2, 'Random grouping', 1),
	(3, 'MBTI grouping', 1);
/*!40000 ALTER TABLE `group_type` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.mbti_answer
DROP TABLE IF EXISTS `mbti_answer`;
CREATE TABLE IF NOT EXISTS `mbti_answer` (
  `answerID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับคำตอบ',
  `questionNo` int(11) NOT NULL COMMENT 'รหัสลำดับข้อคำถาม',
  `userID` int(11) NOT NULL COMMENT 'รหัสลำดับข้อมูลผู้ใช้',
  `answer` int(11) NOT NULL COMMENT 'ข้อคำตอบ',
  PRIMARY KEY (`answerID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลคำตอบแบบทดสอบบุคคลิกภาพ';

-- Dumping data for table studentgroupingsystem.mbti_answer: ~7 rows (approximately)
DELETE FROM `mbti_answer`;
/*!40000 ALTER TABLE `mbti_answer` DISABLE KEYS */;
INSERT INTO `mbti_answer` (`answerID`, `questionNo`, `userID`, `answer`) VALUES
	(1, 1, 4, 1),
	(2, 2, 4, 1),
	(3, 3, 4, 2),
	(4, 4, 4, 1),
	(5, 5, 4, 1),
	(6, 6, 4, 1),
	(7, 7, 4, 2);
/*!40000 ALTER TABLE `mbti_answer` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.mbti_question
DROP TABLE IF EXISTS `mbti_question`;
CREATE TABLE IF NOT EXISTS `mbti_question` (
  `questionID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับข้อคำถาม',
  `questionNo` int(11) NOT NULL DEFAULT 0 COMMENT 'ข้อคำถามที่',
  `question` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'คำถาม',
  `choiceA` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ตัวเลือก ก',
  `choiceB` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ตัวเลือก ข',
  PRIMARY KEY (`questionID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลคำถามทดสอบบุคคลิกภาพ';

-- Dumping data for table studentgroupingsystem.mbti_question: ~32 rows (approximately)
DELETE FROM `mbti_question`;
/*!40000 ALTER TABLE `mbti_question` DISABLE KEYS */;
INSERT INTO `mbti_question` (`questionID`, `questionNo`, `question`, `choiceA`, `choiceB`) VALUES
	(1, 1, 'ข้าพเจ้าชอบที่จะ', 'แก้ปัญหาใหม่ ๆ ที่มีความสลับซับซ้อน', 'เลือกทำงานที่เคยทำสำเร็จมาแล้ว'),
	(2, 2, 'ข้าพเจ้าชอบที่จะ', 'ทำงานตามลำพังในที่สงบเงียบ', 'อยู่ตรงที่งานกำลังดำเนินอยู่'),
	(3, 3, 'ข้าพเจ้าชอบหัวหน้าที่', 'ได้สร้างและกำหนดเกณฑ์การทำงานและการตัดสินใจไว้ให้แล้ว', 'ใส่ใจต่อความต้องการและช่วยเหลือลูกน้องรายบุคคล'),
	(4, 4, 'เมื่อข้าพเจ้าทำงานเกี่ยวกับโครงการ ข้าพเจ้าต้องการ', 'ทำให้เสร็จและปิดโครงการทันที', 'ไม่รีบปิดโครงการเผื่อไว้หากต้องปรับปรุงเปลี่ยนแปลง'),
	(5, 5, 'เมื่อต้องตัดสินใจ สิ่งสำคัญที่สุดที่ต้องคำนึงถึง คือ', 'การคิดเชิงเหตุผล การมีข้อมูลและความคิดเห็น', 'ความรู้สึกและค่านิยมของคน'),
	(6, 6, 'เมื่อต้องทำงานโครงการ ข้าพเจ้าจะ…', 'คิดทบทวนหลายครั้งก่อนที่จะตัดสินใจว่าจะเริ่มดำเนินการอย่างไร', 'เริ่มต้นลงมือทำงานทันที พร้อมกับคิดไปทำไปทีละขั้น'),
	(7, 7, 'เมื่อต้องทำงานโครงการ ข้าพเจ้าชอบที่จะ …', 'คงวิธีการควบคุมให้มากที่สุดเท่าที่จะเป็นไปได้', 'ตรวจสอบหาแนวทางต่าง ๆ ที่สามารถนำมาใช้ดาเนินการ'),
	(8, 8, 'ในการทำงานของข้าพเจ้า ข้าพเจ้ามักจะ …', 'ทำพร้อมกันหลายโครงการ และพยายามหาความรู้จากแต่ละโครงการให้มากที่สุด เท่าที่จะทำได้', 'เลือกทำโครงการที่มีความท้าทายมากที่สุดเพียงโครงการเดียวและจะทุ่มเทอย่างเต็มที่'),
	(9, 9, 'ข้าพเจ้ามักจะ …', 'จัดทำรายการและแผนการทำงานก่อนที่จะเริ่มต้นทำงาน และไม่พอใจอย่างยิ่งถ้าถูกปรับเปลี่ยนไปจากแผนที่กำหนดไว้นี้', 'หลีกเลี่ยงการทำแผนแต่จะปล่อยให้งานคืบหน้าไปเองขณะที่ทำงานนั้น'),
	(10, 10, 'เมื่ออภิปรายปัญหากับเพื่อน ข้าพเจ้าสามารถ...', 'มองเห็นภาพรวมได้โดยง่าย', 'เข้าใจจุดใดจุดหนึ่งของสถานการณ์นั้นได้อย่างลึกซึ้งได้โดยง่าย'),
	(11, 11, 'เมื่อมีเสียงกริ่งโทรศัพท์ดังขึ้นที่ทำงานหรือที่บ้าน ปกติข้าพเจ้า', 'รู้สึกว่าเป็นเสียงที่รบกวนการทำงาน', 'ไม่รังเกียจที่จะรับสายโทรศัพท์นั้น'),
	(12, 12, 'คำใดที่อธิบายตรงกับตัวข้าพเจ้าได้ดีกว่ากัน ระหว่าง …', 'การวิเคราะห์ (analytical)', 'ความเข้าอกเข้าใจ (empathetic)'),
	(13, 13, 'เมื่อข้าพเจ้าลงมือทำการบ้าน ข้าพเจ้ามักจะ …', 'ทำอย่างสม่ำเสมอและคงเส้นคงวา', 'ทำอย่างเต็มที่แต่มีช่วงหยุดเป็นช่วง ๆ'),
	(14, 14, 'เมื่อข้าพเจ้าเกิดได้ยินใครพูดถึงเรื่องใดเรื่องหนึ่ง ข้าพเจ้ามักจะพยายาม…', 'นำมาเกี่ยวข้องกับประสบการณ์เก่าของข้าพเจ้าและดูว่าคล้ายกันไหม', 'วิเคราะห์และประเมินเนื้อหาที่ได้ยินนั้น'),
	(15, 15, 'เมื่อข้าพเจ้าเกิดความคิดใหม่ขึ้น ข้าพเจ้ามักจะ …', 'ลงมือทำดู', 'ลองพิจารณาใคร่ครวญความคิดใหม่นั้นอีกหลายครั้ง'),
	(16, 16, 'เมื่อต้องทำงานโครงการ ข้าพเจ้ามักจะ …', 'ตีกรอบงานให้แคบลง เพื่อที่จะมองเห็นภาพได้ชัดเจนและตรงประเด็นยิ่งขึ้น', 'ขยายขอบเขตงานออกไป เพื่อให้สามารถครอบคลุมประเด็นที่เกี่ยวข้องได้ครบ'),
	(17, 17, 'เมื่อข้าพเจ้าอ่านอะไรก็แล้วแต่ ข้าพเจ้ามักจะ …', 'เพ่งความคิดไปยังข้อความที่เขียนนั้น', 'อ่านแต่ละบรรทัด เพื่อหาคำสาคัญที่เกี่ยวข้องกับความคิดต่าง ๆ'),
	(18, 18, 'เมื่อข้าพเจ้าจำเป็นต้องตัดสินใจโดยเร่งด่วน ข้าพเจ้ามัก…', 'รู้สึกอึดอัดใจและอยากได้ข้อมูลเพิ่มเติม', 'สามารถตัดสินใจได้จากข้อมูลเท่าที่มีอยู่'),
	(19, 19, 'ในการประชุม ข้าพเจ้ามักจะ…', 'ค่อย ๆ ประมวลความคิดตนเองในขณะที่พูดถึงเรื่องนั้น', 'พูดออกไปก็ต่อเมื่อได้ใคร่ครวญความคิดเกี่ยวกับเรื่องนั้นอย่างดีแล้ว'),
	(20, 20, 'ในการทำงาน ประเด็นที่ข้าพเจ้าชอบใช้เวลาค่อนข้างมากกว่าคือ', 'ประเด็นที่เกี่ยวกับความคิด', 'ประเด็นที่เกี่ยวกับคน'),
	(21, 21, 'ในการประชุม ข้าพเจ้ามักถูกรบกวนให้รำคาญใจกับคนที่…', 'ชอบเสนอความคิดมากมายที่ยังขาดความชัดเจน', 'ทำให้เสียเวลาที่ประชุมไปกับการพูดถึงรายละเอียดของการทำงานอย่างถี่ยิบ'),
	(22, 22, 'ข้าพเจ้าชอบเป็น…', 'คนตื่นเช้า', 'คนนอนดึก'),
	(23, 23, 'รูปแบบการเตรียมพร้อมก่อนเข้าร่วมประชุมของข้าพเจ้า คือ', 'อยากเข้าประชุมและได้แสดงความคิดเห็นต่อที่ประชุม', 'เตรียมตัวพร้อมเต็มที่ และขีดเขียนวาระหัวข้อการประชุมนั้นออกมา'),
	(24, 24, 'ในที่ประชุมข้าพเจ้าชอบคนที่ …', 'สามารถแสดงออกทางอารมณ์ได้ดี', 'ให้ความสาคัญกับงาน'),
	(25, 25, 'ข้าพเจ้าชอบการทำงานกับหน่วยงานที่ …', 'กระตุ้นการใช้ปัญญาในการทำงานให้กับข้าพเจ้า', 'ข้าพเจ้าผูกพันกับเป้าหมายและพันธกิจ'),
	(26, 26, 'ช่วงสุดสัปดาห์ ข้าพเจ้ามักจะ…', 'วางแผนล่วงหน้าว่าจะทำอะไรบ้าง', 'ไปดูว่ามีอะไรเกิดขึ้นบ้าง แล้วจึงตัดสินใจเข้าร่วมตามนั้น'),
	(27, 27, 'ข้าพเจ้าเป็นคนประเภท…', 'ชอบออกไปพบปะผู้คน', 'ชอบใช้ความคิดไตร่ตรอง'),
	(28, 28, 'ข้าพเจ้าชอบทำงานกับหัวหน้าที่…', 'เต็มไปด้วยความคิดใหม่ ๆ', 'เป็นนักปฏิบัติที่ดี'),
	(29, 29, 'เลือกเพียงอย่างเดียวระหว่าง “ก” หรือ “ข” ที่แสดงลักษณะที่ตรงกับตัวท่านมากที่สุด', 'สังคม (social)', 'เป็นทฤษฎี (theoretical)'),
	(30, 30, 'เลือกเพียงอย่างเดียวระหว่าง “ก” หรือ “ข” ที่แสดงลักษณะที่ตรงกับตัวท่านมากที่สุด', 'ความเป็นเจ้าความคิด (ingenuity)', 'ความเป็นนักปฏิบัติ (practicality)'),
	(31, 31, 'เลือกเพียงอย่างเดียวระหว่าง “ก” หรือ “ข” ที่แสดงลักษณะที่ตรงกับตัวท่านมากที่สุด', 'การจัดรูปแบบ (organized)', 'การยืดหยุ่นได้ (adaptable)'),
	(32, 32, 'เลือกเพียงอย่างเดียวระหว่าง “ก” หรือ “ข” ที่แสดงลักษณะที่ตรงกับตัวท่านมากที่สุด', 'คล่องแคล่ว (active)', 'การมีสมาธิ (concentration)');
/*!40000 ALTER TABLE `mbti_question` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.registration_information
DROP TABLE IF EXISTS `registration_information`;
CREATE TABLE IF NOT EXISTS `registration_information` (
  `regisID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับรายวิชาที่เปิดสอน',
  `courseID` int(11) NOT NULL COMMENT 'รหัสลำดับรายวิชา',
  `userID` int(11) NOT NULL COMMENT 'รหัสลำดับข้อมูลผู้ใช้ (รหัสอาจารย์)',
  `classGroup` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'กลุ่มเรียน',
  `year` year(4) NOT NULL COMMENT 'ปีการศึกษา',
  `semester` int(1) NOT NULL COMMENT 'ภาคการศึกษา',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'สถานะการใช้งาน 0 ระงัย 1 ใช้งาน',
  PRIMARY KEY (`regisID`),
  KEY `courseID` (`courseID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลการลงทะเบียน รายวิชาที่เปิดสอน';

-- Dumping data for table studentgroupingsystem.registration_information: ~3 rows (approximately)
DELETE FROM `registration_information`;
/*!40000 ALTER TABLE `registration_information` DISABLE KEYS */;
INSERT INTO `registration_information` (`regisID`, `courseID`, `userID`, `classGroup`, `year`, `semester`, `status`) VALUES
	(1, 1, 2, 'A', '2021', 1, 1),
	(2, 2, 2, 'A', '2021', 1, 1),
	(3, 1, 9, 'B', '2021', 1, 1);
/*!40000 ALTER TABLE `registration_information` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับข้อมูลผู้ใช้',
  `userTypeID` int(11) DEFAULT 3 COMMENT 'รหัสประเภทผู้ใช้  3 นักศึกษา 2 อาจารย์ 1 ผู้ดูแลระบบ',
  `userCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'รหัสนักศึกษา/รหัสอาจารย์',
  `classGroup` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'กลุ่มเรียน',
  `fullName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ชื่อ สกุล',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'อีเมล',
  `password` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'รหัสผ่าน',
  `mbti` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'รหัสรูปแบบบุคคลิกภาพ',
  `setting` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'การตั้งค่ารายบุคคล',
  `status` tinyint(4) DEFAULT 0 COMMENT 'สถานะการใช้งาน 0 ระงัย 1 ใช้งาน',
  PRIMARY KEY (`userID`),
  KEY `userTypeID` (`userTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ฐานข้อมูลผู้ใช้งานระบบ';

-- Dumping data for table studentgroupingsystem.user: ~8 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`userID`, `userTypeID`, `userCode`, `classGroup`, `fullName`, `email`, `password`, `mbti`, `setting`, `status`) VALUES
	(1, 1, 'admin', '', 'Administrator', 'admin@admin', '9075571a91e0af0b553b72ebb0bcd086ed8e9fa6234c430d73066378063f890d', '', '{"lang":"en"}', 1),
	(2, 2, 'teacher', '', 'Teacher', 'teacher@teacher', 'f6264593f90c9872a3951f6fc251dc16e1cd39c4bcb289eff5b3ff54a90c346a', '', '{"lang":"th"}', 1),
	(3, 3, '64000001', 'A', 'นายวิเลิศวัฒน์ หนูแสง', 'student@student', '6dea269a4234697c168753848e938f54ab89e4d01a6128842cec5ec13db617dc', 'ESTJ', '{"lang":"en"}', 1),
	(4, 3, '64000002', 'A', 'Student 2', 'student2@student', '7363c57f2499df79f66c81d7339a29757517e014b0bafeedcc4a176a271b0575', 'ISFP', NULL, 1),
	(5, 3, '64000003', 'A', 'Student 3', 'student3@student', 'ed04dcffcabc0a1cc2a93e59a563f9ae536a1b900cc4cec5a85da9f711137798', 'ENTJ', NULL, 1),
	(6, 3, '64000004', 'A', 'Student 4', 'student4@student', 'af618d8ba347de6ca948d3e5e0008c802947cca8e99c038004e20f9ae4bb482e', 'INFP', NULL, 1),
	(7, 3, '64000005', 'A', 'Student 5', 'student5@student', 'b009df28f0825de6f1bfd6d96630ce8f1ae2acebe56b36d5ad86b2277f89f120', 'INFJ', NULL, 1),
	(8, 3, '64000006', 'A', 'Student 6', 'student6@student', '59a51555df34b441122d1171eb4d973f6716529ea5b2c14c35888c908cd7eec6', 'ENTP', NULL, 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table studentgroupingsystem.user_type
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE IF NOT EXISTS `user_type` (
  `userTypeID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับประเภทผู้ใช้',
  `userType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ประเภทผู้ใช้',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'สถานะการใช้งาน 0 ระงับ 1 ใช้งาน',
  PRIMARY KEY (`userTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ฐานข้อมูลประเภทผู้ใช้';

-- Dumping data for table studentgroupingsystem.user_type: ~3 rows (approximately)
DELETE FROM `user_type`;
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` (`userTypeID`, `userType`, `status`) VALUES
	(1, 'ผู้ดูแลระบบ', 1),
	(2, 'อาจารย์', 1),
	(3, 'นักศึกษา', 1);
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

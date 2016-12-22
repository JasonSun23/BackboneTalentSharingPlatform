/*
 Navicat Premium Data Transfer

 Source Server         : LocalConn
 Source Server Type    : MySQL
 Source Server Version : 50716
 Source Host           : localhost
 Source Database       : Backbone

 Target Server Type    : MySQL
 Target Server Version : 50716
 File Encoding         : utf-8

 Date: 10/19/2016 21:48:29 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `Company`
-- ----------------------------
DROP TABLE IF EXISTS `Company`;
CREATE TABLE `Company` (
  `Company_ID` int(11) NOT NULL,
  `Company_Name` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  PRIMARY KEY (`Company_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Department`
-- ----------------------------
DROP TABLE IF EXISTS `Department`;
CREATE TABLE `Department` (
  `Deparment_ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `Department_Name` varchar(255) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `Zip` int(11) NOT NULL,
  `Dep_Mgr_Talent_ID` int(11) NOT NULL,
  `Mgr_EMD_Start_Date` date NOT NULL,
  `Bonus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Deparment_ID`,`Company_ID`,`Mgr_EMD_Start_Date`),
  KEY `Company_ID` (`Company_ID`),
  KEY `Dep_Mgr_Talent_ID` (`Dep_Mgr_Talent_ID`),
  CONSTRAINT `department_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `Company` (`Company_ID`),
  CONSTRAINT `department_ibfk_2` FOREIGN KEY (`Dep_Mgr_Talent_ID`) REFERENCES `Talent` (`Talent_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Employee`
-- ----------------------------
DROP TABLE IF EXISTS `Employee`;
CREATE TABLE `Employee` (
  `Talent_ID` int(11) NOT NULL,
  `Salary` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `Department_ID` int(11) NOT NULL,
  `EWC_Start_Date` date NOT NULL,
  `Position_ID` int(11) NOT NULL,
  `EHP_Start_Date` date NOT NULL,
  `Sup_Talent_ID` int(11) NOT NULL,
  PRIMARY KEY (`Talent_ID`,`EWC_Start_Date`,`EHP_Start_Date`),
  KEY `Company_ID` (`Company_ID`),
  KEY `Department_ID` (`Department_ID`),
  KEY `Position_ID` (`Position_ID`),
  KEY `Sup_Talent_ID` (`Sup_Talent_ID`),
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`Talent_ID`) REFERENCES `Talent` (`Talent_ID`),
  CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`Company_ID`) REFERENCES `Company` (`Company_ID`),
  CONSTRAINT `employee_ibfk_3` FOREIGN KEY (`Department_ID`) REFERENCES `Department` (`Deparment_ID`),
  CONSTRAINT `employee_ibfk_4` FOREIGN KEY (`Position_ID`) REFERENCES `Position` (`Position_ID`),
  CONSTRAINT `employee_ibfk_5` FOREIGN KEY (`Sup_Talent_ID`) REFERENCES `Talent` (`Talent_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Employee_Do_Training`
-- ----------------------------
DROP TABLE IF EXISTS `Employee_Do_Training`;
CREATE TABLE `Employee_Do_Training` (
  `Talent_ID` int(11) NOT NULL,
  `Training_ID` int(11) NOT NULL,
  `T_Grade` int(11) NOT NULL,
  PRIMARY KEY (`Talent_ID`,`Training_ID`),
  KEY `Training_ID` (`Training_ID`),
  CONSTRAINT `employee_do_training_ibfk_1` FOREIGN KEY (`Talent_ID`) REFERENCES `Talent` (`Talent_ID`),
  CONSTRAINT `employee_do_training_ibfk_2` FOREIGN KEY (`Training_ID`) REFERENCES `Training` (`Training_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `Employee_WorkOn_Project`
-- ----------------------------
DROP TABLE IF EXISTS `Employee_WorkOn_Project`;
CREATE TABLE `Employee_WorkOn_Project` (
  `Talent_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `P_Grade` int(11) NOT NULL,
  PRIMARY KEY (`Talent_ID`,`Project_ID`),
  KEY `Project_ID` (`Project_ID`),
  CONSTRAINT `employee_workon_project_ibfk_1` FOREIGN KEY (`Talent_ID`) REFERENCES `Talent` (`Talent_ID`),
  CONSTRAINT `employee_workon_project_ibfk_2` FOREIGN KEY (`Project_ID`) REFERENCES `Project` (`Project_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `KPI`
-- ----------------------------
DROP TABLE IF EXISTS `KPI`;
CREATE TABLE `KPI` (
  `Talent_ID` int(11) NOT NULL,
  `KPI_Period` date NOT NULL,
  `Score` int(11) NOT NULL,
  PRIMARY KEY (`Talent_ID`,`KPI_Period`),
  CONSTRAINT `kpi_ibfk_1` FOREIGN KEY (`Talent_ID`) REFERENCES `Talent` (`Talent_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Position`
-- ----------------------------
DROP TABLE IF EXISTS `Position`;
CREATE TABLE `Position` (
  `Position_ID` int(11) NOT NULL,
  `Position_Name` varchar(255) NOT NULL,
  `Base_Salary` int(11) NOT NULL,
  PRIMARY KEY (`Position_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Project`
-- ----------------------------
DROP TABLE IF EXISTS `Project`;
CREATE TABLE `Project` (
  `Project_ID` int(11) NOT NULL,
  `Project_Name` varchar(255) NOT NULL,
  `End_Date` date NOT NULL,
  `Quality` int(11) NOT NULL,
  `Pro_Mgr_Talent_ID` int(11) NOT NULL,
  PRIMARY KEY (`Project_ID`),
  KEY `Pro_Mgr_Talent_ID` (`Pro_Mgr_Talent_ID`),
  CONSTRAINT `project_ibfk_1` FOREIGN KEY (`Pro_Mgr_Talent_ID`) REFERENCES `Talent` (`Talent_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Project_include_Skill`
-- ----------------------------
DROP TABLE IF EXISTS `Project_include_Skill`;
CREATE TABLE `Project_include_Skill` (
  `Skill_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `Addition` int(11) NOT NULL,
  PRIMARY KEY (`Skill_ID`,`Project_ID`),
  KEY `Project_ID` (`Project_ID`),
  CONSTRAINT `project_include_skill_ibfk_1` FOREIGN KEY (`Skill_ID`) REFERENCES `Skill` (`Skill_ID`),
  CONSTRAINT `project_include_skill_ibfk_2` FOREIGN KEY (`Project_ID`) REFERENCES `Project` (`Project_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Skill`
-- ----------------------------
DROP TABLE IF EXISTS `Skill`;
CREATE TABLE `Skill` (
  `Skill_ID` int(11) NOT NULL,
  `Skill_Name` varchar(255) NOT NULL,
  PRIMARY KEY (`Skill_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Talent`
-- ----------------------------
DROP TABLE IF EXISTS `Talent`;
CREATE TABLE `Talent` (
  `Talent_ID` int(11) NOT NULL,
  `SSN` varchar(255) NOT NULL,
  `L_Name` varchar(255) NOT NULL,
  `M_Name` varchar(255) DEFAULT NULL,
  `F_Name` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `Zip` int(11) NOT NULL,
  `Gender` char(1) NOT NULL,
  `DoB` date NOT NULL,
  `Status` char(12) NOT NULL,
  `Xp` int(11) NOT NULL,
  `Level` int(11) NOT NULL,
  `MBTI` char(4) NOT NULL DEFAULT 'None',
  `J` int(11) NOT NULL DEFAULT '0',
  `E` int(11) NOT NULL DEFAULT '0',
  `T` int(11) NOT NULL DEFAULT '0',
  `S` int(11) NOT NULL DEFAULT '0',
  `I` int(11) NOT NULL DEFAULT '0',
  `N` int(11) NOT NULL DEFAULT '0',
  `F` int(11) NOT NULL DEFAULT '0',
  `P` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Talent_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Talent_GrdFm_University`
-- ----------------------------
DROP TABLE IF EXISTS `Talent_GrdFm_University`;
CREATE TABLE `Talent_GrdFm_University` (
  `Talent_ID` int(11) NOT NULL,
  `University_ID` int(11) NOT NULL,
  `Degree` varchar(255) NOT NULL,
  `GPA` float NOT NULL,
  PRIMARY KEY (`Talent_ID`,`University_ID`,`Degree`),
  KEY `University_ID` (`University_ID`),
  CONSTRAINT `talent_grdfm_university_ibfk_1` FOREIGN KEY (`Talent_ID`) REFERENCES `Talent` (`Talent_ID`),
  CONSTRAINT `talent_grdfm_university_ibfk_2` FOREIGN KEY (`University_ID`) REFERENCES `University` (`University_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Talent_Have_Skill`
-- ----------------------------
DROP TABLE IF EXISTS `Talent_Have_Skill`;
CREATE TABLE `Talent_Have_Skill` (
  `Talent_ID` int(11) NOT NULL,
  `Skill_ID` int(11) NOT NULL,
  `Skill_Score` int(11) NOT NULL,
  PRIMARY KEY (`Talent_ID`,`Skill_ID`),
  KEY `Skill_ID` (`Skill_ID`),
  CONSTRAINT `talent_have_skill_ibfk_1` FOREIGN KEY (`Talent_ID`) REFERENCES `Talent` (`Talent_ID`),
  CONSTRAINT `talent_have_skill_ibfk_2` FOREIGN KEY (`Skill_ID`) REFERENCES `Skill` (`Skill_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Training`
-- ----------------------------
DROP TABLE IF EXISTS `Training`;
CREATE TABLE `Training` (
  `Training_ID` int(11) NOT NULL,
  `Training_Name` varchar(255) NOT NULL,
  `End_Date` date NOT NULL,
  PRIMARY KEY (`Training_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Training_include_Skill`
-- ----------------------------
DROP TABLE IF EXISTS `Training_include_Skill`;
CREATE TABLE `Training_include_Skill` (
  `Skill_ID` int(11) NOT NULL,
  `Training_ID` int(11) NOT NULL,
  `Addition` int(11) NOT NULL,
  PRIMARY KEY (`Skill_ID`,`Training_ID`),
  KEY `Training_ID` (`Training_ID`),
  CONSTRAINT `training_include_skill_ibfk_1` FOREIGN KEY (`Skill_ID`) REFERENCES `Skill` (`Skill_ID`),
  CONSTRAINT `training_include_skill_ibfk_2` FOREIGN KEY (`Training_ID`) REFERENCES `Training` (`Training_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Unemployment`
-- ----------------------------
DROP TABLE IF EXISTS `Unemployment`;
CREATE TABLE `Unemployment` (
  `Talent_ID` int(11) NOT NULL,
  `Unemp_Start_Date` date NOT NULL,
  PRIMARY KEY (`Talent_ID`),
  CONSTRAINT `unemployment_ibfk_1` FOREIGN KEY (`Talent_ID`) REFERENCES `Talent` (`Talent_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `University`
-- ----------------------------
DROP TABLE IF EXISTS `University`;
CREATE TABLE `University` (
  `University_ID` int(11) NOT NULL,
  `University_Name` varchar(255) NOT NULL,
  PRIMARY KEY (`University_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;

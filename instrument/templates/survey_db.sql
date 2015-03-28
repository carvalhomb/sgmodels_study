-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Generation Time: Mar 28, 2015 at 03:08 PM
-- Server version: 5.1.56
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `sgsurvey_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `docs`
--

CREATE TABLE IF NOT EXISTS `docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atmsg_diagram` varchar(256) DEFAULT NULL,
  `atmsg_table` varchar(256) DEFAULT NULL,
  `lmgm_diagram` varchar(256) DEFAULT NULL,
  `lmgm_table` varchar(256) DEFAULT NULL,
  `token` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

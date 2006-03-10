-- phpMyAdmin SQL Dump
-- version 2.6.4-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:3306
-- Generation Time: Jan 28, 2006 at 02:38 PM
-- Server version: 4.1.15
-- PHP Version: 5.0.5
-- 
-- Database: `usertokenstorage`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `usertoken`
-- 

CREATE TABLE `usertoken` (
  `nonce` varchar(255) NOT NULL default '',
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`nonce`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

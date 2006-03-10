-- 
-- Tabellenstruktur für Tabelle `class_table`
-- 

CREATE TABLE class_table (
  class_table_id int(11) NOT NULL auto_increment, -- primary key
  class_name varchar(255) NOT NULL,			   -- class name
  class_file TEXT NOT NULL,					   -- file name to be included for accessing class
  use_wss tinyint(1) NOT NULL default '0',       -- use webservice security flag
  description TEXT,
  PRIMARY KEY  (class_table_id)
);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `method_table`
-- 

CREATE TABLE `method_table` (
  `method_table_id` int(11) NOT NULL auto_increment,
  `method_name` varchar(30) NOT NULL default '',
  `class_table_id` int(11) NOT NULL default '0',
  `publish` tinyint(1) NOT NULL default '1',
  `source_comment` int(11) default NULL,
  `source_comment_changed` tinyint(1) NOT NULL default '0',
  `user_comment` int(11) default NULL,
  `description` text,
  PRIMARY KEY  (`method_table_id`)
);


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `comment_table`
-- 

CREATE TABLE `comment_table` (
  `comment_table_id` int(11) NOT NULL auto_increment,
  `comment` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`comment_table_id`)
);



-- 
-- Daten für Tabelle `comment_table`
-- 

INSERT INTO `comment_table` VALUES (680, '', 'NULL');
INSERT INTO `comment_table` VALUES (681, '/**\n     * @webmethod\n     * @return void\n     */', 'NULL');
INSERT INTO `comment_table` VALUES (682, '/**\n     * @webmethod\n     * @return void\n     */', 'NULL');
INSERT INTO `comment_table` VALUES (683, '', 'NULL');
INSERT INTO `comment_table` VALUES (684, '/**\n     * @webmethod\n     * @return void\n     */', 'NULL');
INSERT INTO `comment_table` VALUES (685, '/**\n     * @webmethod\n     * @return void\n     */', 'NULL');
INSERT INTO `comment_table` VALUES (686, '', 'NULL');
INSERT INTO `comment_table` VALUES (687, '', 'NULL');
INSERT INTO `comment_table` VALUES (688, '', 'NULL');
INSERT INTO `comment_table` VALUES (689, '', 'NULL');
INSERT INTO `comment_table` VALUES (690, '', 'NULL');
INSERT INTO `comment_table` VALUES (691, '', 'NULL');
INSERT INTO `comment_table` VALUES (692, '', 'NULL');
INSERT INTO `comment_table` VALUES (693, '', 'NULL');
INSERT INTO `comment_table` VALUES (694, '', 'NULL');
INSERT INTO `comment_table` VALUES (695, '', 'NULL');
INSERT INTO `comment_table` VALUES (696, '', 'NULL');
INSERT INTO `comment_table` VALUES (697, '', 'NULL');
INSERT INTO `comment_table` VALUES (698, '', 'NULL');
INSERT INTO `comment_table` VALUES (699, '', 'NULL');
INSERT INTO `comment_table` VALUES (700, '', 'NULL');
INSERT INTO `comment_table` VALUES (701, '', 'NULL');
INSERT INTO `comment_table` VALUES (702, '', 'NULL');
INSERT INTO `comment_table` VALUES (703, '', 'NULL');
INSERT INTO `comment_table` VALUES (704, '', 'NULL');
INSERT INTO `comment_table` VALUES (705, '', 'NULL');
INSERT INTO `comment_table` VALUES (706, '', 'NULL');
INSERT INTO `comment_table` VALUES (707, '', 'NULL');
INSERT INTO `comment_table` VALUES (708, '', 'NULL');
INSERT INTO `comment_table` VALUES (709, '', 'NULL');
INSERT INTO `comment_table` VALUES (710, '', 'NULL');
INSERT INTO `comment_table` VALUES (711, '', 'NULL');
INSERT INTO `comment_table` VALUES (712, '', 'NULL');
INSERT INTO `comment_table` VALUES (713, '', 'NULL');
INSERT INTO `comment_table` VALUES (714, '', 'NULL');
INSERT INTO `comment_table` VALUES (715, '', 'NULL');
INSERT INTO `comment_table` VALUES (716, '', 'NULL');
INSERT INTO `comment_table` VALUES (717, '', 'NULL');
INSERT INTO `comment_table` VALUES (718, '', 'NULL');
INSERT INTO `comment_table` VALUES (719, '', 'NULL');
INSERT INTO `comment_table` VALUES (720, '', 'NULL');
INSERT INTO `comment_table` VALUES (721, '', 'NULL');
INSERT INTO `comment_table` VALUES (722, '', 'NULL');
INSERT INTO `comment_table` VALUES (723, '', 'NULL');
INSERT INTO `comment_table` VALUES (724, '', 'NULL');
INSERT INTO `comment_table` VALUES (725, '', 'NULL');
INSERT INTO `comment_table` VALUES (726, '', 'NULL');
INSERT INTO `comment_table` VALUES (727, '', 'NULL');
INSERT INTO `comment_table` VALUES (728, '', 'NULL');
INSERT INTO `comment_table` VALUES (729, '', 'NULL');
INSERT INTO `comment_table` VALUES (730, '', 'NULL');
INSERT INTO `comment_table` VALUES (731, '', 'NULL');
INSERT INTO `comment_table` VALUES (732, '', 'NULL');
INSERT INTO `comment_table` VALUES (733, '', 'NULL');
INSERT INTO `comment_table` VALUES (734, '', 'NULL');
INSERT INTO `comment_table` VALUES (735, '', 'NULL');
INSERT INTO `comment_table` VALUES (736, '', 'NULL');
INSERT INTO `comment_table` VALUES (737, '', 'NULL');
INSERT INTO `comment_table` VALUES (738, '', 'NULL');
INSERT INTO `comment_table` VALUES (739, '', 'NULL');
INSERT INTO `comment_table` VALUES (740, '', 'NULL');
INSERT INTO `comment_table` VALUES (741, '', 'NULL');
INSERT INTO `comment_table` VALUES (742, '', 'NULL');
INSERT INTO `comment_table` VALUES (743, '', 'NULL');
INSERT INTO `comment_table` VALUES (744, '', 'NULL');
INSERT INTO `comment_table` VALUES (745, '', 'NULL');
INSERT INTO `comment_table` VALUES (746, '', 'NULL');
INSERT INTO `comment_table` VALUES (747, '', 'NULL');
INSERT INTO `comment_table` VALUES (748, '', 'NULL');
INSERT INTO `comment_table` VALUES (749, '', 'NULL');
INSERT INTO `comment_table` VALUES (750, '', 'NULL');
INSERT INTO `comment_table` VALUES (751, '', 'NULL');
INSERT INTO `comment_table` VALUES (752, '', 'NULL');
INSERT INTO `comment_table` VALUES (753, '', 'NULL');
INSERT INTO `comment_table` VALUES (754, '', 'NULL');
INSERT INTO `comment_table` VALUES (755, '', 'NULL');
INSERT INTO `comment_table` VALUES (756, '', 'NULL');
INSERT INTO `comment_table` VALUES (757, '', 'NULL');
INSERT INTO `comment_table` VALUES (758, '', 'NULL');
INSERT INTO `comment_table` VALUES (759, '', 'NULL');
INSERT INTO `comment_table` VALUES (760, '', 'NULL');
INSERT INTO `comment_table` VALUES (761, '', 'NULL');


-- 
-- Daten für Tabelle `class_table`
-- 

INSERT INTO `class_table` VALUES (26, 'StatisticDetails', 0, NULL);
INSERT INTO `class_table` VALUES (27, 'DOMText', 0, NULL);
INSERT INTO `class_table` VALUES (28, 'DOMCharacterData', 0, NULL);
INSERT INTO `class_table` VALUES (29, 'DOMNode', 0, NULL);
INSERT INTO `class_table` VALUES (30, 'COMPersistHelper', 0, NULL);


-- 
-- Daten für Tabelle `method_table`
-- 

INSERT INTO `method_table` VALUES (189, '__construct', 0, 1, 680, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (190, '__construct', 12, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (191, 'guessMimeType', 12, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (192, 'shouldCountLines', 12, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (193, '__clone', 0, 1, 465, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (194, '__clone', 13, 0, 454, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (195, '__construct', 13, 0, 455, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (196, 'getMessage', 13, 1, 456, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (197, 'getCode', 13, 0, 457, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (198, 'getFile', 13, 0, 458, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (199, 'getLine', 13, 1, 459, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (200, 'getTrace', 13, 0, 460, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (201, 'getTraceAsString', 13, 0, 461, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (202, '__toString', 13, 0, 462, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (203, 'getModifierNames', 0, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (204, 'export', 14, 1, 637, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (205, 'export', 15, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (206, '__construct', 15, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (207, '__toString', 15, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (208, 'isInternal', 15, 1, 510, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (209, 'isUserDefined', 15, 1, 511, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (210, 'getName', 15, 1, 512, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (211, 'getFileName', 15, 1, 513, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (212, 'getStartLine', 15, 1, 514, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (213, 'getEndLine', 15, 1, 515, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (214, 'getDocComment', 15, 1, 516, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (215, 'getStaticVariables', 15, 1, 517, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (216, 'invoke', 15, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (217, 'invokeArgs', 15, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (218, 'returnsReference', 15, 1, 518, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (219, 'getParameters', 15, 1, 519, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (220, 'getNumberOfParameters', 15, 1, 520, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (221, 'getNumberOfRequiredParameters', 15, 1, 521, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (222, 'export', 16, 0, 625, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (223, '__construct', 16, 0, 626, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (224, '__toString', 16, 0, 627, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (225, 'getName', 16, 0, 628, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (226, 'isPassedByReference', 16, 0, 629, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (227, 'getClass', 16, 0, 630, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (228, 'isArray', 16, 1, 631, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (229, 'allowsNull', 16, 1, 632, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (230, 'isOptional', 16, 0, 633, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (231, 'isDefaultValueAvailable', 16, 0, 634, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (232, 'getDefaultValue', 16, 0, 635, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (233, 'export', 0, 1, 560, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (234, '__construct', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (235, '__toString', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (236, 'isPublic', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (237, 'isPrivate', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (238, 'isProtected', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (239, 'isAbstract', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (240, 'isFinal', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (241, 'isStatic', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (242, 'isConstructor', 17, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (243, 'isDestructor', 17, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (244, 'getModifiers', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (245, 'invoke', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (246, 'invokeArgs', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (247, 'getDeclaringClass', 17, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (248, '__clone', 15, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (249, 'export', 18, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (250, '__construct', 18, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (251, '__toString', 18, 0, 563, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (252, 'getName', 18, 0, 564, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (253, 'isInternal', 18, 0, 565, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (254, 'isUserDefined', 18, 0, 566, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (255, 'isInstantiable', 18, 0, 567, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (256, 'getFileName', 18, 0, 568, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (257, 'getStartLine', 18, 0, 569, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (258, 'getEndLine', 18, 0, 570, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (259, 'getDocComment', 18, 0, 571, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (260, 'getConstructor', 18, 0, 572, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (261, 'hasMethod', 18, 0, 573, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (262, 'getMethod', 18, 1, 574, 0, 623, NULL);
INSERT INTO `method_table` VALUES (263, 'getMethods', 18, 1, 575, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (264, 'hasProperty', 18, 1, 576, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (265, 'getProperty', 18, 1, 577, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (266, 'getProperties', 18, 1, 578, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (267, 'hasConstant', 18, 1, 579, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (268, 'getConstants', 18, 1, 580, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (269, 'getConstant', 18, 1, 581, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (270, 'getInterfaces', 18, 1, 582, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (271, 'isInterface', 18, 1, 583, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (272, 'isAbstract', 18, 1, 584, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (273, 'isFinal', 18, 1, 585, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (274, 'getModifiers', 18, 1, 586, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (275, 'isInstance', 18, 1, 587, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (276, 'newInstance', 18, 0, 588, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (277, 'getParentClass', 18, 0, 589, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (278, 'isSubclassOf', 18, 0, 590, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (279, 'getStaticProperties', 18, 0, 591, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (280, 'getStaticPropertyValue', 18, 0, 592, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (281, 'setStaticPropertyValue', 18, 0, 593, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (282, 'getDefaultProperties', 18, 0, 594, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (283, 'isIterateable', 18, 0, 595, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (284, 'implementsInterface', 18, 0, 596, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (285, 'getExtension', 18, 0, 597, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (286, 'getExtensionName', 18, 0, 598, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (287, '__construct', 19, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (288, '__clone', 18, 0, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (289, 'export', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (290, '__construct', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (291, '__toString', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (292, 'getName', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (293, 'getValue', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (294, 'setValue', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (295, 'isPublic', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (296, 'isPrivate', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (297, 'isProtected', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (298, 'isStatic', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (299, 'isDefault', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (300, 'getModifiers', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (301, 'getDeclaringClass', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (302, 'getDocComment', 20, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (303, 'export', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (304, '__construct', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (305, '__toString', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (306, 'getName', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (307, 'getVersion', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (308, 'getFunctions', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (309, 'getConstants', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (310, 'getINIEntries', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (311, 'getClasses', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (312, 'getClassNames', 21, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (313, '__clone', 16, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (314, 'getModifierNames', 14, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (315, 'GetCurFileName', 22, 0, 647, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (316, 'SaveToFile', 22, 0, 648, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (317, 'LoadFromFile', 22, 0, 649, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (318, 'GetMaxStreamSize', 22, 1, 650, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (319, 'InitNew', 22, 1, 651, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (320, 'LoadFromStream', 22, 0, 652, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (321, 'SaveToStream', 22, 0, 653, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (322, '__construct', 22, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (323, 'rewind', 23, 0, 674, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (324, 'valid', 23, 1, 675, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (325, 'key', 23, 0, 676, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (326, 'current', 23, 1, 677, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (327, 'next', 23, 0, 678, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (328, 'getInnerIterator', 23, 1, 679, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (329, 'rewind', 24, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (330, 'valid', 24, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (331, 'key', 24, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (332, 'current', 24, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (333, 'next', 24, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (334, 'getInnerIterator', 24, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (335, 'append', 25, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (336, 'rewind', 25, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (337, 'valid', 25, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (338, 'key', 25, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (339, 'current', 25, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (340, 'next', 25, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (341, 'getInnerIterator', 25, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (342, '__construct', 23, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (343, 'guessMimeType', 26, 1, 684, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (344, 'shouldCountLines', 26, 0, 685, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (345, '__construct', 26, 1, 745, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (346, 'splitText', 0, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (347, 'isWhitespaceInElementContent', 27, 1, 715, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (348, 'isElementContentWhitespace', 27, 0, 716, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (349, 'replaceWholeText', 27, 0, 717, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (350, '__construct', 27, 0, 718, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (351, 'substringData', 0, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (352, 'appendData', 28, 1, 720, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (353, 'insertData', 28, 1, 721, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (354, 'deleteData', 28, 1, 722, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (355, 'replaceData', 28, 1, 723, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (356, 'insertBefore', 0, 1, NULL, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (357, 'replaceChild', 29, 1, 725, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (358, 'removeChild', 29, 1, 726, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (359, 'appendChild', 29, 1, 727, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (360, 'hasChildNodes', 29, 1, 728, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (361, 'cloneNode', 29, 1, 729, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (362, 'normalize', 29, 1, 730, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (363, 'isSupported', 29, 1, 731, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (364, 'hasAttributes', 29, 1, 732, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (365, 'compareDocumentPosition', 29, 1, 733, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (366, 'isSameNode', 29, 1, 734, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (367, 'lookupPrefix', 29, 1, 735, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (368, 'isDefaultNamespace', 29, 1, 736, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (369, 'lookupNamespaceUri', 29, 1, 737, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (370, 'isEqualNode', 29, 1, 738, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (371, 'getFeature', 29, 1, 739, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (372, 'setUserData', 29, 1, 740, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (373, 'getUserData', 29, 1, 741, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (374, 'splitText', 27, 0, 742, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (375, 'substringData', 28, 1, 743, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (376, 'insertBefore', 29, 1, 744, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (377, 'GetCurFileName', 30, 0, 754, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (378, 'SaveToFile', 30, 0, 755, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (379, 'LoadFromFile', 30, 1, 756, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (380, 'GetMaxStreamSize', 30, 0, 757, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (381, 'InitNew', 30, 0, 758, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (382, 'LoadFromStream', 30, 0, 759, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (383, 'SaveToStream', 30, 0, 760, 0, NULL, NULL);
INSERT INTO `method_table` VALUES (384, '__construct', 30, 0, 761, 0, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tool_properties`
-- 

CREATE TABLE `tool_properties` (
  `id` int(11) NOT NULL auto_increment,
  `property` varchar(30) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Speichert Eigenschaften des Admin-Tools' AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `tool_properties`
-- 

INSERT INTO `tool_properties` VALUES (1, 'stats_root', '/Webprogrammierung/source/tools/admin-tool', NULL);
INSERT INTO `tool_properties` VALUES (2, 'firstStart', '1', NULL);

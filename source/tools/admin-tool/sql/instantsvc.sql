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
);


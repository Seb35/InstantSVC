CREATE TABLE users (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NULL,
  pwd_md5 VARCHAR(32) NULL,
  pwd_rfc2671 VARCHAR(32) NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tags (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  PRIMARY KEY(id),
  UNIQUE INDEX title(title)
);

CREATE TABLE bookmarks (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INTEGER UNSIGNED NOT NULL,
  title TEXT NULL,
  description TEXT NULL,
  uri TEXT NULL,
  PRIMARY KEY(id),
  INDEX bookmarks_FKIndex1(user_id),
  FOREIGN KEY(user_id)
    REFERENCES users(id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE tags_has_bookmarks (
  tags_id INTEGER UNSIGNED NOT NULL,
  bookmarks_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(tags_id, bookmarks_id),
  INDEX tags_has_bookmarks_FKIndex1(tags_id),
  INDEX tags_has_bookmarks_FKIndex2(bookmarks_id),
  FOREIGN KEY(tags_id)
    REFERENCES tags(id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(bookmarks_id)
    REFERENCES bookmarks(id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

#
# Dumping data for table bookmarks
#

INSERT INTO `bookmarks` VALUES (119,2,'Dynamic HTML and XML: The XMLHttpRequest Object','','http://developer.apple.com/internet/webcontent/xmlhttpreq.html','2006-02-28 00:17:13');
INSERT INTO `bookmarks` VALUES (120,2,'Web Services Addressing (WS-Addressing)','','http://www.w3.org/Submission/ws-addressing/','2006-02-28 00:19:45');
INSERT INTO `bookmarks` VALUES (121,2,'RFC 2818: HTTP Over TLS','','http://www.ietf.org/rfc/rfc2818.txt','2006-02-28 00:21:22');
INSERT INTO `bookmarks` VALUES (122,2,'The XML Bookmark Exchange Language (XBEL)','','http://pyxml.sourceforge.net/topics/xbel/','2006-02-28 00:35:55');
INSERT INTO `bookmarks` VALUES (123,2,'RestWiki: InterfaceGenericity','','http://rest.blueoxen.net/cgi-bin/wiki.pl?InterfaceGenericity','2006-02-28 00:38:21');
INSERT INTO `bookmarks` VALUES (124,2,'RFC 2396 - Uniform Resource Identifiers (URI): Generic Syntax','','http://www.faqs.org/rfcs/rfc2396.html','2006-02-28 00:39:50');
INSERT INTO `bookmarks` VALUES (125,2,'Microformats in REST Web Services','','http://microformats.org/wiki/rest','2006-02-28 01:12:24');
INSERT INTO `bookmarks` VALUES (126,2,'RESTified Rails Controller','','http://microformats.org/discuss/mail/microformats-rest/2005-November/000042.html','2006-02-28 01:13:30');
INSERT INTO `bookmarks` VALUES (127,2,'Is it the message or the transport','','http://www.mcdowall.com/2005/03/is-it-message-or-transport.html','2006-02-28 01:15:12');
INSERT INTO `bookmarks` VALUES (128,2,'Google\'s Gaffe','','http://groups.yahoo.com/group/rest-discuss/message/1055','2006-02-28 01:16:28');
INSERT INTO `bookmarks` VALUES (129,2,'REST/SOAP ideas summary','','http://groups.yahoo.com/group/rest-discuss/message/1301','2006-02-28 01:17:13');
INSERT INTO `bookmarks` VALUES (130,2,'RESTlet','','http://www.restlet.org/','2006-02-28 01:18:28');
INSERT INTO `bookmarks` VALUES (131,2,'Building Web Services the REST Way','','http://www.xfront.com/REST-Web-Services.html','2006-02-28 01:19:24');
INSERT INTO `bookmarks` VALUES (132,2,'How to Create a REST Protocol','','http://www.xml.com/pub/a/2004/12/01/restful-web.html','2006-02-28 01:20:04');
INSERT INTO `bookmarks` VALUES (133,2,'RFC 2616 - Hypertext Transfer Protocol -- HTTP/1.1','','http://www.faqs.org/rfcs/rfc2616.html','2006-02-28 01:21:44');
INSERT INTO `bookmarks` VALUES (134,2,'SOAP Version 1.2 Part 1: Messaging Framework','','http://www.w3.org/TR/soap12-part1/','2006-02-28 01:22:23');

#
# Dumping data for table tags
#

INSERT INTO `tags` VALUES (16,'AJAX');
INSERT INTO `tags` VALUES (17,'JavaScript');
INSERT INTO `tags` VALUES (18,'XML');
INSERT INTO `tags` VALUES (19,'Apple');
INSERT INTO `tags` VALUES (20,'SOAP');
INSERT INTO `tags` VALUES (21,'Web Services');
INSERT INTO `tags` VALUES (22,'W3C');
INSERT INTO `tags` VALUES (23,'HTTP');
INSERT INTO `tags` VALUES (24,'HTTPS');
INSERT INTO `tags` VALUES (25,'REST');
INSERT INTO `tags` VALUES (26,'Security');
INSERT INTO `tags` VALUES (27,'RFC');
INSERT INTO `tags` VALUES (28,'XBEL');
INSERT INTO `tags` VALUES (29,'Bookmarks');
INSERT INTO `tags` VALUES (30,'Python');
INSERT INTO `tags` VALUES (31,'URI');
INSERT INTO `tags` VALUES (32,'Microformats');
INSERT INTO `tags` VALUES (33,'Rails');
INSERT INTO `tags` VALUES (34,'Ruby');
INSERT INTO `tags` VALUES (35,'Google');
INSERT INTO `tags` VALUES (36,'API');
INSERT INTO `tags` VALUES (37,'Java');
INSERT INTO `tags` VALUES (38,'Jetty');
INSERT INTO `tags` VALUES (39,'Servlet');

#
# Dumping data for table tags_has_bookmarks
#

INSERT INTO `tags_has_bookmarks` VALUES (16,119);
INSERT INTO `tags_has_bookmarks` VALUES (17,119);
INSERT INTO `tags_has_bookmarks` VALUES (18,119);
INSERT INTO `tags_has_bookmarks` VALUES (18,120);
INSERT INTO `tags_has_bookmarks` VALUES (18,122);
INSERT INTO `tags_has_bookmarks` VALUES (19,119);
INSERT INTO `tags_has_bookmarks` VALUES (20,120);
INSERT INTO `tags_has_bookmarks` VALUES (20,127);
INSERT INTO `tags_has_bookmarks` VALUES (20,128);
INSERT INTO `tags_has_bookmarks` VALUES (20,129);
INSERT INTO `tags_has_bookmarks` VALUES (20,134);
INSERT INTO `tags_has_bookmarks` VALUES (21,120);
INSERT INTO `tags_has_bookmarks` VALUES (21,123);
INSERT INTO `tags_has_bookmarks` VALUES (21,131);
INSERT INTO `tags_has_bookmarks` VALUES (21,132);
INSERT INTO `tags_has_bookmarks` VALUES (22,120);
INSERT INTO `tags_has_bookmarks` VALUES (22,134);
INSERT INTO `tags_has_bookmarks` VALUES (23,121);
INSERT INTO `tags_has_bookmarks` VALUES (23,124);
INSERT INTO `tags_has_bookmarks` VALUES (23,127);
INSERT INTO `tags_has_bookmarks` VALUES (23,128);
INSERT INTO `tags_has_bookmarks` VALUES (23,129);
INSERT INTO `tags_has_bookmarks` VALUES (23,133);
INSERT INTO `tags_has_bookmarks` VALUES (24,121);
INSERT INTO `tags_has_bookmarks` VALUES (25,121);
INSERT INTO `tags_has_bookmarks` VALUES (25,123);
INSERT INTO `tags_has_bookmarks` VALUES (25,124);
INSERT INTO `tags_has_bookmarks` VALUES (25,125);
INSERT INTO `tags_has_bookmarks` VALUES (25,126);
INSERT INTO `tags_has_bookmarks` VALUES (25,127);
INSERT INTO `tags_has_bookmarks` VALUES (25,128);
INSERT INTO `tags_has_bookmarks` VALUES (25,129);
INSERT INTO `tags_has_bookmarks` VALUES (25,130);
INSERT INTO `tags_has_bookmarks` VALUES (25,131);
INSERT INTO `tags_has_bookmarks` VALUES (25,132);
INSERT INTO `tags_has_bookmarks` VALUES (25,133);
INSERT INTO `tags_has_bookmarks` VALUES (26,121);
INSERT INTO `tags_has_bookmarks` VALUES (27,121);
INSERT INTO `tags_has_bookmarks` VALUES (27,124);
INSERT INTO `tags_has_bookmarks` VALUES (28,122);
INSERT INTO `tags_has_bookmarks` VALUES (29,122);
INSERT INTO `tags_has_bookmarks` VALUES (30,122);
INSERT INTO `tags_has_bookmarks` VALUES (31,124);
INSERT INTO `tags_has_bookmarks` VALUES (32,125);
INSERT INTO `tags_has_bookmarks` VALUES (33,126);
INSERT INTO `tags_has_bookmarks` VALUES (34,126);
INSERT INTO `tags_has_bookmarks` VALUES (35,128);
INSERT INTO `tags_has_bookmarks` VALUES (36,128);
INSERT INTO `tags_has_bookmarks` VALUES (37,130);
INSERT INTO `tags_has_bookmarks` VALUES (38,130);
INSERT INTO `tags_has_bookmarks` VALUES (39,130);

#
# Dumping data for table users
#

INSERT INTO `users` VALUES (1,'test',NULL,NULL);
INSERT INTO `users` VALUES (2,'stefan',NULL,NULL);



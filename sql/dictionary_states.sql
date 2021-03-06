delete from dictionary where id_property = (SELECT id FROM `properties` WHERE `code` = 'State');

INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','AK','Alaska',1);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','AL','Alabama',2);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','AZ','Arizona',3);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','AR','Arkansas',4);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','CA','California',5);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','CO','Colorado',6);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','CT','Connecticut',7);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','DE','Delaware',8);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','FL','Florida',9);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','GA','Georgia',10);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','HI','Hawaii',11);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','ID','Idaho',12);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','IL','Illinois',13);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','IN','Indiana',14);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','IA','Iowa',15);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','KS','Kansas',16);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','KY','Kentucky',17);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','LA','Louisiana',18);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','ME','Maine',19);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','MD','Maryland',20);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','MA','Massachusetts',21);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','MI','Michigan',22);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','MN','Minnesota',23);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','MS','Mississippi',24);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','MO','Missouri',25);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','MT','Montana',26);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','NE','Nebraska',27);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','NV','Nevada',28);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','NH','New Hampshire',29);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','NJ','New Jersey',30);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','NM','New Mexico',31);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','NY','New York',32);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','NC','North Carolina',33);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','ND','North Dakota',34);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','OH','Ohio',35);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','OK','Oklahoma',36);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','OR','Oregon',37);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','PA','Pennsylvania',38);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','RI','Rhode Island',39);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','SC','South Carolina',40);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','SD','South Dakota',41);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','TN','Tennessee',42);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','TX','Texas',43);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','UT','Utah',44);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','VT','Vermont',45);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','VA','Virginia',46);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','WA','Washington',47);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','WV','West Virginia',48);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','WI','Wisconsin',49);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','WY','Wyoming',50);
INSERT INTO `dictionary` (`id_property`,`xcode`,`code`,`name`,`pos`) VALUES ((SELECT id FROM `properties` WHERE `code` = 'State'),'US','PR','Puerto Rico',51);  
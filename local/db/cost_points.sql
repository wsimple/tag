
DROP TABLE IF EXISTS `cost_points`;
CREATE TABLE `cost_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_typecurrency` int(11) NOT NULL,
  `amount_from` decimal(11,0) NOT NULL,
  `amount_to` decimal(11,0) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cost` decimal(6,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*
-- Query: SELECT * FROM seemytag.cost_points
LIMIT 0, 1000

-- Date: 2013-09-12 09:37
*/
INSERT INTO `cost_points` (`id`,`id_typecurrency`,`amount_from`,`amount_to`,`status`,`date`,`cost`) VALUES (6,1,1,1,1,'2013-08-12 20:00:00',0.0500);

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `match_nr` int(11) NOT NULL,
  `opponent` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `home` tinyint(1) NOT NULL,
  `score_we` tinyint(4) NOT NULL,
  `score_they` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=321 ;


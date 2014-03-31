-- --------------------------------------------------------

--
-- Structure de la table `contact_provider`
--

CREATE TABLE IF NOT EXISTS `membre_provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider` varchar(50) NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `membre_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8_general_ci ;

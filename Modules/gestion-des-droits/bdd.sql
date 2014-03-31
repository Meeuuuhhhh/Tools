-- --------------------------------------------------------

--
-- Structure de la table `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupe` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_groupe_nom` (`groupe`,`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offre_action_valeur`
--

CREATE TABLE IF NOT EXISTS `offre_action_valeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offre_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `valeur` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`offre_id`,`action_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8_general_ci;
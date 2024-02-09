-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 09 fév. 2024 à 12:43
-- Version du serveur : 8.0.31
-- Version de PHP : 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `manger`
--

-- --------------------------------------------------------

--
-- Structure de la table `aliment`
--

DROP TABLE IF EXISTS `aliment`;
CREATE TABLE IF NOT EXISTS `aliment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=711 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `aliment`
--

INSERT INTO `aliment` (`id`, `nom`) VALUES
(360, 'Abricot'),
(361, 'Acerola'),
(362, 'Agneau'),
(363, 'Aiglefin'),
(364, 'Ail'),
(365, 'Ail des ours'),
(366, 'Airelle'),
(367, 'Aki'),
(368, 'Algue'),
(369, 'Algue nori'),
(370, 'Amande'),
(371, 'Ambérique et dolique'),
(372, 'Amidon'),
(373, 'Ananas'),
(374, 'Anchois'),
(375, 'Aneth'),
(376, 'Anguille'),
(377, 'Anis vert'),
(378, 'Anone'),
(379, 'Appenzeller'),
(380, 'Arachide'),
(381, 'Arbouse'),
(382, 'Argousier'),
(383, 'Arrow-root'),
(384, 'Artichaut'),
(385, 'Asperge'),
(386, 'Asperge blanche'),
(387, 'Aubergine'),
(388, 'Avocat'),
(389, 'Avoine'),
(390, 'Baies roses'),
(391, 'Banane plantain'),
(392, 'Bananes'),
(393, 'Bar'),
(394, 'Basilic'),
(395, 'Beaufort'),
(396, 'Bergamote'),
(397, 'Bette à carde'),
(398, 'Betterave'),
(399, 'Beurre'),
(400, 'Biscotte'),
(401, 'Blé'),
(402, 'Blette'),
(403, 'Bleuet'),
(404, 'Boeuf'),
(405, 'Bok Choy'),
(406, 'Boulghour'),
(407, 'Brocolis'),
(408, 'Brugnon'),
(409, 'Bulot'),
(410, 'Burrata'),
(411, 'Butternut'),
(412, 'Cabillaud'),
(413, 'Cacao'),
(414, 'Café'),
(415, 'Caille'),
(416, 'Calebasse'),
(417, 'Calamar, pieuvre'),
(418, 'Camembert'),
(419, 'Canard'),
(420, 'Cancoillotte'),
(421, 'Canneberge'),
(422, 'Cannelle'),
(423, 'Câpres'),
(424, 'Carambole'),
(425, 'Cardamome'),
(426, 'Carotte'),
(427, 'Carotte violette'),
(428, 'Cassis'),
(429, 'Cébette'),
(430, 'Céleri'),
(431, 'Céleri-rave'),
(432, 'Cèpes'),
(433, 'Cerfeuil'),
(434, 'Cerise'),
(435, 'Champignon'),
(436, 'Champignons portobello'),
(437, 'Chanterelles'),
(438, 'Châtaigne'),
(439, 'Chayotte'),
(440, 'Cheddar'),
(441, 'Daikon'),
(442, 'Datte'),
(443, 'Dinde'),
(444, 'Dorade'),
(445, 'Dulse'),
(446, 'Durian'),
(447, 'Echalote'),
(448, 'Écrevisse'),
(449, 'Emmental'),
(450, 'Endive'),
(451, 'Endive'),
(452, 'Enoki'),
(453, 'Épeautre'),
(454, 'Epinards'),
(455, 'Estragon'),
(456, 'Fane de radis'),
(457, 'Farine complète'),
(458, 'Farine d\'avoine'),
(459, 'Farine d\'épeautre'),
(460, 'Farine de châtaigne'),
(461, 'Farine de coco'),
(462, 'Farine de Kamut'),
(463, 'Farine de maïs'),
(464, 'Farine de manioc'),
(465, 'Farine de millet'),
(466, 'Farine de pois chiche'),
(467, 'Farine de quinoa'),
(468, 'Farine de riz'),
(469, 'Farine de sarrasin'),
(470, 'Farine de seigle'),
(471, 'Farine de sorgho'),
(472, 'Farine de souchet'),
(473, 'Farine de tapioca'),
(474, 'Farine de teff'),
(475, 'Feijoa'),
(476, 'Fenouil'),
(477, 'Feta'),
(478, 'Fève des Marais'),
(479, 'Figue'),
(480, 'Figue de Barbarie'),
(481, 'Flageolet'),
(482, 'Flétan'),
(483, 'Foie gras'),
(484, 'Fonio'),
(485, 'Garam Masala'),
(486, 'Ghee'),
(487, 'Gingembre'),
(488, 'Girolle'),
(489, 'Baie de Goji'),
(490, 'Gomasio'),
(491, 'Gombo'),
(492, 'Gorgonzola'),
(493, 'Gouda'),
(494, 'Goyave'),
(495, 'Grenade'),
(496, 'Grenouille'),
(497, 'Griottes'),
(498, 'Groseille'),
(499, 'Hareng'),
(500, 'Haricots coco'),
(501, 'Haricots commun'),
(502, 'Haricots mungo'),
(503, 'Haricots noirs'),
(504, 'Haricots rouges'),
(505, 'Haricots secs'),
(506, 'Homard'),
(507, 'Huile de canola'),
(508, 'Huile de palme'),
(509, 'Huiles végétales'),
(510, 'Huître'),
(511, 'Igname'),
(512, 'Jicama'),
(513, 'Jujube'),
(514, 'Kaki'),
(515, 'Kale'),
(516, 'Kéfir'),
(517, 'Kinako'),
(518, 'Kiwi'),
(519, 'Kombucha'),
(520, 'Konjac'),
(521, 'Kumquat'),
(522, 'Lait'),
(523, 'Lait d\'amande'),
(524, 'Lait d\'avoine'),
(525, 'Lait de coco'),
(526, 'Lait de noisette'),
(527, 'Lait de noisette'),
(528, 'Lait de ribot'),
(529, 'Lait de riz'),
(530, 'Lait de soja'),
(531, 'Laitue'),
(532, 'Langoustine'),
(533, 'Lapin'),
(534, 'Laurier'),
(535, 'Lentilles'),
(536, 'Lieu'),
(537, 'Limande'),
(538, 'Litchi'),
(539, 'Longane'),
(540, 'Lotte'),
(541, 'Loup'),
(542, 'Luzerne'),
(543, 'Maca'),
(544, 'Mâche'),
(545, 'Mahi Mahi'),
(546, 'Maïs'),
(547, 'Malanga'),
(548, 'Mandarine'),
(549, 'Mangue'),
(550, 'Manioc'),
(551, 'Maquereau'),
(552, 'Maracuja'),
(553, 'Margarine végétale'),
(554, 'Maroilles'),
(555, 'Marron'),
(556, 'Mascarpone'),
(557, 'Mélasse'),
(558, 'Melon'),
(559, 'Menthe'),
(560, 'Merlan'),
(561, 'Mérou'),
(562, 'Mesclun'),
(563, 'Miel'),
(564, 'Millet'),
(565, 'Mirabelle'),
(566, 'Miso'),
(567, 'Morue'),
(568, 'Moule'),
(569, 'Moutarde'),
(570, 'Mouton'),
(571, 'Mozzarella'),
(572, 'Navet'),
(573, 'Nectarine'),
(574, 'Nèfle'),
(575, 'Noisette'),
(576, 'Noix'),
(577, 'Noix de cajou'),
(578, 'Noix de coco'),
(579, 'Noix de kola'),
(580, 'Noix de Macadamia'),
(581, 'Noix de muscade'),
(582, 'Noix de pécan'),
(583, 'Noix du Brésil'),
(584, 'Oca du Pérou'),
(585, 'Oeuf'),
(586, 'Œuf Masago'),
(587, 'Œufs de saumon'),
(588, 'Oie'),
(589, 'Oignon'),
(590, 'Oignon rouge'),
(591, 'Oignon vert'),
(592, 'Olive'),
(593, 'Olives noires'),
(594, 'Omble chevalier'),
(595, 'Orange'),
(596, 'Orange sanguine'),
(597, 'Orge'),
(598, 'Origan'),
(599, 'Origan'),
(600, 'Ormeau'),
(601, 'Oseille'),
(602, 'Oursins de mer'),
(603, 'Pain'),
(604, 'Palourde'),
(605, 'Pamplemousse'),
(606, 'Panais'),
(607, 'Papaye'),
(608, 'Paprika'),
(609, 'Parmesan'),
(610, 'Pastèque'),
(611, 'Patate douce'),
(612, 'Pâtisson'),
(613, 'Pavot'),
(614, 'Pêche'),
(615, 'Persil'),
(616, 'Petits pois'),
(617, 'Pétoncle'),
(618, 'Physalis (cerise de terre)'),
(619, 'Pignon'),
(620, 'Piment'),
(621, 'Piment d\'Espelette'),
(622, 'Pintade'),
(623, 'Pistache'),
(624, 'Pitaya'),
(625, 'Pleurotes'),
(626, 'Poire'),
(627, 'Poireau'),
(628, 'Pois cassé'),
(629, 'Pois chiche'),
(630, 'Pois gourmands'),
(631, 'Pois mange-tout'),
(632, 'Quetsche'),
(633, 'Quinoa'),
(634, 'Radis'),
(635, 'Raie'),
(636, 'Raifort'),
(637, 'Raisin'),
(638, 'Ras el hanout'),
(639, 'Reblochon'),
(640, 'Rhubarbe'),
(641, 'Ricotta'),
(642, 'Riz'),
(643, 'Riz sauvage'),
(644, 'Roquefort'),
(645, 'Roquette'),
(646, 'Roucou'),
(647, 'Rouget'),
(648, 'Rumsteak'),
(649, 'Rutabaga'),
(650, 'Safran'),
(651, 'Salade verte'),
(652, 'Salicorne'),
(653, 'Salsifis'),
(654, 'Sanglier'),
(655, 'Sardine'),
(656, 'Sarrasin'),
(657, 'Sarriette'),
(658, 'Sauge'),
(659, 'Saumon'),
(660, 'Scampi'),
(661, 'Scarole'),
(662, 'Seigle'),
(663, 'Seitan'),
(664, 'Semoule'),
(665, 'Sésame'),
(666, 'Shiitake'),
(667, 'Shimeji'),
(668, 'Simili-viande'),
(669, 'Sirop d\'Erable'),
(670, 'Soda'),
(671, 'Soja'),
(672, 'Sole'),
(673, 'Steak végétal'),
(674, 'Sucre roux, cassonnade'),
(675, 'Sudachi'),
(676, 'Tamarillo'),
(677, 'Tandoori masala'),
(678, 'Tangerine'),
(679, 'Tapioca'),
(680, 'Teff'),
(681, 'Tempeh'),
(682, 'Thé'),
(683, 'Thon'),
(684, 'Thym'),
(685, 'Tilapia'),
(686, 'Tofu'),
(687, 'Tomate cerise'),
(688, 'Tomate cœur de bœuf'),
(689, 'Tomates'),
(690, 'Topinambour'),
(691, 'Tournesol'),
(692, 'Truffe'),
(693, 'Truite'),
(694, 'Turbot'),
(695, 'Udon'),
(696, 'Vanille'),
(697, 'Veau'),
(698, 'Viande de gibier'),
(699, 'Vin'),
(700, 'Vinaigre'),
(701, 'Vinaigre de framboise'),
(702, 'Vinaigre de riz'),
(703, 'Vivaneau'),
(704, 'Wakamé'),
(705, 'Wasabi'),
(706, 'Yogourt'),
(707, 'Yuzu'),
(708, 'Crevette'),
(709, 'Pomme de terre'),
(710, 'Huile d\'olive');

-- --------------------------------------------------------

--
-- Structure de la table `planning_recette`
--

DROP TABLE IF EXISTS `planning_recette`;
CREATE TABLE IF NOT EXISTS `planning_recette` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_recette` int NOT NULL,
  `id_user` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `id` varchar(13) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`id`, `nom`, `description`, `id_utilisateur`) VALUES
('1', 'Galette des rois', 'Une bonne galette à la frangipane', -1),
('2', 'Soupe de poireaux', 'La bonne soupe miam', -1),
('3', 'Bouillabaisse', 'Un riche ragoût de poisson provençal, la bouillabaisse combine divers poissons et fruits de mer dans un bouillon parfumé au safran. Servie traditionnellement avec une rouille, une sauce à l\'ail et au piment, elle est un pilier de la cuisine méditerranéenne.', -1),
('4', 'Coq au Vin', 'Un classique de la cuisine française, le coq au vin est un plat mijoté où le poulet est cuit lentement dans du vin rouge avec des lardons, des champignons et des oignons, créant ainsi une sauce riche et profonde.', -1),
('5', 'Ratatouille', 'Ce plat végétarien originaire de Nice est un mélange coloré d\'aubergines, de courgettes, de poivrons et de tomates, mijoté avec de l\'huile d\'olive et des herbes. Il est souvent servi comme accompagnement ou plat principal.', -1),
('6', 'Quiche Lorraine', 'Une tarte salée originaire de Lorraine, composée d\'une pâte brisée garnie d\'un appareil à crème et d\'œufs, enrichie de lardons fumés. Elle peut être servie chaude ou froide, idéale pour un repas léger.', -1),
('7', 'Boeuf Bourguignon', 'Un ragoût de bœuf savoureux, mijoté pendant des heures dans du vin rouge de Bourgogne avec des carottes, des oignons et des champignons. Ce plat est célèbre pour sa profondeur de goût et sa sauce riche.', -1),
('8', 'Soupe à l\'Oignon', 'Un plat réconfortant, la soupe à l\'oignon est faite de oignons caramélisés lentement cuits dans un bouillon de bœuf, souvent gratinée au four avec des tranches de pain et recouverte de fromage fondu.', -1),
('10', 'Cassoulet', 'Un riche ragoût de haricots blancs, de saucisses et de viandes variées comme du porc ou du confit de canard. Originaire du sud-ouest de la France, c\'est un plat copieux et réconfortant.', -1),
('11', 'Salade Niçoise', 'Une salade composée typique de la Côte d\'Azur, elle mélange thon, œufs durs, légumes frais comme des tomates et des haricots verts, avec des olives noires et des anchois, le tout assaisonné d\'une vinaigrette légère.', -1),
('12', 'Crème Brûlée', 'Un dessert élégant et simple, composé d\'une riche crème custard à la vanille, refroidie et recouverte d\'une couche de sucre caramélisé croquant. La surface caramélisée est souvent brûlée au chalumeau juste avant de servir.', -1);

-- --------------------------------------------------------

--
-- Structure de la table `recette_aliment`
--

DROP TABLE IF EXISTS `recette_aliment`;
CREATE TABLE IF NOT EXISTS `recette_aliment` (
  `id_recette` varchar(13) NOT NULL,
  `id_aliment` int NOT NULL,
  `quantite` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_recette`,`id_aliment`),
  KEY `id_aliment` (`id_aliment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recette_aliment`
--

INSERT INTO `recette_aliment` (`id_recette`, `id_aliment`, `quantite`) VALUES
('3', 589, '1'),
('3', 568, '1'),
('3', 364, '1'),
('3', 650, '1'),
('3', 708, '1'),
('3', 709, '1'),
('4', 364, '1'),
('4', 426, '1'),
('4', 435, '1'),
('4', 589, '1'),
('4', 684, '1'),
('4', 699, '1'),
('5', 364, '1'),
('5', 387, '1'),
('6', 522, '1'),
('6', 585, '1'),
('7', 364, '1'),
('7', 404, '1'),
('7', 426, '1'),
('7', 435, '1'),
('7', 589, '1'),
('7', 684, '1'),
('7', 699, '1');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` enum('utilisateur','admin','nutritionniste') NOT NULL,
  `nom_utilisateur` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `role`, `nom_utilisateur`, `mdp`, `email`) VALUES
(1, 'utilisateur', 'Theo', '1f3ce40415a2081fa3eee75fc39fff8e56c22270d1a978a7249b592dcebd20b4', 'sasasasa@ee.Fr'),
(2, 'utilisateur', 'theo', '1f3ce40415a2081fa3eee75fc39fff8e56c22270d1a978a7249b592dcebd20b4', 'dezkf@ff.Fr');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

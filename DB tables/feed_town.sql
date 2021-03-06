-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 16 Νοε 2014 στις 19:58:57
-- Έκδοση διακομιστή: 5.5.37-cll
-- Έκδοση PHP: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Βάση δεδομένων: `news`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `feed_town`
--

CREATE TABLE IF NOT EXISTS `feed_town` (
  `town` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` float(10,6) DEFAULT NULL,
  `lng` float(10,6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `feed_town`
--

INSERT INTO `feed_town` (`town`, `lat`, `lng`) VALUES
('Άμφισσα', 38.527668, 22.378153),
('Άρτα', 39.158241, 20.987684),
('Αθήνα', 37.983917, 23.729361),
('Αλεξάνδρεια', 31.200092, 29.918739),
('Αλεξανδρούπολη', 40.845718, 25.873962),
('Αμύνταιο', 40.690517, 21.679743),
('Αμφίπολη', 40.823681, 23.847052),
('Αράχωβα', 38.480000, 22.584368),
('Αργοστόλι', 38.173168, 20.489973),
('Αριδαία', 40.973530, 22.061010),
('Αρναία', 40.486832, 23.596395),
('Ασπροβάλτα', 40.719952, 23.706905),
('Αυλώνα', 38.250965, 23.695498),
('Βέροια', 40.519363, 22.205215),
('Βόλος', 39.362190, 22.942160),
('Γιαννιτσά', 40.794357, 22.414448),
('Γλυφάδα', 37.865044, 23.755045),
('Γρεβενά', 40.083763, 21.427330),
('Διδυμότειχο', 41.347649, 26.495638),
('Δράμα', 41.149002, 24.147079),
('Δραπετσώνα', 37.949982, 23.623995),
('Έδεσσα', 40.801682, 22.043980),
('Ερμούπολη', 37.441811, 24.940424),
('Εύοσμος', 40.666138, 22.903774),
('Ζάκυνθος', 37.788158, 20.898827),
('Ηγουμενίτσα', 39.506149, 20.265533),
('Ηράκλειο', 35.338734, 25.144213),
('Θεσσαλονίκη', 40.640064, 22.944420),
('Θήβα', 38.322578, 23.320431),
('Θρακομακεδόνες', 38.135906, 23.753586),
('Ιεράπετρα', 35.011894, 25.740746),
('Ιωάννινα', 39.665028, 20.853746),
('Καβάλα', 40.937607, 24.412867),
('Καλαμάτα', 37.042236, 22.114126),
('Καλαμαριά', 40.582703, 22.953030),
('Καλαμπάκα', 39.706619, 21.628874),
('Καματερό', 38.059200, 23.712128),
('Καρδίτσα', 39.364025, 21.921406),
('Καρπενήσι', 38.914921, 21.793589),
('Καστοριά', 40.519268, 21.268717),
('Κατερίνη', 40.280560, 22.505840),
('Κέρκυρα', 39.624985, 19.922346),
('Κερατέα', 37.807178, 23.976341),
('Κηφισιά', 38.076786, 23.814697),
('Κιλκίς', 40.993706, 22.875366),
('Κόρινθος', 37.938637, 22.932238),
('Κοζάνη', 40.300583, 21.789812),
('Κομοτηνή', 41.122440, 25.406557),
('Κορυδαλλός', 37.981049, 23.649849),
('Κορωπί', 37.901142, 23.872650),
('Κως', 36.892586, 27.287792),
('Λάρισα', 39.639023, 22.419125),
('Λαμία', 38.895973, 22.434900),
('Λευκάδα', 38.833366, 20.706911),
('Λιβαδειά', 38.375599, 22.858217),
('Μεσολόγγι', 38.368675, 21.430414),
('Μυτιλήνη', 39.106739, 26.557276),
('Ναύπλιο', 37.567318, 22.801554),
('Ξάνθη', 41.130035, 24.886490),
('Πάτρα', 38.246639, 21.734573),
('Πολύγυρος', 40.381683, 23.442671),
('Πρέβεζα', 38.959267, 20.751715),
('Πύργος', 37.671848, 21.443226),
('Ρέθυμνο', 35.364361, 24.482155),
('Ρόδος', 36.434963, 28.217484),
('Σάμος', 37.754787, 26.977770),
('Σέρρες', 41.090923, 23.541321),
('Σπάρτη', 37.074463, 22.430264),
('Τρίκαλα', 39.555733, 21.767895),
('Τρίπολη', 32.813313, 13.104845),
('Φλώρινα', 40.784527, 21.413122),
('Χαλκίδα', 38.464523, 23.605068),
('Χανιά', 35.513828, 24.018038),
('Χίος', 38.370979, 26.136347),
('Ηλεία', 37.704510, 21.570679);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

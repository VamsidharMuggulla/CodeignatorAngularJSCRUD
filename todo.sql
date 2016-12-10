SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
--
-- Table structure for table `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `todo` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id`, `todo`, `description`, `date`, `status`) VALUES
(31, 'p', 'pp', '1970-01-01', 0),
(32, 'Get Money', 'Goto for ATM, sleep in Q, return hopeless', '2016-12-30', 0),
(33, 'Drive her', 'Drive Leena to William Duck Villa.', '2016-12-13', 0),
(34, 'Goto Work', 'Go to work, finish early and come back with bang.', '2016-12-29', 0),
(35, 'Get some Swagg!!', 'Drive to city central and buy some cool wearings.', '2017-07-07', 0),
(36, 'Groceries', 'Buy groceries of her choice.', '2017-07-18', 0);


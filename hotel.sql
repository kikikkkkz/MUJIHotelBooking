-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 01, 2018 at 01:17 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `roomNumber` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`roomNumber`, `status`, `fromDate`, `toDate`) VALUES
(1001, 'unavailable', '2018-03-09', '2018-03-10'),
(2003, 'unavailable', '2018-04-09', '2018-04-14');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `content` text NOT NULL,
  `memberNumber` int(11) NOT NULL,
  `roomType` varchar(10) NOT NULL,
  `timePosted` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`content`, `memberNumber`, `roomType`, `timePosted`) VALUES
('Nice stay in MUJI!', 1, 'A', '2018-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `memberNumber` int(11) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `hashed_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberNumber`, `lastName`, `firstName`, `email`, `phoneNumber`, `country`, `hashed_password`) VALUES
(1, 'Ma', 'Jack', 'jma@taobao.com', '7787787778', 'China', '$2y$10$lkeLxdtcxhm3QZSvixDkpeI/6qvy2Z8GVKWoSzLMXqv0M5k3J67J6'),
(2, 'Hortons', 'Tim', 'timhortons@timhortons.ca', '7789999999', 'Canada', '$2y$10$lkeLxdtcxhm3QZSvixDkpeI/6qvy2Z8GVKWoSzLMXqv0M5k3J67J6'),
(3, 'Jobs', 'Steve', 'sjobs@apple.com', '7787766666', 'USA', '$2y$10$lkeLxdtcxhm3QZSvixDkpeI/6qvy2Z8GVKWoSzLMXqv0M5k3J67J6'),
(4, 'Zhang', 'Kiki', 'kikizhangqi@outlook.com', '7787787777', 'China', '$2y$10$uIcM5KkG1iyY5.tSetfB.OAID0WwiT4eYrac5HE2SW72kYZyq27ra');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `bookingNumber` int(11) NOT NULL,
  `bookingDate` date NOT NULL,
  `checkInDate` date NOT NULL,
  `checkOutDate` date NOT NULL,
  `memberNumber` int(11) NOT NULL,
  `numberOfGuests` int(11) NOT NULL,
  `numberOfRoomBooked` int(11) NOT NULL,
  `priceEach` int(11) NOT NULL,
  `roomType` varchar(10) NOT NULL,
  `bookingComments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`bookingNumber`, `bookingDate`, `checkInDate`, `checkOutDate`, `memberNumber`, `numberOfGuests`, `numberOfRoomBooked`, `priceEach`, `roomType`, `bookingComments`) VALUES
(1, '2018-03-01', '2018-03-09', '2018-03-10', 1, 2, 1, 950, 'A', 'Sea view'),
(2, '2018-03-26', '2018-04-09', '2018-04-14', 2, 1, 1, 1300, 'C', '');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomNumber` int(11) NOT NULL,
  `roomType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomNumber`, `roomType`) VALUES
(1001, 'A'),
(1002, 'A'),
(2001, 'B'),
(2002, 'B'),
(2003, 'C'),
(2004, 'C'),
(3001, 'D'),
(3002, 'D'),
(3003, 'E'),
(3004, 'E');

-- --------------------------------------------------------

--
-- Table structure for table `roomtype`
--

CREATE TABLE `roomtype` (
  `roomType` varchar(10) NOT NULL,
  `roomTypeDescription` text NOT NULL,
  `bedType` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `numberOfOccupants` smallint(6) NOT NULL,
  `numberOfRooms` smallint(6) NOT NULL,
  `price` smallint(6) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roomtype`
--

INSERT INTO `roomtype` (`roomType`, `roomTypeDescription`, `bedType`, `area`, `numberOfOccupants`, `numberOfRooms`, `price`, `image`) VALUES
('A', 'toothbrush / toothpaste / shower cap / cotton balls / cotton swabs / shampoo / conditioner / body wash / hand soap / slippers / bottled water / refrigerator / safe / electric kettle / hair dryer / wall-mounted CD player / Wi-Fi', 'Double', '26-28', 2, 16, 950, '<div id=\\\"room-image\\\">\\r\\n  <img src=\\\"images/rooms_type_a_1.jpg\\\" width=\\\"900\\\" height=\\\"200\\\" alt=\\\"\\\" />\\r\\n</div>\\r\\n\\r\\n'),
('B', 'toothbrush / toothpaste / shower cap / cotton balls / cotton swabs / shampoo / conditioner / body wash / hand soap / slippers / bottled water / refrigerator / safe / electric kettle / hair dryer / wall-mounted CD player / Wi-Fi', 'Double/Twin', '32-35', 2, 26, 1085, '<div id=\\\\\\\"room-image\\\\\\\">\\\\r\\\\n  <img src=\\\\\\\"images/rooms_type_b_1.jpg\\\\\\\" width=\\\\\\\"900\\\\\\\" height=\\\\\\\"200\\\\\\\" alt=\\\\\\\"\\\\\\\" />\\\\r\\\\n</div>\\\\r\\\\n\\\\r\\\\n'),
('C', 'toothbrush / toothpaste / shower cap / cotton balls / cotton swabs / shampoo / conditioner / body wash / hand soap / slippers / bottled water / refrigerator / safe / electric kettle / hair dryer / wall-mounted CD player / Wi-Fi', 'Double/Twin', '38-39', 2, 21, 1300, '<div id=\\\\\\\"room-image\\\\\\\">\\\\r\\\\n  <img src=\\\\\\\"images/rooms_type_c_1.jpg\\\\\\\" width=\\\\\\\"900\\\\\\\" height=\\\\\\\"200\\\\\\\" alt=\\\\\\\"\\\\\\\" />\\\\r\\\\n</div>\\\\r\\\\n\\\\r\\\\n'),
('D', 'toothbrush / toothpaste / shower cap / cotton balls / cotton swabs / shampoo / conditioner / body wash / hand soap / slippers / bottled water / refrigerator / safe / electric kettle / hair dryer / wall-mounted CD player / Wi-Fi / Bathtub', 'Double/Twin', '42-46', 2, 12, 1480, '<div id=\\\\\\\"room-image\\\\\\\">\\\\r\\\\n  <img src=\\\\\\\"images/rooms_type_d_1.jpg\\\\\\\" width=\\\\\\\"900\\\\\\\" height=\\\\\\\"200\\\\\\\" alt=\\\\\\\"\\\\\\\" />\\\\r\\\\n</div>\\\\r\\\\n\\\\r\\\\n'),
('E', 'toothbrush / toothpaste / shower cap / cotton balls / cotton swabs / shampoo / conditioner / body wash / hand soap / slippers / bottled water / refrigerator / safe / electric kettle / hair dryer / wall-mounted CD player / Wi-Fi / Bathtub', 'Twin', '51-61', 2, 4, 2500, '<div id=\\\\\\\"room-image\\\\\\\">\\\\r\\\\n  <img src=\\\\\\\"images/rooms_type_e_1.jpg\\\\\\\" width=\\\\\\\"900\\\\\\\" height=\\\\\\\"200\\\\\\\" alt=\\\\\\\"\\\\\\\" />\\\\r\\\\n</div>\\\\r\\\\n\\\\r\\\\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`roomNumber`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`memberNumber`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`bookingNumber`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomNumber`);

--
-- Indexes for table `roomtype`
--
ALTER TABLE `roomtype`
  ADD PRIMARY KEY (`roomType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `memberNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `bookingNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

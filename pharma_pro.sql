-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2024 at 03:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharma_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cid` int(11) NOT NULL,
  `c_name` varchar(75) NOT NULL,
  `c_contact` varchar(10) NOT NULL,
  `c_address` varchar(75) NOT NULL,
  `doctor_name` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `c_name`, `c_contact`, `c_address`, `doctor_name`) VALUES
(1, 'Arnav Rajbhandari', '9803000497', 'Sanepa-2, Lalitpur', 'Ranjeeta Gorkhali'),
(2, 'Arnav Rajbhandari', '9803000497', 'Sanepa-2, Lalitpur', 'Ranjeeta Gorkhali'),
(3, 'Shleshma Shrestha', '9863604066', 'Baneshwor, Kathmandu', 'Sabeena Bhattarai'),
(4, 'Simran Shrestha', '9849831719', 'Bhaktapur', 'Rajesh Jha'),
(5, 'Simran Shrestha', '9849831719', 'Bhaktapur', 'Rajesh Jha'),
(6, 'Rena Rajbhandari', '9841699180', 'Sanepa-2, Lalitpur', 'Dr. Hatti'),
(7, 'Kumar Lohala', '9874654321', 'kjhasdkljhas', 'akdjfhaskjdh'),
(8, 'Jane Frost', '987654321', 'kjhasdsaoiuqew', 'ljkhasdasd'),
(9, 'John Doe', '555-1234', '123 Elm St, Springfield', 'Dr. Smith'),
(10, 'Jane Smith', '555-5678', '456 Oak St, Springfield', 'Dr. Jones'),
(11, 'Michael Johnson', '555-8765', '789 Pine St, Springfield', 'Dr. Brown'),
(12, 'Emily Davis', '555-4321', '101 Maple St, Springfield', 'Dr. Taylor'),
(13, 'David Wilson', '555-2345', '202 Birch St, Springfield', 'Dr. Anderson'),
(14, 'Mary Brown', '555-3456', '303 Cedar St, Springfield', 'Dr. Thomas'),
(15, 'James Taylor', '555-4567', '404 Spruce St, Springfield', 'Dr. Jackson'),
(16, 'Patricia Anderson', '555-5678', '505 Walnut St, Springfield', 'Dr. White'),
(17, 'Robert Thomas', '555-6789', '606 Chestnut St, Springfield', 'Dr. Harris'),
(18, 'Linda Jackson', '555-7890', '707 Willow St, Springfield', 'Dr. Martin'),
(19, 'Michael White', '555-8901', '808 Ash St, Springfield', 'Dr. Thompson'),
(20, 'Barbara Harris', '555-9012', '909 Redwood St, Springfield', 'Dr. Garcia'),
(21, 'William Martin', '555-0123', '1010 Fir St, Springfield', 'Dr. Martinez'),
(22, 'Elizabeth Thompson', '555-1234', '1111 Sycamore St, Springfield', 'Dr. Robinson'),
(23, 'Joseph Garcia', '555-2345', '1212 Poplar St, Springfield', 'Dr. Clark'),
(24, 'Susan Martinez', '555-3456', '1313 Cypress St, Springfield', 'Dr. Rodriguez'),
(25, 'Thomas Robinson', '555-4567', '1414 Hickory St, Springfield', 'Dr. Lewis'),
(26, 'Margaret Clark', '555-5678', '1515 Cherry St, Springfield', 'Dr. Lee'),
(27, 'Charles Rodriguez', '555-6789', '1616 Magnolia St, Springfield', 'Dr. Walker'),
(28, 'Jessica Lewis', '555-7890', '1717 Redwood St, Springfield', 'Dr. Hall'),
(29, 'Christopher Lee', '555-8901', '1818 Birch St, Springfield', 'Dr. Allen'),
(30, 'Karen Walker', '555-9012', '1919 Cedar St, Springfield', 'Dr. Young'),
(31, 'Daniel Hall', '555-0123', '2020 Elm St, Springfield', 'Dr. Hernandez'),
(32, 'Nancy Allen', '555-1234', '2121 Oak St, Springfield', 'Dr. King'),
(33, 'Matthew Young', '555-2345', '2222 Pine St, Springfield', 'Dr. Wright'),
(34, 'Betty Hernandez', '555-3456', '2323 Maple St, Springfield', 'Dr. Lopez'),
(35, 'Mark King', '555-4567', '2424 Spruce St, Springfield', 'Dr. Hill'),
(36, 'Linda Wright', '555-5678', '2525 Walnut St, Springfield', 'Dr. Scott'),
(37, 'George Lopez', '555-6789', '2626 Chestnut St, Springfield', 'Dr. Green'),
(38, 'Dorothy Hill', '555-7890', '2727 Willow St, Springfield', 'Dr. Adams'),
(39, 'Paul Scott', '555-8901', '2828 Ash St, Springfield', 'Dr. Baker'),
(40, 'Sandra Green', '555-9012', '2929 Fir St, Springfield', 'Dr. Gonzalez'),
(41, 'Steven Adams', '555-0123', '3030 Sycamore St, Springfield', 'Dr. Nelson'),
(42, 'Donna Baker', '555-1234', '3131 Poplar St, Springfield', 'Dr. Carter'),
(43, 'Kenneth Gonzalez', '555-2345', '3232 Cypress St, Springfield', 'Dr. Mitchell'),
(44, 'Carol Nelson', '555-3456', '3333 Hickory St, Springfield', 'Dr. Perez'),
(45, 'Brian Carter', '555-4567', '3434 Cherry St, Springfield', 'Dr. Roberts'),
(46, 'Jennifer Mitchell', '555-5678', '3535 Redwood St, Springfield', 'Dr. Phillips'),
(47, 'Kevin Perez', '555-6789', '3636 Elm St, Springfield', 'Dr. Campbell'),
(48, 'Sharon Roberts', '555-7890', '3737 Oak St, Springfield', 'Dr. Parker'),
(49, 'Larry Phillips', '555-8901', '3838 Pine St, Springfield', 'Dr. Evans'),
(50, 'Laura Campbell', '555-9012', '3939 Maple St, Springfield', 'Dr. Edwards'),
(51, 'Jeffrey Parker', '555-0123', '4040 Spruce St, Springfield', 'Dr. Collins'),
(52, 'Cynthia Evans', '555-1234', '4141 Walnut St, Springfield', 'Dr. Stewart'),
(53, 'Ryan Edwards', '555-2345', '4242 Chestnut St, Springfield', 'Dr. Sanchez'),
(54, 'Kimberly Collins', '555-3456', '4343 Willow St, Springfield', 'Dr. Morris'),
(55, 'Jason Stewart', '555-4567', '4444 Ash St, Springfield', 'Dr. Rogers'),
(56, 'Amy Sanchez', '555-5678', '4545 Fir St, Springfield', 'Dr. Reed');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `voucher_no` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `net_total` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_amount` double NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `med_id` int(11) NOT NULL,
  `med_name` varchar(75) NOT NULL,
  `generic_name` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_stock`
--

CREATE TABLE `medicine_stock` (
  `batch_id` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `quantity` double NOT NULL,
  `mrp` double NOT NULL,
  `stock_id` int(11) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_voucher_no` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_amount` double NOT NULL,
  `payment_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(75) NOT NULL,
  `supplier_contact` varchar(10) NOT NULL,
  `supplier_address` int(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(75) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`voucher_no`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`med_id`);

--
-- Indexes for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_voucher_no`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_voucher_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `customer` (`cid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

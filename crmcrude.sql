-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2025 at 09:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crmcrude`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `user_id`, `module`, `action`, `timestamp`, `ip_address`) VALUES
(1, 1, 'leads', 'Created new lead: Alpha Petroleum', '2025-07-15 14:09:25', '192.168.0.10'),
(2, 2, 'contracts', 'Uploaded contract for Refinoil Pvt Ltd', '2025-07-15 14:09:25', '192.168.0.12'),
(3, 3, 'logistics', 'Updated tracking for Contract #1', '2025-07-15 14:09:25', '192.168.0.15'),
(4, NULL, 'clients', 'Added new client: Hanuman cotton mills private limited', '2025-08-05 23:55:42', '::1'),
(5, 2, 'leads', 'Created new lead: Hanuman cotton mills private limited', '2025-08-05 23:57:33', '::1'),
(10, 4, 'leads', 'Created new lead: Hanuman cotton mills private limited', '2025-09-15 14:07:45', '::1'),
(11, 2, 'profile', 'Updated profile info', '2025-10-01 18:04:03', '::1'),
(12, 4, 'leads', 'Created new lead: Hanuman cotton mills private limited', '2025-10-08 15:29:35', '::1'),
(13, 4, 'leads', 'Created new lead: Hanuman cotton mills private limited', '2025-10-08 16:39:26', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `industry_type` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `added_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `company_name`, `industry_type`, `contact_person`, `phone`, `email`, `address`, `country`, `status`, `added_by`, `created_at`) VALUES
(1, 'Global Crude Traders Ltd', 'Crude', 'Nishit Shah', '9123456780', 'ahmed@globalcrude.com', 'Doha, Qatar', 'Qatar', 1, 1, '2025-07-15 14:06:15'),
(2, 'Refinoil Pvt Ltd', 'Refinery', 'Krishna Iyer', '9187654321', 'priya@refinoil.com', 'Mumbai, India', 'India', 1, 2, '2025-07-15 14:06:15'),
(3, 'LPG Gas Corp', 'Gas', 'Om Mathur', '8112345678', 'lee@gascorp.cn', 'Shanghai, China', 'China', 1, 1, '2025-07-15 14:06:15'),
(4, 'Hanuman cotton mills private limited', 'dfb', 'YugPatel', '08112345678', 'yugpatel0274@gmail', 'b/h. Jagdamba texteles,plot no.222/2\r\n,222/3,Opp. CNI Ranipur Church,Narol', 'India', 1, 1, '2025-08-05 23:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `contract_id` int(11) NOT NULL,
  `opportunity_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `volume` decimal(12,2) DEFAULT NULL,
  `price_per_unit` decimal(10,2) DEFAULT NULL,
  `contract_date` date DEFAULT NULL,
  `delivery_terms` text DEFAULT NULL,
  `payment_terms` text DEFAULT NULL,
  `contract_doc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`contract_id`, `opportunity_id`, `client_id`, `product_id`, `volume`, `price_per_unit`, `contract_date`, `delivery_terms`, `payment_terms`, `contract_doc`) VALUES
(1, 1, 1, 1, 10000.00, 72.50, '2025-07-01', 'FOB Port of Houston', 'Net 30 days', 'contracts/contract_001.pdf'),
(2, 2, 2, 2, 20000.00, 1.25, '2025-07-10', 'Delivered to Mumbai Port', 'Advance Payment', 'contracts/contract_002.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `description`, `file_path`, `uploaded_at`) VALUES
(1, 'des', 'documents/1754418693_Harsh Resume for placement.pdf', '2025-08-05 18:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `location`, `quantity`, `last_updated`) VALUES
(1, 1, 'Houston Refinery Storag', 25000.00, '2025-07-26 14:42:02'),
(9, 1, 'kashmir', 23.00, '2025-09-12 19:56:09'),
(10, 1, 'Indus', 123.00, '2025-10-08 15:47:11');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `tax` decimal(6,2) DEFAULT NULL,
  `total_amount` decimal(12,2) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('Unpaid','Paid','Overdue') DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `contract_id`, `client_id`, `amount`, `tax`, `total_amount`, `invoice_date`, `due_date`, `status`) VALUES
(1, 1, 2, 4000.00, 9999.99, 25000.00, '2025-09-01', '2025-09-11', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `lead_id` int(11) NOT NULL,
  `client_name` varchar(150) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `source` enum('Website','Referral','Trade Fair','Call','Email') DEFAULT 'Website',
  `status` enum('New','Contacted','Qualified','Rejected') DEFAULT 'New',
  `assigned_to` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`lead_id`, `client_name`, `contact_person`, `email`, `phone`, `source`, `status`, `assigned_to`, `remarks`, `created_at`) VALUES
(1, 'Alpha Petroleum', 'Carlos Ruiz', 'carlos@alpha.com', '9845098450', 'Referral', 'New', 2, 'Interested in monthly diesel supply', '2025-07-15 14:07:51'),
(2, 'Zenith Oil Ltd', 'Tirth Shah', 'tirt@zenithoil.com', '9876543210', 'Website', 'Contacted', 2, 'Looking for Brent Crude long term contract', '2025-07-15 14:07:51'),
(3, 'Hanuman cotton mills private limited', 'Om Mathur', 'lee@gascorp.cn', '08112345678', 'Referral', 'Contacted', 3, 'sdvs', '2025-08-05 20:27:33'),
(4, 'Hanuman cotton mills private limited', 'ishan patel', 'ishan@gmail.com', '252255555', 'Website', 'New', 1, 'no remarks', '2025-08-06 14:40:15'),
(5, 'Hanuman cotton mills private limited', 'YUg effes', 'yug23@gmail.com', '08980606446', 'Trade Fair', 'Qualified', 4, 'cggnn', '2025-09-15 10:37:45'),
(6, 'Zenith Oil Ltd', 'Ishan Aswasthi', 'TYHGT@', '2345678', 'Website', 'New', NULL, NULL, '2025-09-30 18:35:16'),
(13, 'fgghbnjk', 'vbni', 'ghnj,', '234567', 'Website', 'New', NULL, NULL, '2025-10-01 18:33:50'),
(14, 'xfh', 'xh', 'wdg', '123585', 'Website', 'New', NULL, NULL, '2025-10-01 18:44:02'),
(15, 'ishan', 'ishan shqh', 'ishan@gmail.com', '222555', 'Website', 'New', NULL, NULL, '2025-10-01 18:55:18'),
(16, 'ishan', 'ishan shqh', 'ishan@gmail.com', '222555', 'Website', 'New', NULL, NULL, '2025-10-01 18:55:56'),
(17, 'Aneri', 'Shah', 'oijfoifdjgoi@gmail.com', '1234678905', 'Website', 'New', NULL, NULL, '2025-10-07 17:35:04'),
(18, 'Hanuman cotton mills private limited', 'Yug Patel', 'yug23@gmail.com', '08980606446', 'Website', 'New', 2, ',n,,', '2025-10-08 11:59:35'),
(19, 'Hanuman cotton mills private limited', 'YUg effes', 'yug23@gmail.com', '08980606446', 'Website', 'New', 3, 'gfjff', '2025-10-08 13:09:26');

-- --------------------------------------------------------

--
-- Table structure for table `logistics`
--

CREATE TABLE `logistics` (
  `logistics_id` int(11) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `shipment_date` date DEFAULT NULL,
  `carrier_name` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `status` enum('In Transit','Delivered','Delayed','Cancelled') DEFAULT 'In Transit',
  `delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logistics`
--

INSERT INTO `logistics` (`logistics_id`, `contract_id`, `shipment_date`, `carrier_name`, `tracking_number`, `status`, `delivery_date`) VALUES
(1, 1, '2025-07-05', 'Maersk Logistics', 'MX20250705001', 'In Transit', NULL),
(2, 2, '2025-07-12', 'Blue Ocean Cargo', 'BOC20250712002', 'Delivered', '2025-07-20');

-- --------------------------------------------------------

--
-- Table structure for table `opportunities`
--
-- Error reading structure for table crmcrude.opportunities: #1932 - Table 'crmcrude.opportunities' doesn't exist in engine
-- Error reading data for table crmcrude.opportunities: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `crmcrude`.`opportunities`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` enum('Crude','Refined','Gas','Other') NOT NULL,
  `unit_of_measure` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `unit_of_measure`, `description`, `status`, `created_at`) VALUES
(1, 'Brent Crude Oil', 'Crude', 'Barrel', 'Light sweet crude oil from North Sea', 1, '2025-07-15 14:06:33'),
(2, 'High-Speed Diesel', 'Refined', 'Liter', 'Refined diesel used in transportation', 1, '2025-07-15 14:06:33'),
(3, 'LPG (Liquefied Petroleum Gas)', 'Gas', 'Metric Ton', 'Used for domestic and commercial heating', 1, '2025-07-15 14:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Sales','Logistics','Viewer') NOT NULL DEFAULT 'Viewer',
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'John Smith', 'john@crudecrm.com', 'hashed_password1', 'Admin', 1, '2025-07-15 14:04:38'),
(2, 'Yug Patel', 'sara@crudecrm.com', 'yug123', 'Sales', 1, '2025-07-15 14:04:38'),
(3, 'Raj Patel', 'raj@crudecrm.com', 'hashed_password3', 'Logistics', 1, '2025-07-15 14:04:38'),
(4, 'Yug', 'yug23@gmail.com', 'yug123', 'Sales', 1, '2025-07-26 11:43:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`contract_id`),
  ADD KEY `opportunity_id` (`opportunity_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `contract_id` (`contract_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`lead_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `logistics`
--
ALTER TABLE `logistics`
  ADD PRIMARY KEY (`logistics_id`),
  ADD KEY `contract_id` (`contract_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `contract_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `lead_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `logistics`
--
ALTER TABLE `logistics`
  MODIFY `logistics_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`opportunity_id`) REFERENCES `opportunities` (`opportunity_id`),
  ADD CONSTRAINT `contracts_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `contracts_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`contract_id`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `logistics`
--
ALTER TABLE `logistics`
  ADD CONSTRAINT `logistics_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`contract_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

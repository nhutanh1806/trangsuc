-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2025 at 08:40 PM
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
-- Database: `tiffany_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '123', 'admin'),
(2, 'thu', '202cb962ac59075b964b07152d234b70', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `image`) VALUES
(6, 'vong bac', 'dep vai', '2025-11-03 14:40:20', '../image/bac.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lichhen`
--

CREATE TABLE `lichhen` (
  `id` int(11) NOT NULL,
  `hoten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sdt` varchar(20) NOT NULL,
  `ngay` date NOT NULL,
  `cua_hang` varchar(50) NOT NULL,
  `ghichu` text NOT NULL,
  `ngay_dat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lichhen`
--

INSERT INTO `lichhen` (`id`, `hoten`, `email`, `sdt`, `ngay`, `cua_hang`, `ghichu`, `ngay_dat`) VALUES
(1, 'thu', 'fqkjcnjs@gmail.com', '784917429127', '0000-00-00', 'Hà Nội', '', '2025-11-03 09:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `orthers`
--

CREATE TABLE `orthers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orthers`
--

INSERT INTO `orthers` (`id`, `user_id`, `order_date`, `total`, `status`, `address`, `phone`, `note`) VALUES
(3, 0, '2025-11-04 00:08:21', 99999999.99, 'completed', '325/34/27/7 Bạch Đằng Phường 15 Quận Bình Thạnh Thành phố Hồ Chí Minh', '0906580461', 'Thanh toán qua cod - Email: thuminh2004.yahoo@gmail.com - Họ tên: HỒ MINH THƯ'),
(4, 0, '2025-11-04 01:40:10', 99999999.99, 'completed', '325/34/27/7 Bạch Đằng Phường 15 Quận Bình Thạnh Thành phố Hồ Chí Minh', '0702642576', 'Thanh toán qua cod - Email: thuminh2004.yahoo@gmail.com - Họ tên: HỒ MINH THƯ'),
(5, 0, '2025-11-04 01:41:59', 99999999.99, 'pending', '325/34/27/7 Bạch Đằng Phường 15 Quận Bình Thạnh Thành phố Hồ Chí Minh', '0906580461', 'Thanh toán qua cod - Email: thuminh2004.yahoo@gmail.com - Họ tên: HỒ MINH THƯ');

-- --------------------------------------------------------

--
-- Table structure for table `orther_items`
--

CREATE TABLE `orther_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orther_items`
--

INSERT INTO `orther_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(2, 3, 21, 2, 99999999.99, 0.00),
(3, 4, 23, 1, 99999999.99, 0.00),
(4, 5, 28, 2, 99999999.99, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Tên sản phẩm',
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL COMMENT 'mô tả sản phẩm',
  `price` bigint(20) NOT NULL COMMENT 'giá tiền',
  `image` varchar(255) NOT NULL COMMENT 'đường dẫn ảnh'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `image`) VALUES
(1, 'Classic Diamond Pendant', 'classic-diamond-pendant', 'Mặt dây chuyền kim cương thanh lịch, chế tác tinh xảo.', 190000000, 'image/dc1.jpg'),
(3, 'Signature Bracelet', 'signature-bracelet', 'Vòng tay kim loại cao cấp, mạ sáng bóng.', 150000000, 'image/vt1.jpg'),
(5, 'Elegance Ring', 'elegance-ring', 'Nhẫn đính đá quý phong cách cổ điển.', 90000000, 'image/n1.jpg'),
(6, 'Elsa Peretti', 'Elsa - Peretti', 'Chiếc nhẫn Tiffany & Co. là biểu tượng của tình yêu và sự gắn bó vượt thời gian.', 68000000, 'image/n2.jpg'),
(7, 'Paloma Picasso', 'Paloma - Picasso', 'Chiếc nhẫn Tiffany & Co. kết hợp tinh xảo giữa phong cách và đẳng cấp', 65000000, 'image/n3.jpg'),
(8, 'Return to Tiffany', 'Return to- Tiffany', 'Dây chuyền Tiffany & Co. – Tỏa sáng tinh khôi, tôn lên nét thanh lịch và quyến rũ tự nhiên.', 120000000, 'image/dc2.jpg'),
(9, 'Tiffany Forever', 'Tiffany - Forever', 'Dây chuyền Tiffany & Co. – Đẳng cấp tinh xảo, khẳng định phong cách và vị thế người đeo', 189000000, 'image/dc4.jpg'),
(10, 'Sixteen Stone by Tiffany', 'Sixteen Stone by Tiffany', 'Vòng tay Tiffany & Co. – Thiết kế tinh tế, tôn vinh phong cách thanh lịch và hiện đại.', 65000000, 'image/vt2.jpg'),
(12, 'Tiffany Knot', 'Tiffany -Knot', 'Vòng tay Tiffany & Co. là sự kết hợp giữa phong cách tối giản và đẳng cấp hiện đại.', 61000000, 'image/vt4.jpg'),
(14, 'Watch in Sterling Silver and Steel with Diamonds', 'Watch in Sterling Silver and Steel with Diamonds', 'Đồng hồ Tiffany & Co tinh tế, sang trọng và mang vẻ đẹp vượt thời gian.\r\n', 1000000000, 'image/w1.jpg'),
(15, 'Facet Watch in White Gold with Diamonds', 'Facet Watch in White Gold with Diamonds', 'Tiffany & Co. tôn vinh nét đẹp hiện đại, quý phái và đầy cảm hứng.', 210000000, 'image/w2.jpg\r\n'),
(17, 'Watch in Rose Gold with a Pavé Diamond Dial', 'Watch in Rose Gold with a Pavé Diamond Dial', 'Tiffany & Co. kết hợp sự tinh tế cổ điển với phong cách sang trọng đương đại.', 2330000000, 'image/w3.jpg\r\n'),
(18, 'Watch in Rose Gold with Diamonds and White Mother-of-pe', 'Watch in Rose Gold with Diamonds and White Mother-of-pe', 'Tiffany & Co. không chỉ là trang sức, mà còn là biểu tượng của sự sang trọng và phong cách cá nhân đẳng cấp.', 1200000000, 'image/w4.jpg'),
(19, 'Watch in White Gold with Diamonds', 'Watch in White Gold with Diamonds', 'Tiffany & Co. luôn dẫn đầu xu hướng với thiết kế sáng tạo, tinh tế và sang trọng.', 1200000000, 'image/w5.jpg'),
(20, 'Tiffany True®', 'Tiffany True®', 'Trang sức Tiffany & Co. tinh tế, thiết kế sang trọng, làm nổi bật vẻ đẹp quyến rũ và đẳng cấp của bạn.', 4400000000, 'image/w6.jpg'),
(21, 'Pavé Tiffany® Setting', 'Pavé Tiffany® Setting', 'Chất liệu cao cấp, bền bỉ cùng tay nghề chế tác thủ công tỉ mỉ, tạo nên món phụ kiện hoàn hảo cho mọi dịp.', 5500000000, 'image/w7.jpg\r\n'),
(22, 'Heart-shaped Diamond Engagement', 'Heart-shaped Diamond Engagement', 'biểu tượng của sự thanh lịch và phong cách vượt thời gian, giúp bạn tỏa sáng mọi ánh nhìn.', 33300000000, 'image/w8.jpg'),
(23, 'Pear-shaped Halo Engagement', 'Pear-shaped Halo Engagement', 'trang sức giúp tôn lên cá tính riêng, đồng thời làm nổi bật vẻ đẹp tự nhiên và sang trọng.', 1100000000, 'image/w9.jpg'),
(24, 'Jean Schlumberger by Tiffany', 'Jean Schlumberger by Tiffany', 'Trang sức Tiffany & Co. mang đến sự kết hợp hoàn hảo giữa thiết kế tinh xảo và chất liệu cao cấp.', 3330000000, 'image/w10.jpg'),
(25, 'Jean Schlumberger', 'Jean Schlumberger', 'Trang sức Tiffany & Co. mang đến sự kết hợp hoàn hảo giữa thiết kế tinh xảo và chất liệu cao cấp.', 11000000, 'image/dc5.jpg'),
(26, 'Princess-cut Diamond Engagement ', 'Princess-cut Diamond Engagement ', 'Với Tiffany & Co., bạn không chỉ sở hữu trang sức, mà còn trải nghiệm phong cách và sự tinh tế vượt thời gian.', 333000000, 'image/dc6.jpg\r\n'),
(27, 'Tiffany Lock', 'Tiffany Lock', 'Trang sức Tiffany & Co. được chế tác tỉ mỉ, mang đến sự hoàn hảo trong từng chi tiết nhỏ.', 110000000, 'image/dc7.jpg'),
(28, 'Tiffany Titan by Pharrell Williams', 'Tiffany Titan by Pharrell Williams', 'Thiết kế thanh lịch, hiện đại nhưng vẫn giữ nét cổ điển, phù hợp với nhiều phong cách.', 333000000, 'image/dc8.jpg'),
(29, 'Tiffany 1837®', 'Tiffany 1837®', 'Chất liệu cao cấp đảm bảo độ bền và sáng bóng lâu dài, giúp bạn tự tin tỏa sáng mỗi ngày.', 440000000, 'image/dc9.jpg'),
(30, 'Elsa Peretti®', 'Elsa Peretti®', 'Đây là lựa chọn lý tưởng để làm quà tặng sang trọng, ý nghĩa cho người thân hoặc đối tác.', 44200000, 'image/dc10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL COMMENT 'lưu mật khẩu mã mã hóa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(9, 'admin', NULL, '$2y$10$DKMjYoIJwh3yy5M.Fg4yF.faRgHMNyfOaKWe/7M1cRrFRURUyRDtW', '2025-10-31 11:14:38', 'admin'),
(10, 'thu', NULL, '$2y$10$Hl1yornmmoYkxb1o/CPIvO0Ia6io4prUSiHhRPkncs1Ev8eAApcnW', '2025-11-03 13:54:31', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lichhen`
--
ALTER TABLE `lichhen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orthers`
--
ALTER TABLE `orthers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orther_items`
--
ALTER TABLE `orther_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lichhen`
--
ALTER TABLE `lichhen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orthers`
--
ALTER TABLE `orthers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orther_items`
--
ALTER TABLE `orther_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orther_items`
--
ALTER TABLE `orther_items`
  ADD CONSTRAINT `orther_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orthers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orther_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

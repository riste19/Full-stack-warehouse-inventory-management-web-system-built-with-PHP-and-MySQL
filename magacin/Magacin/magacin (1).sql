-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 11:09 PM
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
-- Database: `magacin`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'filip', '$2y$10$TzJp4Dv057.jxzRkW/5uk.IkeUOTjYx2HxpTAeMzAkK3Q/7hVV9nS', '2025-01-27 23:44:37'),
(2, 'riste', '$2y$10$yeBRUC1FpOQRY70f4xL97OdhjuB3ndcdm2mc.uZ7drCX5a1FrcVo2', '2025-01-28 00:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `lokacija`
--

CREATE TABLE `lokacija` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `shelf` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `lokacija`
--

INSERT INTO `lokacija` (`id`, `name`, `shelf`) VALUES
(2, 'Секција A', 'рафт A'),
(3, 'Секција A', 'рафт B'),
(4, 'Секција A', 'рафт C'),
(5, 'Секција A', 'рафт D'),
(6, 'Секција B ', 'рафт А'),
(7, 'Секција B', 'рафт B'),
(8, 'Секција B', 'рафт C'),
(9, 'Секција B', 'рафт D');

-- --------------------------------------------------------

--
-- Table structure for table `naracki`
--

CREATE TABLE `naracki` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `naracki`
--

INSERT INTO `naracki` (`id`, `product_id`, `quantity`, `order_date`) VALUES
(25, 26, 10, '2025-01-29 21:06:47'),
(26, 35, 14, '2025-01-29 21:09:25'),
(27, 39, 10, '2025-01-29 21:29:59'),
(28, 14, 1, '2025-01-29 22:02:19');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `lokacija_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `quantity`, `lokacija_id`, `image`) VALUES
(14, 'Монитор Acer ', 'Екран: 24.5\", 360 Hz\r\nРезолуција: 1920 x 1080 (Full HD)\r\nОсветленост: 400 нити', 573, 2, 'AcerMonitor.png'),
(15, 'Asus Монитор', 'Екран: 27\", 144 Hz\r\nРезолуција: 3840 x 2160 (4K)\r\nОсветленост: 600 нити', 122, 2, 'AsusMonitor.png'),
(16, 'HP Монитор', 'Екран: 32\", 240 Hz\r\nРезолуција: 2560 x 1440 (QHD)\r\nОсветленост: 600 нити', 43, 2, 'HPMonitor.png'),
(17, 'Lenovo Монитор', 'Екран: 32\", 60 Hz\r\nРезолуција: 3840 x 2160 (4K)\r\nОсветленост: 350 нити', 78, 2, 'LenovoMonitor.png'),
(18, 'LG Монитор', 'Екран: 27\", 60 Hz\r\nРезолуција: 3840 x 2160 (4K)\r\nОсветленост: 350 нити', 31, 2, 'LGMonitor.png'),
(25, 'SteelSeries Mouse', 'DPI пресети: 200/400/800/1600/3200/6400 DPI\r\nТип на врска: Жичен', 27, 3, 'SteelSeriesMouse.png'),
(26, 'Logitech Mouse', 'DPI пресети: 100/200/400/800/1600/1800 DPI\r\nТип на врска: Wireless/Bluetooth/Wired', 64, 3, 'LogitechMouse.png'),
(27, 'Razer Mouse', 'DPI пресети: 100/200/400/800/1600/3200/12000 DPI\r\nТип на врска: Жичен', 112, 3, 'RazerMouse.png'),
(28, 'DELL Mouse', 'DPI пресети: 400/800/1600 DPI\r\nТип на врска: Wireless/Bluetooth', 431, 3, 'DellMouse.png'),
(29, 'Philips Слушалки', 'Форма на слушалки: Over ear, circumaural\r\nВременски период на батерија: До 30 часа\r\nВреме на полнење: 3 часа\r\nДолжина на кабел: 1.2m\r\n', 22, 4, 'PhillipsHeadphones.png'),
(30, 'Razer Слушалки', 'Форма на слушалки: Over ear, circumaural\r\nВременски период на батерија: До 24 часа\r\nВреме на полнење: 2.5 часа\r\nДолжина на кабел: 1.5m', 56, 4, 'RazerHeadphones.png'),
(31, 'SteelSeries Слушалки', 'Форма на слушалки: Over ear, circumaural\r\nВременски период на батерија: До 36 часа\r\nВреме на полнење: 2 часа\r\nДолжина на кабел: 1.2m', 5, 4, 'SteelSeriesHeadphones.png'),
(32, 'HyperX Слушалки', 'Форма на слушалки: Over ear, circumaural\r\nВременски период на батерија: До 17 часа\r\nВреме на полнење: 1.5 часа\r\nДолжина на кабел: 1.4m', 16, 4, 'HyperXHeadphones.png'),
(33, 'JBL Слушалки', 'Форма на слушалки: Over ear, circumaural\r\nВременски период на батерија: 53 часа (за верзија со жичен кабел)\r\nВреме на полнење: 2.5 часа\r\n', 104, 4, 'JBLHeadphones.png'),
(34, 'Tellur Слушалки', 'Форма на слушалки: Over ear, circumaural\r\nВременски период на батерија: 53 часа \r\nВреме на полнење: 3 часа\r\n', 37, 4, 'TellurHeadphones.png'),
(35, 'NuPhy Тастатура', 'Тип на тастатура: Механичка\r\nРаспоред на тастатура: Англиски (САД)\r\nЖивотен век (притискање на тастери): 100 милиони', 43, 5, 'NuPhyKeyboard.png'),
(36, 'Logitech Тастатура', 'Тип на тастатура: Механичка\r\nРаспоред на тастатура: Англиски (САД)\r\nЖивотен век (притискање на тастери): 50 милиони', 61, 5, 'LogitechKeyboard.png'),
(37, 'Lenovo Тастатура', 'Тип на тастатура: Оптичка\r\nРаспоред на тастатура: Англиски (САД)\r\nЖивотен век (притискање на тастери): 100 милиони', 6, 5, 'LenovoKeyboard.png'),
(38, 'KeyChron Тастатура', 'Тип на тастатура: Механичка\r\nРаспоред на тастатура: Англиски (САД)\r\nЖивотен век (притискање на тастери): 50 милиони', 25, 5, 'KeyChronKeyboard.png'),
(39, 'Razer Тастатура', 'Тип на тастатура: Механичка\r\nРаспоред на тастатура: Англиски (САД)\r\nЖивотен век (притискање на тастери): 80 милиони', 241, 5, 'RazerKeyboard.png'),
(40, 'PlayStation 5', 'Процесор: AMD Zen 2, 8 јадра, 3.5 GHz\r\nГрафичка картичка: RDNA 2, 10.28 TFLOP\r\nРезолуција: 4K, поддршка за 8K', 50, 6, 'playstation5.png'),
(41, 'Xbox Series X', 'Процесор: AMD Zen 2, 8 јадра, 3.8 GHz\r\nГрафичка картичка: RDNA 2, 12.15 TFLOP\r\nРезолуција: 4K, поддршка за 8K', 30, 6, 'xboxX.png'),
(42, 'Logitech Z906 Speakers', 'Тип на звучници: 5.1 канален систем\r\nРезолуција на звук: 1000W пик\r\nПоддршка за Dolby Digital и DTS', 15, 6, 'LogitechSpeakers.png'),
(43, 'Blue Yeti Microphone', 'Тип: USB микрофон\r\nФреквенција: 20 Hz - 20 kHz\r\nПоддршка за кардиоид, omni, и би-диференцијален режим', 40, 8, 'BlueyetiMicrophone.png'),
(44, 'NVIDIA GeForce RTX 3080', 'Графичка меморија: 10 GB GDDR6X\r\nПроцесор: Ampere архитектура\r\nРезолуција: 4K игри и Ray tracing', 12, 7, 'NvidiaRTX3080.png'),
(45, 'Intel Core i9-11900K', 'Процесор: 8 јадра, 16 нишки\r\nКлок: 3.5 GHz (може до 5.3 GHz)\r\nПамет: 16 MB Intel Smart Cache', 10, 7, 'Inteli9.png'),
(46, 'Corsair Vengeance LPX 16GB RAM', 'Тип на меморија: DDR4\r\nКапацитет: 16GB (2x8GB)\r\nБрзина: 3200 MHz', 25, 7, 'ram.png'),
(47, 'Nintendo Switch OLED', 'Екран: 7\" OLED\r\nПроцесор: Custom NVIDIA Tegra\r\nРезолуција: 720p (портативен) / 1080p (докирано)', 75, 6, 'nintendoswitch.png'),
(48, 'PlayStation 4 Pro', 'Процесор: AMD Jaguar, 8 јадра, 2.1 GHz\r\nГрафичка картичка: AMD GCN архитектура, 4.2 TFLOP\r\nРезолуција: 4K поддршка', 60, 6, 'ps4pro.png'),
(49, 'Bose Companion 2 Series III', 'Тип: Stereo систем\r\nРезолуција на звук: 50W RMS\r\nПоддршка за 3.5mm jack и RCA', 40, 9, 'BoseSpeaker.png'),
(50, 'Creative Pebble 2.0', 'Тип: 2.0 компјутерски звучници\r\nРезолуција на звук: 8W RMS\r\nВградено USB напојување', 120, 9, 'PebbleSpeaker.png'),
(51, 'Sonos One SL', 'Тип: Smart звучници\r\nПоддршка за Alexa и Google Assistant\r\nWi-Fi поврзаност', 25, 9, 'sonosSpeaker.png'),
(52, 'Razer Seiren X', 'Тип: USB микрофон\r\nФреквенција: 20 Hz - 20 kHz\r\nПоддршка за кардиоид режим', 30, 8, 'RazerMicrophone.png'),
(53, 'Audio-Technica AT2020', 'Тип: XLR кондензатор микрофон\r\nФреквенција: 20 Hz - 20 kHz\r\nНиво на сигнал: 37 dB', 15, 8, 'tehnicaMicrophone.png'),
(54, 'Shure SM7B', 'Тип: XLR динамичен микрофон\r\nФреквенција: 50 Hz - 20 kHz\r\nПоддршка за кардиоид режим', 10, 8, 'shureMicrophone.png'),
(55, 'Kingston A2000 1TB SSD', 'Тип: NVMe SSD\r\nКапацитет: 1TB\r\nЧитање: 2200 MB/s, Пишување: 2000 MB/s', 20, 7, 'kingston.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `lokacija`
--
ALTER TABLE `lokacija`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `naracki`
--
ALTER TABLE `naracki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokacija_id` (`lokacija_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lokacija`
--
ALTER TABLE `lokacija`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `naracki`
--
ALTER TABLE `naracki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `naracki`
--
ALTER TABLE `naracki`
  ADD CONSTRAINT `naracki_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`lokacija_id`) REFERENCES `lokacija` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

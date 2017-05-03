-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2017 at 04:14 AM
-- Server version: 5.7.11
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webai`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Kirkland Signature'),
(2, 'Wendell Estate');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'HealthCare'),
(2, 'Toiletry'),
(3, 'MotherChild'),
(4, 'Bag');

-- --------------------------------------------------------

--
-- Table structure for table `category_locale`
--

CREATE TABLE IF NOT EXISTS `category_locale` (
  `id` int(10) NOT NULL,
  `locale_id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_locale`
--

INSERT INTO `category_locale` (`id`, `locale_id`, `name`, `value`) VALUES
(1, 1, 'HealthCare', 'Health Care'),
(2, 2, 'HealthCare', '保健品'),
(3, 1, 'Toiletry', 'Toiletry'),
(4, 2, 'Toiletry', '化妆品'),
(5, 1, 'MotherChild', 'Mother & Child'),
(6, 2, 'MotherChild', '母婴类'),
(7, 1, 'Bag', 'Bag'),
(8, 2, 'Bag', '时尚包包');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE IF NOT EXISTS `category_product` (
  `id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `category_id`, `product_id`) VALUES
(1, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `image_type`
--

CREATE TABLE IF NOT EXISTS `image_type` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image_type`
--

INSERT INTO `image_type` (`id`, `name`) VALUES
(1, 'main'),
(2, 'side');

-- --------------------------------------------------------

--
-- Table structure for table `locale`
--

CREATE TABLE IF NOT EXISTS `locale` (
  `id` int(10) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `locale`
--

INSERT INTO `locale` (`id`, `code`, `value`) VALUES
(1, 'en', 'English'),
(2, 'zh', '中文');

-- --------------------------------------------------------

--
-- Table structure for table `mode`
--

CREATE TABLE IF NOT EXISTS `mode` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mode`
--

INSERT INTO `mode` (`id`, `name`) VALUES
(1, 'shop'),
(2, 'group'),
(3, 'redeem');

-- --------------------------------------------------------

--
-- Table structure for table `mode_category`
--

CREATE TABLE IF NOT EXISTS `mode_category` (
  `id` int(10) NOT NULL,
  `mode_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `origin`
--

CREATE TABLE IF NOT EXISTS `origin` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `origin`
--

INSERT INTO `origin` (`id`, `name`) VALUES
(1, 'China'),
(2, 'Canada');

-- --------------------------------------------------------

--
-- Table structure for table `origin_locale`
--

CREATE TABLE IF NOT EXISTS `origin_locale` (
  `id` int(10) NOT NULL,
  `locale_id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `origin_locale`
--

INSERT INTO `origin_locale` (`id`, `locale_id`, `name`, `value`) VALUES
(1, 1, 'China', 'China'),
(2, 2, 'China', '中国'),
(3, 1, 'Canada', 'Canada'),
(4, 2, 'Canada', '加拿大');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`) VALUES
(1, 'left'),
(2, 'center'),
(3, 'right');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `brand_id` int(10) NOT NULL,
  `origin_id` int(10) NOT NULL,
  `spec` varchar(100) DEFAULT NULL,
  `source` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `brand_id`, `origin_id`, `spec`, `source`) VALUES
(5, 'PrenatalMultivitamin', 'PrenatalMultivitaminDescription', '27', 1, 2, '300Tablets', 'https://www.costco.ca/Kirkland-Signature-Prenatal-Multivitamin----300-Tablets.product.100097099.html'),
(8, 'Wendell1kg', 'Wendell1kgDescription', '30', 2, 2, '1kg', 'https://secure.wendellestate.ca'),
(9, 'Wendell340g', 'Wendell340gDescription', '23', 2, 2, '340g', 'https://secure.wendellestate.ca');

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `path` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `type_id`, `path`) VALUES
(6, 5, 1, '/admin/uploads/5/PrenatalMultivitamin.jpeg'),
(7, 5, 1, '/admin/uploads/5/jar1kg.png'),
(8, 9, 1, '/admin/uploads/9/jar450@2x.png'),
(9, 9, 2, '/admin/uploads/9/jar-3.jpg'),
(10, 9, 2, '/admin/uploads/9/jar-4.jpg'),
(11, 9, 2, '/admin/uploads/9/jar340-2.png'),
(12, 9, 2, '/admin/uploads/9/jar450-1.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_locale`
--

CREATE TABLE IF NOT EXISTS `product_locale` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `locale_id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_locale`
--

INSERT INTO `product_locale` (`id`, `product_id`, `locale_id`, `name`, `value`) VALUES
(1, 0, 1, 'PrenatalMultivitamin', 'Kirkland Prenatal Multivitamin'),
(2, 0, 2, 'PrenatalMultivitamin', '柯克兰孕妇多种维生素'),
(3, 0, 1, 'PrenatalMultivitaminDescription', 'Kirkland Signature™ Prenatal Multivitamin is a Prenatal / Postpartum vitamin and mineral supplement. This Prenatal Multivitamin is specially formulated with 23 key vitamins and minerals to help provide nutrients that are important before, during, and after pregnancy.'),
(4, 0, 2, 'PrenatalMultivitaminDescription', '产前/产后维生素和矿物质补充剂。 这种产前多产维生素是特别配制的23种维生素和矿物质，以帮助提供怀孕前，怀孕期间和怀孕后重要的营养。'),
(5, 0, 1, '300Tablets', '300 Tablets'),
(6, 0, 2, '300Tablets', '300片'),
(19, 8, 1, 'Wendell1kg', 'Wendell Estate Honey - 1kg'),
(20, 8, 2, 'Wendell1kg', '温德尔庄园白蜜 - 1公斤'),
(21, 8, 1, 'Wendell1kgDescription', 'A Pure white honey. A smooth, exquisite texture. A world-class taste profile. Unmistakably Wendell Estate.'),
(22, 8, 2, 'Wendell1kgDescription', '纯白蜂蜜。 光滑，精致的质感。 世界级的品味。 无与伦比的温德尔庄园白蜜。'),
(23, 8, 1, '1kg', '1kg'),
(24, 8, 2, '1kg', '1公斤'),
(25, 9, 1, 'Wendell340g', 'Wendell Estate Honey - 340g'),
(26, 9, 2, 'Wendell340g', '温德尔庄园白蜜 - 340克'),
(27, 9, 1, 'Wendell340gDescription', 'A Pure white honey. A smooth, exquisite texture. A world-class taste profile. Unmistakably Wendell Estate.'),
(28, 9, 2, 'Wendell340gDescription', '纯白蜂蜜。 光滑，精致的质感。 世界级的品味。 无与伦比的温德尔庄园白蜜。'),
(29, 9, 1, '340g', '340g'),
(30, 9, 2, '340g', '340克');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name`, `value`) VALUES
(1, 'currency', '5.3');

-- --------------------------------------------------------

--
-- Table structure for table `setting_locale`
--

CREATE TABLE IF NOT EXISTS `setting_locale` (
  `id` int(10) NOT NULL,
  `locale_id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting_locale`
--

INSERT INTO `setting_locale` (`id`, `locale_id`, `name`, `value`) VALUES
(1, 1, 'WEBSITE_TITLE', 'Cishop'),
(2, 2, 'WEBSITE_TITLE', '喜购'),
(3, 1, 'PRICE', 'Price'),
(4, 2, 'PRICE', '价格'),
(5, 1, 'CURRENCY_SYMBOL', '$'),
(6, 2, 'CURRENCY_SYMBOL', '¥'),
(7, 1, 'CURRENCY_YUAN', 'CAD'),
(8, 2, 'CURRENCY_YUAN', '元'),
(9, 1, 'ORIGIN', 'Origin'),
(10, 2, 'ORIGIN', '产地'),
(11, 1, 'BRAND', 'Brand'),
(12, 2, 'BRAND', '品牌'),
(13, 1, 'SPEC', 'Specification'),
(14, 2, 'SPEC', '规格'),
(15, 1, 'QUANTITY', 'Quantity'),
(16, 2, 'QUANTITY', '数量'),
(17, 1, 'ADD_TO_CART', 'Add to cart'),
(18, 2, 'ADD_TO_CART', '加入购物车'),
(19, 1, 'CHECKOUT', 'Checkout'),
(20, 2, 'CHECKOUT', '结账'),
(21, 1, 'ITEM', 'Item'),
(22, 2, 'ITEM', '商品名称'),
(23, 1, 'CART_EMPTY', 'Your cart is empty.'),
(24, 2, 'CART_EMPTY', '你的购物车是空的。'),
(25, 1, 'BACK_TO_STORE', 'Back to store'),
(26, 2, 'BACK_TO_STORE', '返回到商店'),
(27, 1, 'CLEAR_CART', 'Clear cart'),
(28, 2, 'CLEAR_CART', '清空购物车'),
(29, 1, 'SEARCH', 'Search'),
(30, 2, 'SEARCH', '搜索');

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `path` varchar(100) NOT NULL,
  `text` varchar(500) NOT NULL,
  `link` varchar(500) DEFAULT NULL,
  `position_id` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slide`
--

INSERT INTO `slide` (`id`, `name`, `path`, `text`, `link`, `position_id`) VALUES
(4, 'handbag', '/admin/uploads/slide/top-handle-bags-banner.jpg', 'handbag_banner', NULL, 1),
(5, 'HealthCare', '/admin/uploads/slide/healthCare.jpeg', 'HealthCare', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_locale`
--
ALTER TABLE `category_locale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_type`
--
ALTER TABLE `image_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locale`
--
ALTER TABLE `locale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mode`
--
ALTER TABLE `mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mode_category`
--
ALTER TABLE `mode_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `origin`
--
ALTER TABLE `origin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `origin_locale`
--
ALTER TABLE `origin_locale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_locale`
--
ALTER TABLE `product_locale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_locale`
--
ALTER TABLE `setting_locale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `category_locale`
--
ALTER TABLE `category_locale`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `image_type`
--
ALTER TABLE `image_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `locale`
--
ALTER TABLE `locale`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mode`
--
ALTER TABLE `mode`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mode_category`
--
ALTER TABLE `mode_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `origin`
--
ALTER TABLE `origin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `origin_locale`
--
ALTER TABLE `origin_locale`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `product_locale`
--
ALTER TABLE `product_locale`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `setting_locale`
--
ALTER TABLE `setting_locale`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `slide`
--
ALTER TABLE `slide`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

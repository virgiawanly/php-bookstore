-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for bookstore
CREATE DATABASE IF NOT EXISTS `bookstore` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bookstore`;

-- Dumping structure for table bookstore.books
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL DEFAULT '0',
  `slug` varchar(256) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `writer` varchar(256) NOT NULL DEFAULT '',
  `publisher` varchar(256) NOT NULL DEFAULT '',
  `year` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  `thumbnail` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_books_categories` (`category_id`),
  CONSTRAINT `FK_books_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.books: ~4 rows (approximately)
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` (`id`, `title`, `slug`, `description`, `writer`, `publisher`, `year`, `price`, `stock`, `category_id`, `thumbnail`) VALUES
	(1, 'Javascript Eloquent', 'javascript', '3rd edition (2018) This is a book about JavaScript, programming, and the wonders of the digital. You can read it online here, or buy your own paperback copy. Written by Marijn Haverbeke.', 'Marijn Haverbeke', 'IDK', 2021, 50000, 5, 2, 'IMG-60cddf5e39e32.jpg'),
	(2, 'Bicara itu ada seninya', 'bicara-itu-ada-seninya', 'Buku ini dijabarkan agar dapat dimengerti oleh siapa saja. Anda dapat belajar dari banyak pengalaman orang-orang terkenal dan juga mengenai rahasia inti komunikasi. Jika Anda membacanya dengan runut, saya yakin rasa percaya diri Anda untuk berbicara pun akan tumbuh dengan sendirinya.', 'Oh Su Hyang', 'Gramedia', 2017, 67000, 10, 1, 'IMG-60cde00cdadd7.jpg'),
	(9, 'Berani Tidak Disukai', 'berani-tidak-disukai', 'membaca buku ini bisa mengubah hidup anda. jutaan orang sudah menarik manfaat darinya. sekarang giliran anda.\r\n\r\nBerani Tidak Disukai, yang sudah terjual lebih dari 3,5 juta eksemplar, mengungkap rahasia mengeluarkan kekuatan terpendam yang memungkinkan Anda meraih kebahagiaan yang hakiki dan menjadi sosok yang Anda idam-idamkan.\r\n\r\nApakah kebahagiaan adalah sesuatu yang Anda pilih?\r\n\r\nBerani Tidak Disukai menyajikan jawabannya secara sederhana dan langsung. Berdasarkan teori Alfred Adler, satu dari tiga psikolog terkemuka abad kesembilan belas selain Freud dan Jung, buku ini mengikuti percakapan yang menggugah antara seorang filsuf dan seorang pemuda. Dalam lima percakapan yang terjalin, sang filsuf membantu muridnya memahami bagaimana masing-masing dari kita mampu menentukan arah hidup kita, bebas dari belenggu trauma masa lalu dan beban ekspektasi orang lain.\r\n\r\nBuku yang kaya kebijaksanaan ini akan memandu Anda memahami konsep memaafkan diri sendiri, mencintai diri, dan menyingkirkan hal-hal yang tidak penting dari pikiran. Cara pikir yang membebaskan ini memungkinkan Anda membangun keberanian untuk mengubah dan mengabaikan batasan yang mungkin Anda berlakukan bagi diri Anda.', 'Ichiro Kishimi dan Fumitake Koga', 'Gramedia Pustaka Utama', 2019, 75000, 20, 1, 'IMG-60cddf66a27fa.jpg'),
	(10, 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa', 'Atomic-Habits', 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa', 'Mana saya tau', 'Gramedia Pustaka Utama', 2019, 108000, 10, 1, 'IMG-60cde1223d26e.jpg');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;

-- Dumping structure for table bookstore.book_order
CREATE TABLE IF NOT EXISTS `book_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_book_order_orders` (`order_id`),
  KEY `FK_book_order_books` (`book_id`),
  CONSTRAINT `FK_book_order_books` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_book_order_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.book_order: ~4 rows (approximately)
/*!40000 ALTER TABLE `book_order` DISABLE KEYS */;
INSERT INTO `book_order` (`id`, `order_id`, `book_id`, `amount`) VALUES
	(30, 25, 1, 1),
	(31, 26, 1, 2),
	(32, 27, 1, 1),
	(33, 27, 2, 1);
/*!40000 ALTER TABLE `book_order` ENABLE KEYS */;

-- Dumping structure for table bookstore.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_cart_books` (`book_id`),
  KEY `FK_cart_users` (`user_id`),
  CONSTRAINT `FK_cart_books` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_cart_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.carts: ~2 rows (approximately)
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` (`id`, `user_id`, `book_id`) VALUES
	(26, 1, 9),
	(27, 3, 1);
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;

-- Dumping structure for table bookstore.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.categories: ~1 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `slug`, `image`) VALUES
	(1, 'Novel', 'novel', 'c-novel.svg'),
	(2, 'Teknologi', 'teknologi', 'c-technologyl.svg');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table bookstore.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `order_number` varchar(50) NOT NULL DEFAULT '0',
  `address` text NOT NULL,
  `message` varchar(255) DEFAULT '0',
  `courier` varchar(255) NOT NULL DEFAULT '0',
  `total_price` int(11) NOT NULL DEFAULT '0',
  `status` enum('Payment','Delivery','Received') NOT NULL DEFAULT 'Payment',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `FK_orders_users` (`user_id`),
  CONSTRAINT `FK_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.orders: ~2 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `user_id`, `order_number`, `address`, `message`, `courier`, `total_price`, `status`, `created_at`) VALUES
	(25, 1, 'ORDER-57317296', 'Gg. Perjuangan kel. Muka kec. Cianjur, Cianjur, Jawa Barat | 432121', 'aaaa', 'JNT', 95000, 'Payment', '2021-06-19 14:51:45'),
	(26, 3, 'ORDER-23797223', 'Gg. Perjuangan kel. Muka kec. Cianjur, Cianjur, Jawa Barat | 432121', 'Test', 'JNT', 100000, 'Payment', '2021-06-19 15:28:01'),
	(27, 3, 'ORDER-51563552', 'Gg. Perjuangan kel. Muka kec. Cianjur, Cianjur, Jawa Barat | 432121', 'dasadsasdasd', 'JNT', 252000, 'Delivery', '2021-06-19 15:42:09');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table bookstore.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` enum('Admin','User') NOT NULL DEFAULT 'User',
  `avatar` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table bookstore.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `avatar`) VALUES
	(1, 'Admin', 'admin@gmail.com', '$2y$10$e6rwWUZudLTbxZM4hV19LeqBSTiEFI5R3dwEp5S2QV7KbyomOVZ0G', 'Admin', 'default-avatar.svg'),
	(3, 'Virgiawan Listiyandi', 'virgiawan@gmail.com', '$2y$10$M6lsUWlNulRo.BvrPAo2keGWKmCb7lIN5CHBvfB/GS15nefSrWHkG', 'User', 'default-avatar.svg');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

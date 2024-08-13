-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.5.52-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para online_store
CREATE DATABASE IF NOT EXISTS `online_store` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `online_store`;


-- Volcando estructura para tabla online_store.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla online_store.orders: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `user_id`, `date`, `total`) VALUES
	(1, 1, '2024-08-13 17:05:08', 107997.00);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;


-- Volcando estructura para tabla online_store.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla online_store.order_items: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
	(1, 1, 9, 2),
	(2, 1, 32, 1);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;


-- Volcando estructura para tabla online_store.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `subcategory` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `size` int(4) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla online_store.products: ~49 rows (aproximadamente)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `category_id`, `subcategory`, `gender`, `name`, `description`, `size`, `price`, `image`) VALUES
	(3, 2, 'Tenis', 'Mujer', 'Tenis Casuales', 'Tenis para uso diario', 38, 49.99, 'tenis_mujer.jpg'),
	(4, 2, 'Botines', 'Mujer', 'Botines con Tacón', 'Botines elegantes con tacón', 39, 89.99, 'botines_mujer.jpg'),
	(5, 3, 'Tenis', 'Niños', 'Tenis Escolares', 'Tenis para la escuela', 34, 39.99, 'tenis_ninos.jpg'),
	(6, 3, 'Botines', 'Niños', 'Botines de Aventura', 'Botines resistentes para niños', 35, 59.99, 'botines_ninos.jpg'),
	(7, 1, 'Tenis', 'Hombre', 'Tenis Deportivos Azul', 'Tenis para correr', 42, 35999.00, 'tenis_hombre_azul.jpg'),
	(8, 1, 'Tenis', 'Hombre', 'Tenis Deportivos Rojo', 'Tenis para correr', 43, 35999.00, 'tenis_hombre_rojo.jpg'),
	(9, 1, 'Tenis', 'Hombre', 'Tenis Casual Negro', 'Tenis para uso diario', 41, 29999.00, 'tenis_hombre_negro.jpg'),
	(10, 1, 'Tenis', 'Hombre', 'Tenis Casual Blanco', 'Tenis para uso diario', 40, 29999.00, 'tenis_hombre_blanco.jpg'),
	(11, 1, 'Tenis', 'Hombre', 'Tenis Running Verde', 'Tenis para correr', 42, 41999.00, 'tenis_hombre_verde.jpg'),
	(12, 1, 'Tenis', 'Hombre', 'Tenis Running Amarillo', 'Tenis para correr', 43, 41999.00, 'tenis_hombre_amarillo.jpg'),
	(13, 1, 'Tenis', 'Hombre', 'Tenis Deportivo Gris', 'Tenis para correr', 44, 35999.00, 'tenis_hombre_gris.jpg'),
	(14, 1, 'Tenis', 'Hombre', 'Tenis Deportivo Naranja', 'Tenis para correr', 45, 35999.00, 'tenis_hombre_naranja.jpg'),
	(15, 1, 'Botines', 'Hombre', 'Botines de Cuero Marrón', 'Botines elegantes', 43, 47999.00, 'botines_hombre_marron.jpg'),
	(16, 1, 'Botines', 'Hombre', 'Botines de Cuero Negro', 'Botines elegantes', 42, 47999.00, 'botines_hombre_negro.jpg'),
	(17, 1, 'Botines', 'Hombre', 'Botines de Gamuza Beige', 'Botines elegantes', 41, 54999.00, 'botines_hombre_beige.jpg'),
	(18, 1, 'Botines', 'Hombre', 'Botines de Gamuza Azul', 'Botines elegantes', 40, 54999.00, 'botines_hombre_azul.jpg'),
	(19, 1, 'Botines', 'Hombre', 'Botines de Cuero Rojo', 'Botines elegantes', 44, 47999.00, 'botines_hombre_rojo.jpg'),
	(20, 1, 'Botines', 'Hombre', 'Botines de Cuero Verde', 'Botines elegantes', 42, 47999.00, 'botines_hombre_verde.jpg'),
	(21, 1, 'Botines', 'Hombre', 'Botines de Cuero Gris', 'Botines elegantes', 43, 47999.00, 'botines_hombre_gris.jpg'),
	(22, 2, 'Tenis', 'Mujer', 'Tenis Deportivos Rosa', 'Tenis para correr', 38, 35999.00, 'tenis_mujer_rosa.jpg'),
	(23, 2, 'Tenis', 'Mujer', 'Tenis Deportivos Lila', 'Tenis para correr', 39, 35999.00, 'tenis_mujer_lila.jpg'),
	(24, 2, 'Tenis', 'Mujer', 'Tenis Casual Blanco', 'Tenis para uso diario', 37, 29999.00, 'tenis_mujer_blanco.jpg'),
	(25, 2, 'Tenis', 'Mujer', 'Tenis Casual Negro', 'Tenis para uso diario', 36, 29999.00, 'tenis_mujer_negro.jpg'),
	(26, 2, 'Tenis', 'Mujer', 'Tenis Running Verde', 'Tenis para correr', 39, 41999.00, 'tenis_mujer_verde.jpg'),
	(27, 2, 'Tenis', 'Mujer', 'Tenis Running Azul', 'Tenis para correr', 38, 41999.00, 'tenis_mujer_azul.jpg'),
	(28, 2, 'Tenis', 'Mujer', 'Tenis Deportivo Gris', 'Tenis para correr', 37, 35999.00, 'tenis_mujer_gris.jpg'),
	(29, 2, 'Tenis', 'Mujer', 'Tenis Deportivo Naranja', 'Tenis para correr', 36, 35999.00, 'tenis_mujer_naranja.jpg'),
	(30, 2, 'Botines', 'Mujer', 'Botines con Tacón Marrón', 'Botines elegantes con tacón', 39, 54999.00, 'botines_mujer_marron.jpg'),
	(31, 2, 'Botines', 'Mujer', 'Botines con Tacón Negro', 'Botines elegantes con tacón', 38, 54999.00, 'botines_mujer_negro.jpg'),
	(32, 2, 'Botines', 'Mujer', 'Botines de Gamuza Beige', 'Botines elegantes', 37, 47999.00, 'botines_mujer_beige.jpg'),
	(33, 2, 'Botines', 'Mujer', 'Botines de Gamuza Azul', 'Botines elegantes', 39, 47999.00, 'botines_mujer_azul.jpg'),
	(34, 2, 'Botines', 'Mujer', 'Botines con Tacón Rojo', 'Botines elegantes con tacón', 38, 54999.00, 'botines_mujer_rojo.jpg'),
	(35, 2, 'Botines', 'Mujer', 'Botines con Tacón Verde', 'Botines elegantes con tacón', 37, 54999.00, 'botines_mujer_verde.jpg'),
	(36, 2, 'Botines', 'Mujer', 'Botines con Tacón Gris', 'Botines elegantes con tacón', 38, 54999.00, 'botines_mujer_gris.jpg'),
	(37, 3, 'Tenis', 'Niños', 'Tenis Escolares Azul', 'Tenis para la escuela', 34, 23999.00, 'tenis_ninos_azul.jpg'),
	(38, 3, 'Tenis', 'Niños', 'Tenis Escolares Rojo', 'Tenis para la escuela', 35, 23999.00, 'tenis_ninos_rojo.jpg'),
	(39, 3, 'Tenis', 'Niños', 'Tenis Casual Blanco', 'Tenis para uso diario', 33, 17999.00, 'tenis_ninos_blanco.jpg'),
	(40, 3, 'Tenis', 'Niños', 'Tenis Casual Negro', 'Tenis para uso diario', 32, 17999.00, 'tenis_ninos_negro.jpg'),
	(41, 3, 'Tenis', 'Niños', 'Tenis Running Verde', 'Tenis para correr', 35, 29999.00, 'tenis_ninos_verde.jpg'),
	(42, 3, 'Tenis', 'Niños', 'Tenis Running Amarillo', 'Tenis para correr', 34, 29999.00, 'tenis_ninos_amarillo.jpg'),
	(43, 3, 'Tenis', 'Niños', 'Tenis Deportivo Gris', 'Tenis para correr', 33, 23999.00, 'tenis_ninos_gris.jpg'),
	(44, 3, 'Tenis', 'Niños', 'Tenis Deportivo Naranja', 'Tenis para correr', 32, 23999.00, 'tenis_ninos_naranja.jpg'),
	(45, 3, 'Botines', 'Niños', 'Botines de Aventura Marrón', 'Botines resistentes para niños', 35, 35999.00, 'botines_ninos_marron.jpg'),
	(46, 3, 'Botines', 'Niños', 'Botines de Aventura Negro', 'Botines resistentes para niños', 34, 35999.00, 'botines_ninos_negro.jpg'),
	(47, 3, 'Botines', 'Niños', 'Botines de Gamuza Beige', 'Botines resistentes para niños', 33, 41999.00, 'botines_ninos_beige.jpg'),
	(48, 3, 'Botines', 'Niños', 'Botines de Gamuza Azul', 'Botines resistentes para niños', 32, 41999.00, 'botines_ninos_azul.jpg'),
	(49, 3, 'Botines', 'Niños', 'Botines de Aventura Rojo', 'Botines resistentes para niños', 34, 35999.00, 'botines_ninos_rojo.jpg'),
	(50, 3, 'Botines', 'Niños', 'Botines de Aventura Verde', 'Botines resistentes para niños', 35, 35999.00, 'botines_ninos_verde.jpg'),
	(51, 3, 'Botines', 'Niños', 'Botines de Aventura Gris', 'Botines resistentes para niños', 34, 35999.00, 'botines_ninos_gris.jpg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Volcando estructura para tabla online_store.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla online_store.users: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `last_name`, `phone`, `email`, `password`) VALUES
	(1, 'Matus', 'Salas', '83229420', 'matusalas@gmail.com', '123'),
	(2, 'Randall', 'Madrigal', '83229422', 'randola93@gmail.com', '123'),
	(3, 'Diego', 'Chavala', '83226920', 'chavalaluis30@gmail.com', '123');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

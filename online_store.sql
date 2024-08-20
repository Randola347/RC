-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-08-2024 a las 04:45:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 9, 2),
(2, 1, 32, 1);

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `size` int(4) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`id`, `category_id`, `subcategory`, `gender`, `name`, `description`, `size`, `price`, `image`) VALUES
(3, 2, 'Tenis', 'Mujer', 'Tenis Casuales', 'Tenis para uso diario', 38, 49990.00, 'tenis_mujer.jpg'),
(4, 2, 'Botines', 'Mujer', 'Botines con Tacón', 'Botines elegantes con tacón', 39, 89990.00, 'botines_mujer.jpg'),
(5, 3, 'Tenis', 'Niños', 'Tenis Escolares', 'Tenis para la escuela', 34, 39990.00, 'tenis_ninos.jpg'),
(6, 3, 'Botines', 'Niños', 'Botines de Aventura', 'Botines resistentes para niños', 35, 59990.00, 'botines_ninos.jpg'),
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

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `last_name`, `phone`, `email`, `password`) VALUES
(1, 'Matus', 'Salas', '83229420', 'matusalas@gmail.com', '123'),
(2, 'Cristopher', 'Matus Salas', '86074258', 'cristophermatus10@gmail.com', '123'),
(3, 'Diego', 'Chavala', '83226920', 'chavalaluis30@gmail.com', '123');

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

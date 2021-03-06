-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2021 年 2 月 26 日 20:36
-- サーバのバージョン： 5.5.62
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codecamp41224`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(100) NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `item_id`, `amount`, `createdate`, `updatedate`) VALUES
(6, 2, 9, 8, '2021-01-06 22:59:11', '2021-01-07 07:13:53'),
(7, 2, 6, 7, '2021-01-07 07:14:18', '2021-01-07 07:14:26');

-- --------------------------------------------------------

--
-- テーブルの構造 `details`
--

CREATE TABLE `details` (
  `history_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `favorite`
--

CREATE TABLE `favorite` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `favorite`
--

INSERT INTO `favorite` (`favorite_id`, `user_id`, `item_id`, `img`, `createdate`) VALUES
(1, 2, 6, '', '2021-01-06 22:02:06'),
(2, 2, 7, '', '2021-01-06 22:04:56'),
(3, 3, 8, '', '2021-01-07 07:53:22');

-- --------------------------------------------------------

--
-- テーブルの構造 `history`
--

CREATE TABLE `history` (
  `history_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `history`
--

INSERT INTO `history` (`history_id`, `user_id`, `item_id`, `img`, `name`, `price`, `createdate`) VALUES
(1, 3, 8, 'd3239df308f2b9b3a86f58efa48cfe1c00254cba.jpg', '黒マスク', 456, '2021-01-07 08:09:33'),
(2, 3, 5, 'dfdc12f180992da0b40232aa977f7b0e95f1f14b.jpg', 'チョコ', 777, '2021-01-07 08:11:05'),
(3, 3, 22, 'eda201d9e8de4b283c68d13e650b4c96da0e392e.jpg', 'sasasas', 500, '2021-01-07 08:12:39'),
(4, 3, 3, '04e0841e66a136e0be5a65e1dd2d207f219575a8.jpg', 'お茶', 555, '2021-01-07 08:26:37'),
(5, 3, 4, '52127c9d58420178749566940026605eafbf3ddb.jpg', 'チョコ', 777, '2021-01-07 08:26:37'),
(6, 3, 3, '04e0841e66a136e0be5a65e1dd2d207f219575a8.jpg', 'お茶', 555, '2021-01-07 08:30:40'),
(7, 3, 4, '52127c9d58420178749566940026605eafbf3ddb.jpg', 'チョコ', 777, '2021-01-07 08:30:40'),
(8, 3, 22, 'eda201d9e8de4b283c68d13e650b4c96da0e392e.jpg', 'sasasas', 500, '2021-01-07 08:34:35'),
(9, 3, 9, '5bd8e1d0b7af72d7bf35184957084e7879e02714.jpg', '紅マスク', 954, '2021-01-07 08:36:35');

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `status` int(100) NOT NULL DEFAULT '0',
  `stock` int(100) NOT NULL,
  `category` int(100) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`item_id`, `name`, `price`, `img`, `status`, `stock`, `category`, `comment`, `createdate`, `updatedate`) VALUES
(2, 'a', 1234, 'f2076e9bfc852abad624163ebb276bf9c0fd4295.jpg', 1, 0, 0, 'これは車の写真です', '2020-12-24 22:42:58', '2021-01-06 19:51:19'),
(3, 'お茶', 555, '04e0841e66a136e0be5a65e1dd2d207f219575a8.jpg', 1, 9, 0, 'これは家の写真です', '2020-12-24 22:45:34', '2021-01-07 08:30:40'),
(4, 'チョコ', 777, '52127c9d58420178749566940026605eafbf3ddb.jpg', 1, 9, 0, 'さようなら', '2020-12-24 22:59:35', '2021-01-07 08:30:40'),
(5, 'チョコ', 777, 'dfdc12f180992da0b40232aa977f7b0e95f1f14b.jpg', 1, 10, 0, '0123456789012345678901234\r\n567890123456789', '2020-12-24 22:59:36', '2021-01-07 08:11:05'),
(6, '赤マスク', 888, '52915bb0c7ae86655d13e1aa3e23d9295e0bb3a0.jpg', 1, 10, 1, 'これは赤マスクです', '2021-01-03 13:00:11', '2021-01-03 13:00:11'),
(7, '黄色マスク', 999, 'd4c2e2677dab527820a312e3a3ffaa08a1cd6803.jpg', 1, 7, 1, 'これは黄色マスクです', '2021-01-03 13:01:02', '2021-01-03 13:02:12'),
(8, '黒マスク', 456, 'd3239df308f2b9b3a86f58efa48cfe1c00254cba.jpg', 1, 0, 1, 'これは黒マスクです', '2021-01-03 13:01:48', '2021-01-07 08:09:33'),
(9, '紅マスク', 954, '5bd8e1d0b7af72d7bf35184957084e7879e02714.jpg', 1, 9, 1, 'これは紅マスクです', '2021-01-03 13:03:14', '2021-01-07 08:36:35'),
(10, '緑マスク', 334, 'ea0980b0c5635b5779f7bf2012ae4a47df8c698a.jpg', 1, 3, 2, 'これは緑マスクです', '2021-01-03 13:03:50', '2021-01-03 13:03:50'),
(11, '白マスク', 587, '993f14181ecf0e2e7b26453d25dbd9bde44c884f.jpg', 1, 66, 2, 'このマスクはとても白いです', '2021-01-03 13:04:26', '2021-01-03 13:08:47'),
(12, '水色マスク', 3567, '79874cdb764ea651d8e0aec7b2e8ae9c10822b43.jpg', 1, 77, 2, 'このマスクの色は水色です', '2021-01-03 13:05:19', '2021-01-03 13:08:56'),
(13, 'ピンクマスク', 300, 'd65264cbe350291811544e78301095407df6989e.jpg', 1, 150, 2, 'これはピンクマスクです', '2021-01-03 13:06:04', '2021-01-03 13:09:06'),
(14, '紫マスク', 8900, '535202d3981f7ecbfc654c3ddfdd418722ef99f4.jpg', 1, 55, 3, 'これは紫マスクです', '2021-01-03 13:06:41', '2021-01-03 13:09:16'),
(15, '松本マスク', 6667, 'a5f5517a1ec280dad61c10d10984ab7655374aff.jpg', 1, 54, 3, 'これは松本マスクです', '2021-01-03 13:07:30', '2021-01-03 13:09:21'),
(16, '動物マスク', 4998, '8b8457d90337d6dc56a7c4082df3f89d6eb69bc2.jpg', 1, 10, 3, 'これは動物マスクです', '2021-01-03 13:08:14', '2021-01-03 13:09:29'),
(17, 'コーラ', 300, '3ff6c3f560f227d0c9f126cf508fe7252de55eed.jpg', 1, 8, 3, 'コーラのような物', '2021-01-03 13:10:07', '2021-01-03 13:10:07'),
(18, 'シンプル', 6987, 'f642d3a930a0021608edce2c07772409188e0449.jpg', 1, 8, 4, 'シンプル', '2021-01-03 13:10:52', '2021-01-03 13:10:52'),
(19, 'とてもシンプル', 22222, '04d452fb82525e9416ad0cec800ff322964d310e.jpg', 1, 23, 4, '非常にシンプル', '2021-01-03 13:11:32', '2021-01-03 13:11:32'),
(20, 'かなりシンプル', 55555, 'f5ab0a4a0f7515253c535188b6b7b9d5cd738662.jpg', 1, 8, 4, 'かなりシンプルです', '2021-01-03 13:12:07', '2021-01-03 13:12:07'),
(21, '最もシンプル', 7777, 'f862a07681028e830351260adf97cd90f7c5a623.jpg', 1, 77, 4, '最もシンプルなマスクとなっています', '2021-01-03 13:12:45', '2021-01-03 13:12:45'),
(22, 'sasasas', 500, 'eda201d9e8de4b283c68d13e650b4c96da0e392e.jpg', 1, -1, 0, 'aaaaa', '2021-01-04 12:09:07', '2021-01-07 08:34:35');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `createdate`) VALUES
(1, 'matsumoto', '1234matsumoto', '2020-12-30 05:10:04'),
(2, 'matsumo', '123456789', '2020-12-30 05:13:30'),
(3, 'matumototo', '12345678', '2020-12-30 05:19:52'),
(4, 'matsumotototo', '1234567890', '2020-12-30 05:21:12'),
(5, 'codecamp44', '222333444', '2021-01-06 22:57:52'),
(6, 'codecamp3456', '123456789', '2021-01-07 08:06:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`favorite_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

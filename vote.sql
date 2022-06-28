-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-06-28 09:39:02
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `vote`
--

-- --------------------------------------------------------

--
-- 資料表結構 `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `acc` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pw` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `gender` tinyint(1) UNSIGNED NOT NULL,
  `addr` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `logs`
--

CREATE TABLE `logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `option_id` int(11) UNSIGNED NOT NULL,
  `vote_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `subject_id`, `option_id`, `vote_time`) VALUES
(1, 0, 2, 8, '2022-06-23 10:46:56'),
(2, 0, 2, 10, '2022-06-23 10:46:56'),
(3, 0, 6, 28, '2022-06-23 10:47:14'),
(4, 0, 6, 29, '2022-06-23 10:47:14'),
(5, 0, 1, 6, '2022-06-23 10:50:56'),
(6, 0, 1, 3, '2022-06-23 10:51:03'),
(7, 0, 1, 3, '2022-06-23 10:51:30'),
(8, 0, 1, 2, '2022-06-23 12:06:02'),
(9, 0, 1, 4, '2022-06-25 06:37:05'),
(10, 0, 4, 18, '2022-06-25 13:42:35'),
(11, 0, 6, 27, '2022-06-25 13:43:30'),
(12, 0, 1, 1, '2022-06-26 05:37:00');

-- --------------------------------------------------------

--
-- 資料表結構 `options`
--

CREATE TABLE `options` (
  `id` int(11) UNSIGNED NOT NULL,
  `option` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `options`
--

INSERT INTO `options` (`id`, `option`, `subject_id`, `total`) VALUES
(1, '假洨', 1, 1),
(2, '綠咖哩', 1, 1),
(3, '炸蝦烏龍麵', 1, 2),
(4, '牛雜湯', 1, 2),
(5, '壽喜燒', 1, 0),
(6, '老四川', 1, 3),
(7, '蘆洲', 2, 0),
(8, '泰山', 2, 1),
(9, '納美克星球', 2, 0),
(10, '木衛二_歐羅巴', 2, 1),
(11, '於是卡茲停止了思考', 2, 0),
(16, '可是我不會唱歌', 4, 0),
(17, '桃園下交流道', 4, 0),
(18, '左轉半套', 4, 1),
(19, '右轉全套', 4, 0),
(20, '睡死了', 5, 0),
(21, '進入彌留狀態', 5, 0),
(22, '迴光返照', 5, 0),
(23, '聽說有大地震', 5, 0),
(24, '但我沒有感覺', 5, 0),
(25, '睡得好爽喔', 5, 0),
(26, '彬彬', 6, 0),
(27, '阿傑', 6, 1),
(28, '阿偉', 6, 1),
(29, '我家很大', 6, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) UNSIGNED NOT NULL,
  `subject` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `multiple` tinyint(1) NOT NULL DEFAULT 0,
  `mulit_limit` tinyint(2) NOT NULL DEFAULT 1,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `total` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `subjects`
--

INSERT INTO `subjects` (`id`, `subject`, `type_id`, `multiple`, `mulit_limit`, `start`, `end`, `total`) VALUES
(1, '金眠甲沙小', 2, 0, 1, '2022-06-19', '2022-06-29', 9),
(2, '我是誰我在哪', 6, 1, 1, '2022-06-19', '2022-06-29', 2),
(4, '今晚去哪嗨', 1, 0, 1, '2022-06-19', '2022-06-29', 1),
(5, '睡到11點的你有發現什麼', 2, 1, 1, '2022-06-20', '2022-06-08', 0),
(6, '台北市長候選人你會選誰', 3, 1, 1, '2022-06-20', '2022-06-30', 3);

-- --------------------------------------------------------

--
-- 資料表結構 `types`
--

CREATE TABLE `types` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `types`
--

INSERT INTO `types` (`id`, `name`) VALUES
(1, '素人'),
(2, '生活'),
(3, '政治'),
(4, '經濟'),
(5, '科技'),
(6, '旅遊');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `acc` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pw` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

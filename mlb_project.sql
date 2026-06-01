-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2026-06-01 13:29:06
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `mlb_project`
--

-- --------------------------------------------------------

--
-- 資料表結構 `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `game_date` date NOT NULL,
  `matchup` varchar(100) NOT NULL COMMENT '例如: LAD vs NYY'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `games`
--

INSERT INTO `games` (`game_id`, `game_date`, `matchup`) VALUES
(1, '2024-05-10', 'LAD vs SD'),
(2, '2024-05-11', 'NYY vs TB'),
(3, '2024-05-12', 'ATL vs NYM');

-- --------------------------------------------------------

--
-- 資料表結構 `players`
--

CREATE TABLE `players` (
  `player_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(20) NOT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `players`
--

INSERT INTO `players` (`player_id`, `name`, `position`, `team_id`) VALUES
(1, 'Shohei Ohtani (大谷翔平)', 'DH', 1),
(2, 'Mookie Betts', 'SS', 1),
(3, 'Freddie Freeman', '1B', 1),
(4, 'Will Smith', 'C', 1),
(6, 'Teoscar Hernandez', 'OF', 1),
(7, 'Gavin Lux', '2B', 1),
(8, 'Yoshinobu Yamamoto (山本由伸)', 'P', 1),
(9, 'Tyler Glasnow', 'P', 1),
(10, 'Evan Phillips', 'P', 1),
(11, 'Aaron Judge', 'OF', 2),
(12, 'Juan Soto', 'OF', 2),
(13, 'Gerrit Cole', 'P', 2),
(14, 'Giancarlo Stanton', 'DH', 2),
(15, 'Anthony Volpe', 'SS', 2),
(16, 'Gleyber Torres', '2B', 2),
(17, 'Alex Verdugo', 'OF', 2),
(18, 'Jose Trevino', 'C', 2),
(19, 'Carlos Rodon', 'P', 2),
(20, 'Clay Holmes', 'P', 2),
(21, 'Ronald Acuna Jr.', 'OF', 3),
(22, 'Matt Olson', '1B', 3),
(23, 'Austin Riley', '3B', 3),
(24, 'Ozzie Albies', '2B', 3),
(25, 'Marcell Ozuna', 'DH', 3),
(26, 'Michael Harris II', 'OF', 3),
(27, 'Sean Murphy', 'C', 3),
(28, 'Spencer Strider', 'P', 3),
(29, 'Max Fried', 'P', 3),
(30, 'Chris Sale', 'P', 3),
(31, 'Max Muncy', '3B', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `player_game_stats`
--

CREATE TABLE `player_game_stats` (
  `stat_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `at_bats` int(11) DEFAULT 0 COMMENT '打數',
  `hits` int(11) DEFAULT 0 COMMENT '安打',
  `home_runs` int(11) DEFAULT 0 COMMENT '全壘打'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `player_game_stats`
--

INSERT INTO `player_game_stats` (`stat_id`, `player_id`, `game_id`, `at_bats`, `hits`, `home_runs`) VALUES
(1, 1, 1, 5, 3, 1),
(2, 2, 1, 4, 2, 0),
(3, 3, 1, 4, 1, 1),
(4, 11, 2, 4, 2, 2),
(5, 12, 2, 3, 1, 0),
(6, 21, 3, 5, 2, 0),
(7, 22, 3, 4, 2, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `home_city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `home_city`) VALUES
(1, '洛杉磯道奇 (LAD)', 'Los Angeles'),
(2, '紐約洋基 (NYY)', 'New York'),
(3, '亞特蘭大勇士 (ATL)', 'Atlanta');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guest') NOT NULL DEFAULT 'guest'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- 資料表索引 `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_id`),
  ADD KEY `team_id` (`team_id`);

--
-- 資料表索引 `player_game_stats`
--
ALTER TABLE `player_game_stats`
  ADD PRIMARY KEY (`stat_id`),
  ADD KEY `player_id` (`player_id`),
  ADD KEY `game_id` (`game_id`);

--
-- 資料表索引 `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `players`
--
ALTER TABLE `players`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `player_game_stats`
--
ALTER TABLE `player_game_stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `player_game_stats`
--
ALTER TABLE `player_game_stats`
  ADD CONSTRAINT `player_game_stats_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `player_game_stats_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

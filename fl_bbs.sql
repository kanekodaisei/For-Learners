-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 
-- サーバのバージョン： 10.4.10-MariaDB
-- PHP のバージョン: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `fl_bbs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `message_store`
--

CREATE TABLE `message_store` (
  `id` int(11) NOT NULL,
  `message` varchar(100) NOT NULL,
  `member_id` int(11) NOT NULL,
  `op_member_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `my_profile`
--

CREATE TABLE `my_profile` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `skill` varchar(20) NOT NULL,
  `remarks` varchar(30) NOT NULL,
  `comment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `select_skill`
--

CREATE TABLE `select_skill` (
  `skill_id` int(11) NOT NULL,
  `skill_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `talk_list`
--

CREATE TABLE `talk_list` (
  `list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  `op_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `message_store`
--
ALTER TABLE `message_store`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `my_profile`
--
ALTER TABLE `my_profile`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `select_skill`
--
ALTER TABLE `select_skill`
  ADD PRIMARY KEY (`skill_id`);

--
-- テーブルのインデックス `talk_list`
--
ALTER TABLE `talk_list`
  ADD PRIMARY KEY (`list_id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `message_store`
--
ALTER TABLE `message_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `my_profile`
--
ALTER TABLE `my_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `select_skill`
--
ALTER TABLE `select_skill`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `talk_list`
--
ALTER TABLE `talk_list`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

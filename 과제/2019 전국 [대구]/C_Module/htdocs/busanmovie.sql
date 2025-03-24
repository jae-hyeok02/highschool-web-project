-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 19-07-28 08:42
-- 서버 버전: 10.1.31-MariaDB
-- PHP 버전: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `busanmovie`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `cinema`
--

CREATE TABLE `cinema` (
  `idx` int(11) NOT NULL,
  `cinema_name` text COLLATE utf8_bin NOT NULL,
  `cinema_file` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 테이블의 덤프 데이터 `cinema`
--

INSERT INTO `cinema` (`idx`, `cinema_name`, `cinema_file`) VALUES
(3, 'ㅁㄴㅇㅁㄴㅇ', '1563752147002.txt'),
(5, 'ghgh', '1563788668001.txt'),
(6, '롯데시네마', '1563968535001.txt'),
(7, '메가박스', '1563968543002.txt');

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `idx` int(11) NOT NULL,
  `id` text COLLATE utf8_bin NOT NULL,
  `pw` text COLLATE utf8_bin NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 테이블의 덤프 데이터 `member`
--

INSERT INTO `member` (`idx`, `id`, `pw`, `name`) VALUES
(2, 'admin', '1234', '관리자');

-- --------------------------------------------------------

--
-- 테이블 구조 `moviebuy`
--

CREATE TABLE `moviebuy` (
  `idx` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `phone_number` text COLLATE utf8_bin NOT NULL,
  `pw` text COLLATE utf8_bin NOT NULL,
  `cinema_idx` text COLLATE utf8_bin NOT NULL,
  `movie_idx` text COLLATE utf8_bin NOT NULL,
  `mov_seat` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 테이블의 덤프 데이터 `moviebuy`
--

INSERT INTO `moviebuy` (`idx`, `name`, `phone_number`, `pw`, `cinema_idx`, `movie_idx`, `mov_seat`) VALUES
(2, '김유저', '010-1234-1234', 'qwe123', '3', '3', '7c'),
(3, 'test', '010-1234-1234', 'qwe123', '6', '6', '6b'),
(4, '테스트좌석', '010-1234-1234', 'asd123', '5', '7', '4a'),
(5, '제발', '010-1234-5657', 'asd123', '5', '7', '6b');

-- --------------------------------------------------------

--
-- 테이블 구조 `movtime`
--

CREATE TABLE `movtime` (
  `idx` int(11) NOT NULL,
  `movie_type` text COLLATE utf8_bin NOT NULL,
  `movie_idx` text COLLATE utf8_bin NOT NULL,
  `cinema_idx` text COLLATE utf8_bin NOT NULL,
  `mov_start` text COLLATE utf8_bin NOT NULL,
  `mov_end` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 테이블의 덤프 데이터 `movtime`
--

INSERT INTO `movtime` (`idx`, `movie_type`, `movie_idx`, `cinema_idx`, `mov_start`, `mov_end`) VALUES
(32, 'official', '10', '6', '09:00', '12:20'),
(33, 'request', '2', '5', '08:00', '12:34'),
(34, 'official', '9', '6', '12:30', '13:30'),
(35, 'request', '1', '6', '14:30', '15:40'),
(40, 'official', '8', '6', '16:00', '24:00'),
(41, 'official', '11', '6', '24:00', '26:00'),
(42, 'official', '5', '5', '13:00', '15:20');

-- --------------------------------------------------------

--
-- 테이블 구조 `officialmov`
--

CREATE TABLE `officialmov` (
  `idx` int(11) NOT NULL,
  `mov_name` text COLLATE utf8_bin NOT NULL,
  `mov_poster` text COLLATE utf8_bin NOT NULL,
  `pd_name` text COLLATE utf8_bin NOT NULL,
  `running_time` text COLLATE utf8_bin NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirm_case` text COLLATE utf8_bin NOT NULL,
  `movie_type` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 테이블의 덤프 데이터 `officialmov`
--

INSERT INTO `officialmov` (`idx`, `mov_name`, `mov_poster`, `pd_name`, `running_time`, `register_date`, `confirm_case`, `movie_type`) VALUES
(3, 'ㄷㄷㄷㄷㄷ', '1563681606img_opening2.jpg', '감감감', '160', '2019-07-21 04:00:06', 'false', 'official'),
(5, 'jjj', '1563779806device repairs 참고.PNG', 'm,kj', '120', '2019-07-22 07:16:46', 'true', 'official'),
(7, 'test', '1564051753img_opening.jpg', '김감독', '100', '2019-07-25 10:49:13', 'false', 'official'),
(8, '영화3', '1564105228img_opening2.jpg', 'ㅁㄴㅇ', '460', '2019-07-26 01:40:28', 'true', 'official'),
(9, 'BB영화', '156411074323rd_poster.jpg', 'qwe', '40', '2019-07-26 03:12:23', 'true', 'official'),
(10, 'AA영화', '156411075622nd_poster.jpg', 'qwe', '160', '2019-07-26 03:12:36', 'true', 'official'),
(11, '영화5', '1564121957181004_054.gif', '영화', '100', '2019-07-26 06:19:17', 'true', 'official');

-- --------------------------------------------------------

--
-- 테이블 구조 `requestmov`
--

CREATE TABLE `requestmov` (
  `idx` int(11) NOT NULL,
  `company_name` text COLLATE utf8_bin NOT NULL,
  `busniess_num` text COLLATE utf8_bin NOT NULL,
  `company_email` text COLLATE utf8_bin NOT NULL,
  `company_num` text COLLATE utf8_bin NOT NULL,
  `mov_name` text COLLATE utf8_bin NOT NULL,
  `pd_name` text COLLATE utf8_bin NOT NULL,
  `running_time` text COLLATE utf8_bin NOT NULL,
  `mov_poster` text COLLATE utf8_bin NOT NULL,
  `mov_case` text COLLATE utf8_bin NOT NULL,
  `confirm_case` text COLLATE utf8_bin NOT NULL,
  `movie_type` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 테이블의 덤프 데이터 `requestmov`
--

INSERT INTO `requestmov` (`idx`, `company_name`, `busniess_num`, `company_email`, `company_num`, `mov_name`, `pd_name`, `running_time`, `mov_poster`, `mov_case`, `confirm_case`, `movie_type`) VALUES
(1, '네네네', '123-46-78988', 'asd@asd.com', '010-8979-9355', '수학의정석', '기능인', '50', '15636880561503647939.jpg', '승인', 'true', 'request'),
(2, '갓영화', '034-23-23456', 'qwe@qwe.com', '010-5467-2580', '갓기능인', '김감독', '234', '15636884281503920422.jpg', '승인', 'true', 'request'),
(3, 'asd', '123-12-12345', 'qwe@qwe.com', '010-5467-2580', 'testestest', '123123', '123', '1563779692device repairs 참고.PNG', '대기', 'false', 'request'),
(4, 'test', '123-12-12345', 'qwe@qwe.com', '010-1234-1234', 'test2', '김감독', '100', '1564052057img_opening.jpg', '반려', 'false', 'request'),
(5, 'movies', '123-12-12345', 'qwe@qwe.com', '010-1234-5678', 'CC영화', '김감독', '280', '15641878851505521644.jpg', '승인', 'false', 'request');

-- --------------------------------------------------------

--
-- 테이블 구조 `sponsor`
--

CREATE TABLE `sponsor` (
  `idx` int(11) NOT NULL,
  `sponsor_name` text COLLATE utf8_bin NOT NULL,
  `support_price` text COLLATE utf8_bin NOT NULL,
  `sponsor_logo` text COLLATE utf8_bin NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 테이블의 덤프 데이터 `sponsor`
--

INSERT INTO `sponsor` (`idx`, `sponsor_name`, `support_price`, `sponsor_logo`, `register_date`) VALUES
(6, 'ioio', '5000000', '1563688484181004_246.jpg', '2019-07-21 05:54:44'),
(7, 'qweqwe', '90000000', '1563688500img_venues_02.jpg', '2019-07-21 05:55:00'),
(8, 'asd', '10000000', '1564051793img_opening.jpg', '2019-07-25 10:49:53'),
(9, 'test', '1000000', '1564051813181007.jpg', '2019-07-25 10:50:13');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `cinema`
--
ALTER TABLE `cinema`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `moviebuy`
--
ALTER TABLE `moviebuy`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `movtime`
--
ALTER TABLE `movtime`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `officialmov`
--
ALTER TABLE `officialmov`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `requestmov`
--
ALTER TABLE `requestmov`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `cinema`
--
ALTER TABLE `cinema`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `moviebuy`
--
ALTER TABLE `moviebuy`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `movtime`
--
ALTER TABLE `movtime`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- 테이블의 AUTO_INCREMENT `officialmov`
--
ALTER TABLE `officialmov`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 테이블의 AUTO_INCREMENT `requestmov`
--
ALTER TABLE `requestmov`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `sponsor`
--
ALTER TABLE `sponsor`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

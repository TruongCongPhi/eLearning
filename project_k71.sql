-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 16, 2023 lúc 05:44 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project_k71`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_name` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer_name`, `is_correct`) VALUES
(93, 33, '1234', 0),
(94, 33, '12', 1),
(95, 34, '1', 0),
(96, 34, '2', 1),
(97, 34, '3', 1),
(99, 36, '1', 0),
(100, 36, '2', 1),
(101, 37, 'phi', 1),
(102, 38, '1', 1),
(103, 38, '2', 0),
(104, 39, '3', 1),
(105, 39, '4', 0),
(106, 40, '434', 0),
(107, 40, '34t3', 1),
(108, 41, '434', 0),
(109, 41, '34t3', 1),
(110, 42, '434', 0),
(111, 42, '34t3', 1),
(112, 43, '434', 0),
(113, 43, '34t3', 1),
(114, 44, 'fdh', 1),
(115, 44, 'fh', 0),
(116, 44, 'fdh', 0),
(117, 44, 'dfh', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `course_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `course_title`, `course_desc`) VALUES
(35, 'Công nghệ web', 'Đây là mô tả khóa học\r\n'),
(37, 'Quản trị mạng', 'mô tả');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_management`
--

CREATE TABLE `course_management` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `course_management`
--

INSERT INTO `course_management` (`id`, `course_id`, `username`, `created_at`, `role`) VALUES
(12, 35, 'tk1', '2023-12-13 17:00:00', 0),
(22, 35, 'tk2', '2023-12-14 03:33:49', 0),
(32, 37, 'tk2', '2023-12-14 16:01:24', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_quizz`
--

CREATE TABLE `history_quizz` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `score` float NOT NULL,
  `time_begin` varchar(50) NOT NULL,
  `time_finish` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lecture_title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lectures`
--

INSERT INTO `lectures` (`id`, `course_id`, `lecture_title`, `status`) VALUES
(169, 35, 'Tuần 1', 1),
(184, 35, 'Tuần 2', 0),
(185, 35, 'Tuần 3', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lecture_questions`
--

CREATE TABLE `lecture_questions` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `question_name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `added_by` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lecture_questions`
--

INSERT INTO `lecture_questions` (`id`, `lecture_id`, `question_name`, `image`, `level`, `type`, `status`, `added_by`, `created_at`) VALUES
(33, 169, 'abc', '', 1, 'single_choice', 1, 'admin', '2023-12-14 14:47:33'),
(34, 169, 'sdfdsf', '', 1, 'multiplechoice', 1, 'admin', '2023-12-14 14:47:47'),
(36, 184, 'hihih', '', 1, 'single_choice', 1, 'admin', '2023-12-15 11:01:04'),
(37, 169, 'dgsgsghsdg', '', 1, 'fill', 1, 'admin', '2023-12-15 11:52:22'),
(38, 169, 'hhi', '', 1, 'single_choice', 1, 'admin', '2023-12-15 14:24:37'),
(39, 169, 'hhirehrfh', '', 1, 'single_choice', 1, 'admin', '2023-12-15 14:24:45'),
(40, 169, 'hhirehrfhrheh', '', 1, 'single_choice', 1, 'admin', '2023-12-15 14:24:52'),
(41, 169, 'hhirehrfhrheh', '', 1, 'single_choice', 1, 'admin', '2023-12-15 14:24:53'),
(42, 169, 'hhirehrfhrheh', '', 1, 'single_choice', 1, 'admin', '2023-12-15 14:24:54'),
(43, 169, 'hhirehrfhrheh', '', 1, 'single_choice', 1, 'admin', '2023-12-15 14:24:55'),
(44, 169, 'tdry', '', 1, 'single_choice', 1, 'admin', '2023-12-15 14:25:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `material_title` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `position` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `materials`
--

INSERT INTO `materials` (`id`, `lecture_id`, `material_title`, `type`, `path`, `status`, `position`) VALUES
(73, 169, 'bài giảng 1', 'pdf', '../uploads/Yeu cau thuc hanh(1).pdf', 1, 3),
(80, 169, 'bg2', 'pdf', '../uploads/Yeu cau thuc hanh(3).pdf', 1, 4),
(81, 169, 'Quizz', 'quizz', NULL, 1, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin', 'c4ca4238a0b923820dcc509a6f75849b', 2),
('tk1', 'c4ca4238a0b923820dcc509a6f75849b', 0),
('tk2', 'c4ca4238a0b923820dcc509a6f75849b', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `course_management`
--
ALTER TABLE `course_management`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `username_id` (`username`);

--
-- Chỉ mục cho bảng `history_quizz`
--
ALTER TABLE `history_quizz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_quizz_ibfk_1` (`lecture_id`),
  ADD KEY `history_quizz_ibfk_2` (`username`);

--
-- Chỉ mục cho bảng `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `lecture_questions`
--
ALTER TABLE `lecture_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lecture_id` (`lecture_id`);

--
-- Chỉ mục cho bảng `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lecture_id` (`lecture_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `course_management`
--
ALTER TABLE `course_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `history_quizz`
--
ALTER TABLE `history_quizz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT cho bảng `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT cho bảng `lecture_questions`
--
ALTER TABLE `lecture_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `lecture_questions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `course_management`
--
ALTER TABLE `course_management`
  ADD CONSTRAINT `course_management_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_management_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lectures`
--
ALTER TABLE `lectures`
  ADD CONSTRAINT `lectures_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lecture_questions`
--
ALTER TABLE `lecture_questions`
  ADD CONSTRAINT `lecture_questions_ibfk_1` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

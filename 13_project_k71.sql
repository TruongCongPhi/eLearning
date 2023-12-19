-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 19, 2023 lúc 01:11 PM
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
-- Cơ sở dữ liệu: `13_project_k71`
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
(137, 55, '1', 0),
(138, 55, '2', 1),
(139, 56, '1', 0),
(140, 56, '3', 1),
(141, 57, '1', 0),
(142, 57, '4', 1),
(143, 58, '1', 0),
(144, 58, '4', 1),
(145, 58, '3', 1),
(146, 59, '1', 0),
(147, 59, '4', 1),
(148, 59, '3', 1),
(149, 60, '1', 0),
(150, 60, '4', 1),
(151, 60, '3', 1),
(152, 61, 'chó', 1),
(153, 62, 'chó', 1),
(154, 63, 'chó', 1),
(155, 64, 'chó', 1),
(156, 65, 'chó', 1),
(157, 66, 'h', 1),
(158, 66, 'nl', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assignment_files`
--

CREATE TABLE `assignment_files` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `course_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `course_management`
--

INSERT INTO `course_management` (`id`, `course_id`, `username`, `created_at`, `role`) VALUES
(12, 35, 'tk1', '2023-12-13 17:00:00', 1),
(37, 35, 'tk2', '2023-12-18 13:15:21', 0),
(38, 37, 'tk1', '2023-12-18 13:29:13', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_quizz`
--

CREATE TABLE `history_quizz` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `score` float NOT NULL,
  `time_begin` datetime NOT NULL,
  `time_finish` datetime DEFAULT NULL
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
(184, 35, 'Tuần 2', 0);

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
(55, 169, '1+1 =', '', 1, 'single_choice', 1, 'admin', '2023-12-17 09:03:54'),
(56, 169, '1+2 =', '', 1, 'single_choice', 1, 'admin', '2023-12-17 09:04:00'),
(57, 169, '1+3 =', '', 1, 'single_choice', 1, 'admin', '2023-12-17 09:04:05'),
(58, 169, '1+1 <', '', 1, 'multiplechoice', 1, 'admin', '2023-12-17 09:04:39'),
(59, 169, '1+1 <', '', 1, 'multiplechoice', 1, 'admin', '2023-12-17 09:04:42'),
(60, 169, '1+1 <', '', 1, 'multiplechoice', 0, 'admin', '2023-12-17 09:04:44'),
(61, 169, 'con gì', '', 1, 'fill', 0, 'admin', '2023-12-17 09:04:57'),
(62, 169, 'con gì', '', 1, 'fill', 0, 'admin', '2023-12-17 09:04:58'),
(63, 169, 'con gì', '', 1, 'fill', 0, 'admin', '2023-12-17 09:04:58'),
(64, 169, 'con gì', '', 1, 'fill', 0, 'admin', '2023-12-17 09:04:58'),
(65, 169, 'con gì', '', 1, 'fill', 0, 'admin', '2023-12-17 09:04:59'),
(66, 169, 'hihi', '', 1, 'multiplechoice', 0, 'tk1', '2023-12-18 05:52:30');

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
  `position` tinyint(4) NOT NULL,
  `time_finish` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `materials`
--

INSERT INTO `materials` (`id`, `lecture_id`, `material_title`, `type`, `path`, `status`, `position`, `time_finish`) VALUES
(125, 169, 'đg', 'assignment', NULL, 0, 8, '2023-12-20 12:30:00'),
(129, 169, 'bài giảng 1', 'pdf', '../uploads/Kết Quả Đăng Ký.pdf', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `submitted_assignments`
--

CREATE TABLE `submitted_assignments` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `time_submission` datetime NOT NULL,
  `path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', 2),
(2, 'tk1', 'c20ad4d76fe97759aa27a0c99bff6710', 1),
(3, 'tk2', 'c4ca4238a0b923820dcc509a6f75849b', 0);

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
-- Chỉ mục cho bảng `assignment_files`
--
ALTER TABLE `assignment_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_files_ibfk_1` (`material_id`);

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
-- Chỉ mục cho bảng `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`material_id`),
  ADD KEY `username` (`username`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT cho bảng `assignment_files`
--
ALTER TABLE `assignment_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT cho bảng `course_management`
--
ALTER TABLE `course_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `history_quizz`
--
ALTER TABLE `history_quizz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT cho bảng `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT cho bảng `lecture_questions`
--
ALTER TABLE `lecture_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT cho bảng `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `lecture_questions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `assignment_files`
--
ALTER TABLE `assignment_files`
  ADD CONSTRAINT `assignment_files_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `course_management`
--
ALTER TABLE `course_management`
  ADD CONSTRAINT `course_management_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_management_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `history_quizz`
--
ALTER TABLE `history_quizz`
  ADD CONSTRAINT `history_quizz_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_quizz_ibfk_2` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE;

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

--
-- Các ràng buộc cho bảng `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD CONSTRAINT `submitted_assignments_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submitted_assignments_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

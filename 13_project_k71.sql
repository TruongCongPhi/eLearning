-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 12, 2024 lúc 05:41 PM
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
(213, 87, '1', 1),
(214, 87, '2', 0),
(215, 88, '1', 1),
(216, 88, '2', 0),
(217, 89, '1', 1),
(218, 89, '2', 0),
(219, 90, '1', 1),
(220, 90, '2', 1),
(221, 90, '3', 0),
(222, 90, '4', 0),
(223, 91, '1', 1),
(224, 91, '2', 1),
(225, 91, '3', 0),
(226, 91, '4', 0),
(227, 92, '1', 1),
(228, 92, '2', 0),
(229, 93, '1', 1),
(230, 93, '2', 1),
(231, 94, '1', 1),
(232, 94, '2', 1),
(233, 95, '1', 1),
(234, 95, '2', 1),
(235, 96, 'phi', 1),
(236, 97, 'phifes', 1),
(237, 98, 'phifes', 1),
(238, 99, 'f', 1),
(239, 100, 'f', 1),
(240, 101, 'f', 1),
(245, 103, '1', 0),
(246, 103, '2', 0),
(247, 103, '3', 1),
(248, 103, '4', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assignment_files`
--

CREATE TABLE `assignment_files` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `assignment_files`
--

INSERT INTO `assignment_files` (`id`, `material_id`, `path`) VALUES
(33, 153, '../uploads/715105178_Trương Công Phi(1).docx'),
(34, 153, '../uploads/dd(1).png');

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
(12, 35, 'tk1', '2023-12-13 17:00:00', 0),
(53, 35, 'tk2', '2023-12-20 13:40:19', 1),
(54, 35, '715105100', '2023-12-20 13:40:24', 0),
(55, 35, '715105101', '2023-12-20 13:40:29', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `custom_quizz`
--

CREATE TABLE `custom_quizz` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `quizz_id` int(11) NOT NULL,
  `count_lv1` int(11) NOT NULL,
  `count_lv2` int(11) NOT NULL,
  `count_lv3` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_quizz`
--

CREATE TABLE `history_quizz` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `score` float NOT NULL,
  `id_question_quizz` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`id_question_quizz`)),
  `answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
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
(188, 35, 'Tuần 2', 0);

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
(87, 169, 'dễ', '', 1, 'single_choice', 1, 'admin', '2024-01-09 14:12:10'),
(88, 169, 'dễ2', '', 1, 'single_choice', 1, 'admin', '2024-01-09 14:12:42'),
(89, 169, 'dễ3', '', 1, 'single_choice', 1, 'admin', '2024-01-09 14:12:47'),
(90, 169, 'dễ4', '', 1, 'multiplechoice', 1, 'admin', '2024-01-09 14:13:08'),
(91, 169, 'dễ5', '', 1, 'multiplechoice', 1, 'admin', '2024-01-09 14:13:17'),
(92, 169, 'vua1', '', 2, 'multiplechoice', 1, 'admin', '2024-01-09 14:13:38'),
(93, 169, 'vua2', '', 2, 'multiplechoice', 1, 'admin', '2024-01-09 14:13:45'),
(94, 169, 'vua3', '', 2, 'multiplechoice', 1, 'admin', '2024-01-09 14:13:48'),
(95, 169, 'vua4', '', 2, 'multiplechoice', 1, 'admin', '2024-01-09 14:13:52'),
(96, 169, 'vua1', '', 2, 'fill', 1, 'admin', '2024-01-09 14:14:11'),
(97, 169, 'vua2', '', 2, 'fill', 1, 'admin', '2024-01-09 14:14:19'),
(98, 169, 'kho1', '', 3, 'fill', 1, 'admin', '2024-01-09 14:14:27'),
(99, 169, 'kho2', '', 3, 'fill', 1, 'admin', '2024-01-09 14:14:32'),
(100, 169, 'kho3', '', 3, 'fill', 1, 'admin', '2024-01-09 14:14:34'),
(101, 169, 'kho4', '', 3, 'fill', 1, 'admin', '2024-01-09 14:14:38'),
(103, 169, 'kho5', '', 3, 'single_choice', 1, 'admin', '2024-01-09 14:14:55');

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
  `time_finish` datetime DEFAULT NULL,
  `count_quizz` int(11) DEFAULT NULL,
  `time_quizz` int(11) DEFAULT NULL,
  `count_questions` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `materials`
--

INSERT INTO `materials` (`id`, `lecture_id`, `material_title`, `type`, `path`, `status`, `position`, `time_finish`, `count_quizz`, `time_quizz`, `count_questions`) VALUES
(148, 169, 'slide', 'pdf', '../uploads/BG Tuần 2 - Kỹ thuật PTTT (up cst).pdf', 0, 1, NULL, NULL, NULL, 0),
(149, 169, 'word', 'word', '../uploads/715105178_Trương Công Phi.docx', 1, 2, NULL, NULL, NULL, 0),
(150, 169, 'link', 'link', 'http://daotao.hnue.edu.vn/', 1, 3, NULL, NULL, NULL, 0),
(153, 169, 'btvn', 'assignment', NULL, 1, 5, '2023-12-25 20:00:00', NULL, NULL, 0),
(157, 169, 'Quizz', 'quizz', NULL, 1, 6, NULL, 5, 5, 10);

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
(2, 'tk1', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(13, 'tk2', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(14, 'tk3', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(15, '715105100', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(16, '715105101', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(17, '715105102', 'c4ca4238a0b923820dcc509a6f75849b', 0);

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
-- Chỉ mục cho bảng `custom_quizz`
--
ALTER TABLE `custom_quizz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `quizz_id` (`quizz_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT cho bảng `assignment_files`
--
ALTER TABLE `assignment_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT cho bảng `course_management`
--
ALTER TABLE `course_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `custom_quizz`
--
ALTER TABLE `custom_quizz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `history_quizz`
--
ALTER TABLE `history_quizz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;

--
-- AUTO_INCREMENT cho bảng `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT cho bảng `lecture_questions`
--
ALTER TABLE `lecture_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT cho bảng `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT cho bảng `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- Các ràng buộc cho bảng `custom_quizz`
--
ALTER TABLE `custom_quizz`
  ADD CONSTRAINT `custom_quizz_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_quizz_ibfk_2` FOREIGN KEY (`quizz_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

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

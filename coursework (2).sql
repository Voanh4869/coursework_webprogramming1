-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 08:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coursework`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment_text`, `created_at`) VALUES
(1, 1, 2, 'You can use PDO and prepared statements to connect securely.', '2025-03-11 14:52:45'),
(3, 3, 3, 'To prevent SQL Injection, always use prepared statements.', '2025-03-11 14:52:45'),
(7, 16, 10, 'test', '2025-03-25 07:01:53'),
(10, 16, 1, 'adjnfdbjdfss', '2025-04-01 10:07:45'),
(12, 16, 2, 'hello', '2025-04-23 15:18:03'),
(13, 34, 2, 'test', '2025-04-23 16:23:08'),
(16, 34, 1, 'fbfbfbf', '2025-04-24 13:05:21'),
(17, 34, 1, 'fbdadfb', '2025-04-24 13:05:28'),
(19, 34, 5, 'Hello', '2025-04-25 12:46:06'),
(21, 37, 20, 'Hello\r\nI\'m a new user here', '2025-04-27 03:15:21'),
(22, 37, 1, 'Hello Matty \r\nWelcome to Student Forum', '2025-04-27 06:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `created_at`) VALUES
(1, 'Web Development', '2025-03-11 14:52:00'),
(2, 'Database Systems', '2025-03-11 14:52:00'),
(3, 'Artificial Intelligence', '2025-03-11 14:52:00'),
(4, 'User Interface Design', '2025-03-20 07:58:44'),
(12, 'Project', '2025-04-23 13:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `imgFromStr` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `module_id`, `title`, `content`, `imgFromStr`, `created_at`) VALUES
(1, 1, 1, 'How do I connect PHP to MySQL?', 'I need help connecting PHP to MySQL using PDO.', 'chicken.jpg', '2025-03-11 14:52:29'),
(3, 1, 2, 'How to prevent SQL Injection?', 'I want to make sure my queries are safe from SQL injection.', 'Screenshot 2025-04-26 110258.png', '2025-03-11 14:52:29'),
(16, 10, 12, 'Project manager', 'Where could I find new idea project?       ', 'Screenshot 2025-04-26 110506.png', '2025-03-20 07:38:06'),
(34, 2, 1, 'HTML CSS JS', 'What should I do to be good at programming language?', 'Screenshot 2025-04-26 110628.png', '2025-04-23 14:34:09'),
(37, 5, 2, 'Data ', 'I\'m major at Database first year. Where should I begin?', 'Screenshot 2025-04-26 110258.png', '2025-04-25 12:45:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','student') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'voanh', 'anh862307@gmail.com', '$2y$10$mLVMZ57/b4YptEKLkazB5.vP2wJwHVvAY00/uXJlGHFvWag/ug3.O', 'admin', '2025-03-11 14:50:53'),
(2, 'jane', 'jane@gmail.com', '$2y$10$EqQM/b4oeppWIntSIAR4nefrNZEqhGeHZhKbaJzgFmEFbdlDqYgou', 'student', '2025-03-11 14:50:53'),
(3, 'jake', 'jake@gmail.com', '$2y$10$5Nf5f9598Z8CQAOcTBxDd.lHKuJ/du5WS2zCm7n7G7TmVreRYIXIC', 'student', '2025-03-11 14:50:53'),
(5, 'voanh0925', 'votuananh0925@gmail.com', '$2y$10$hqIGWz9Mc5joPTEreEAopuhMFwwipYpx5vZEZC7F7fphH3cNwykti', 'student', '2025-03-18 06:58:07'),
(10, 'Skywalker', 'luke@example.com', '$2y$10$9Mq/5UiSPU8dtRZ94U1h9Ocmri0n/KPbazeUTd1AfR3Mzq2NSkHfK', 'student', '2025-03-20 07:38:06'),
(14, 'voanh@', 'voanh1010@gmail.com', '$2y$10$8XfaygqMoUbtxKyBaFSX9eQuw1DMUrh4csboaV30OrIpfitCN9fDi', 'student', '2025-04-02 07:17:01'),
(20, 'Matty', 'matthias@example.com', '$2y$10$VXNgqCkWI91vPSvELHydMOEyMCz.VezKnJ2mpCxmodIX0GqWVYT.m', 'student', '2025-04-26 17:43:25'),
(22, 'odin', 'odin@example.com', '$2y$10$GKDBsSGFf2zApr3Q/o/WJuxEvtc8GYMhR0OcC0uDQq1fScOEdRWuO', 'student', '2025-04-27 03:29:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `posts_ibfk_2` (`module_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

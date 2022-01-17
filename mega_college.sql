-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2022 at 08:07 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mega_college`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us_master`
--

CREATE TABLE `about_us_master` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `about_us_master`
--

INSERT INTO `about_us_master` (`id`, `title`, `description`, `featured_image`, `route`, `is_active`) VALUES
(5, 'Academic International College', '<p>Thames is more than just a place where you come to study for your degree. It is a community of students and faculty from diverse background coming together with a common belief that learning is a lifelong process. On one hand, you will always find being pushed to take responsibility of your own learning while on the other hand you will be encouraged to question, challenge and critically reflect both in and outside the classroom.</p>\r\n', '4530a-image_1620896252.jpg', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `academic_partner`
--

CREATE TABLE `academic_partner` (
  `id` int(50) NOT NULL,
  `partner_name` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `academic_partner`
--

INSERT INTO `academic_partner` (`id`, `partner_name`, `logo`) VALUES
(1, 'Abc', 'ceec6-1.jpg'),
(2, 'cde', '3bd62-2.jpg'),
(3, 'efg', '8145c-3.jpg'),
(4, 'asdds', '3f5d5-4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `admission_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admission_info`
--

CREATE TABLE `admission_info` (
  `info_id` int(11) NOT NULL,
  `description` int(11) NOT NULL,
  `featured_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `certificate_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `featured_image` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `counsellors`
--

CREATE TABLE `counsellors` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `featured_image` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `email_config_setting`
--

CREATE TABLE `email_config_setting` (
  `id` int(50) NOT NULL,
  `host_name` varchar(50) NOT NULL,
  `port` int(10) NOT NULL,
  `email_from` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(50) NOT NULL,
  `event_date` date NOT NULL,
  `location` varchar(50) NOT NULL,
  `featured_image` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `event_category_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_date`, `location`, `featured_image`, `description`, `event_category_id`) VALUES
(1, '2022-01-01', '', '080ae-1.jpg', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge. Pellentese turpis dignissim amet area ducation process facilitating Knowledge. Pellentese turpis dignissim amet area ducation.</p>\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_category`
--

CREATE TABLE `event_category` (
  `event_category_id` int(50) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `featured_image` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_category`
--

INSERT INTO `event_category` (`event_category_id`, `category_name`, `featured_image`, `is_active`) VALUES
(1, 'IT', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `featured_image` varchar(150) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `lecturer_id` int(50) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `featured_image` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `description` varchar(100) NOT NULL,
  `qualification` text NOT NULL,
  `designation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`lecturer_id`, `full_name`, `featured_image`, `email_address`, `phone_number`, `description`, `qualification`, `designation`) VALUES
(3, 'Mike Hussy', 'f0b9c-7.jpg', 'mike@gmail.com', '0122211100', '', '<p>test</p>\n', 'Senior programmer'),
(4, 'Daziy Millar', 'af543-18.jpg', 'dazy@gmail.com', '0406624593', '', '<p>askaj</p>\n', 'Senior Finance Lecturer'),
(5, 'Essy Rojario', '2a011-16.jpg', 'essy@gmail.com', '0406624593', '', '<p>abcd</p>\n', 'Senior Account Lecturer'),
(6, 'David Lipu', '4c6ff-5.jpg', 'david@gmail.com', '0406624593', '', '<p>ajhasj</p>\n', 'Senior Java Lecturer'),
(7, 'Tom Steven', 'a63cd-15.jpg', 'tom@email.com', '0406624593', '', '<p>hashasha</p>\n', 'PHP Tutor'),
(8, 'PAWAN BK', 'a0fe8-student3.jpg', 'shiwanbk@gmail.com', '0406624593', '', '<p><input name=\"facebook\" type=\"checkbox\" value=\"faceboo.com\" /></p>\n', 'developer');

-- --------------------------------------------------------

--
-- Table structure for table `menu_master`
--

CREATE TABLE `menu_master` (
  `menu_id` int(11) NOT NULL,
  `menu_code` varchar(255) DEFAULT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_index` int(11) DEFAULT NULL,
  `menu_type` enum('inner','outer') DEFAULT NULL,
  `pre_menu_id` int(11) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `icon_class` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_deleted_remarks` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `menu_master`
--

INSERT INTO `menu_master` (`menu_id`, `menu_code`, `menu_name`, `menu_index`, `menu_type`, `pre_menu_id`, `is_active`, `icon_class`, `route`, `created_date`, `created_by`, `modified_deleted_remarks`, `modified_by`, `modified_date`) VALUES
(1, 'courseManagement', 'Course Management', 1, 'outer', 0, 'Y', 'bx bx-book', 'javascript:', '2022-01-09 06:32:42', 1, 'position modified', '1', '2022-01-10 10:48:31'),
(2, 'categoryList', 'Category List', 0, 'outer', 1, 'Y', NULL, 'App/courseCategoryList', '2022-01-09 06:47:05', 1, NULL, NULL, NULL),
(3, 'courseList', 'Course List', 1, 'outer', 1, 'Y', NULL, 'App/courseList', '2022-01-09 06:53:40', 1, NULL, NULL, NULL),
(4, 'masterSetting', 'Master Setting', 10, 'outer', 0, 'Y', 'bx bx-cog', 'javascript:', '2022-01-09 07:13:54', 1, 'position modified', '1', '2022-01-11 12:01:29'),
(5, 'siteSetup', 'Site Setup', 1, 'outer', 4, 'Y', 'asdas', 'App/siteSetting/edit/1', '2022-01-09 07:14:47', 1, 'icon changes', '1', '2022-01-09 13:04:08'),
(6, 'socialSite', 'Social Site Setup', 2, 'outer', 4, 'Y', 'adaa', 'App/socialSite', '2022-01-09 07:22:38', 1, 'title modified', '1', '2022-01-09 13:16:10'),
(7, 'mailConfig', 'Mail Configuration', 3, 'outer', 4, 'Y', 'aaaa', 'App/emailConfig/edit/1', '2022-01-09 07:29:56', 1, 'route modified', '1', '2022-01-09 13:15:32'),
(8, 'EventManagement', 'Event Management', 1, 'outer', 0, 'Y', 'bx bxs-calendar-event', 'javascript:', '2022-01-09 07:33:56', 1, NULL, NULL, NULL),
(9, 'eventCategoryList', 'Category List', 1, 'outer', 8, 'Y', 'aaaa', 'App/eventCategoryList', '2022-01-09 07:34:53', 1, 'title modified', '1', '2022-01-09 13:20:28'),
(10, 'eventList', 'Event List', 2, 'outer', 8, 'Y', 'aaaa', 'App/eventList', '2022-01-09 07:37:47', 1, 'title modified', '1', '2022-01-09 13:25:33'),
(11, 'mailManagement', 'Inbox Management', 2, 'outer', 0, 'Y', 'bx bx-message', 'javascript:', '2022-01-09 07:46:12', 1, 'icon changes', '1', '2022-01-09 14:58:18'),
(12, 'mailList', 'Mail List', 1, 'outer', 11, 'Y', NULL, 'App/mailList', '2022-01-09 07:48:05', 1, NULL, NULL, NULL),
(13, 'userManagement', 'User Management', 4, 'outer', 0, 'Y', 'bx bx-user-pin', 'javascript:', '2022-01-09 07:54:14', 1, NULL, NULL, NULL),
(14, 'userList', 'User List', 1, 'outer', 13, 'Y', NULL, 'App/userManagement', '2022-01-09 07:54:54', 1, NULL, NULL, NULL),
(15, 'newsM', 'News Management', 4, 'outer', 0, 'Y', 'bx bx-news', 'javascript:', '2022-01-09 08:05:02', 1, NULL, NULL, NULL),
(16, 'newsCategory', 'Category List', 1, 'outer', 15, 'Y', NULL, 'App/newsCategoryList', '2022-01-09 08:05:51', 1, NULL, NULL, NULL),
(17, 'newsList', 'News', 2, 'outer', 15, 'Y', NULL, 'App/news', '2022-01-09 08:07:47', 1, NULL, NULL, NULL),
(18, 'researchManagement', 'Research Management', 5, 'outer', 0, 'Y', 'bx bx-test-tube', 'javascript:', '2022-01-09 08:46:03', 1, NULL, NULL, NULL),
(19, 'researchCategory', 'Category List', 1, 'outer', 18, 'Y', NULL, 'App/reseachCategoryList', '2022-01-09 08:46:55', 1, NULL, NULL, NULL),
(20, 'researchList', 'Research List', 2, 'outer', 18, 'Y', NULL, 'App/researchList', '2022-01-09 08:49:04', 1, NULL, NULL, NULL),
(21, 'bannerManagement', 'Banner Management', 6, 'outer', 0, 'Y', 'bx bx-photo-album', 'javascript:', '2022-01-09 08:58:02', 1, 'icon changes', '1', '2022-01-09 14:48:48'),
(22, 'bannerList', 'Banner List', 1, 'outer', 21, 'Y', NULL, 'App/bannerList', '2022-01-09 08:59:11', 1, NULL, NULL, NULL),
(23, 'lecturerList', 'Lecturers', 3, 'outer', 13, 'Y', 'bx bx-user-check', 'App/lecturers', '2022-01-09 09:15:36', 1, 'position modified', '1', '2022-01-11 12:58:28'),
(24, 'studentList', 'Student List', 3, 'outer', 13, 'Y', NULL, 'App/students', '2022-01-09 09:16:21', 1, NULL, NULL, NULL),
(25, 'assignLecturer', 'Assign Lecturer', 3, 'outer', 1, 'Y', NULL, 'App/courseLecturer', '2022-01-09 09:26:02', 1, NULL, NULL, NULL),
(26, 'galleryManagement', 'Gallery Management', 7, 'outer', 0, 'Y', 'bx bx-images', 'javascript:', '2022-01-09 09:53:00', 1, NULL, NULL, NULL),
(27, 'galleryList', 'Gallery List', 1, 'outer', 26, 'Y', NULL, 'App/gallery', '2022-01-09 09:53:52', 1, NULL, NULL, NULL),
(28, 'aboutUs', 'About Us', 0, 'outer', 0, 'Y', 'bx bxs-info-circle', 'javascript:', '2022-01-10 05:03:18', 1, NULL, NULL, NULL),
(29, 'aboutManagement', 'About Us Management', 1, 'outer', 28, 'Y', NULL, 'App/aboutUs', '2022-01-10 05:04:19', 1, NULL, NULL, NULL),
(30, 'partnerManagement', 'Academic Partner', 2, 'outer', 28, 'Y', 'asdasa', 'App/academicPartner', '2022-01-10 06:43:54', 1, 'asaws', '1', '2022-01-10 12:29:20'),
(31, 'testimonialM', 'Testimonial List', 9, 'outer', 0, 'Y', 'bx bx-comment', 'javascript:', '2022-01-11 06:16:16', 1, 'title modified', '1', '2022-01-11 12:06:08'),
(32, 'testinomials', 'Testinomials', 1, 'outer', 31, 'Y', 'scasasa', 'App/testimonialList', '2022-01-11 06:17:28', 1, 'position modified', '1', '2022-01-11 12:06:21'),
(33, 'lecturers', 'Lecturers', 1, 'outer', 23, 'Y', NULL, 'App/lecturers', '2022-01-11 07:11:30', 1, NULL, NULL, NULL),
(34, 'socialLinks', 'Social Links', 2, 'outer', 23, 'Y', 'sdsdddsd', 'App/lecturerSocialLinks', '2022-01-11 07:12:31', 1, 'position modified', '1', '2022-01-11 13:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `notice_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `featured_image` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `featured_image` varchar(200) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `program_description`
--

CREATE TABLE `program_description` (
  `description_id` int(11) NOT NULL,
  `program_detail_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `program_detail`
--

CREATE TABLE `program_detail` (
  `program_detail_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `position` int(10) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `program_lecturer`
--

CREATE TABLE `program_lecturer` (
  `id` int(50) NOT NULL,
  `lecturer_id` int(50) NOT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program_lecturer`
--

INSERT INTO `program_lecturer` (`id`, `lecturer_id`, `program_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `program_video`
--

CREATE TABLE `program_video` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `research`
--

CREATE TABLE `research` (
  `research_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `featured_image` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_data`
--

CREATE TABLE `site_data` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `data` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_setting`
--

CREATE TABLE `site_setting` (
  `site_id` int(50) NOT NULL,
  `site_name` varchar(20) NOT NULL,
  `site_logo` varchar(100) NOT NULL,
  `fav_icon` varchar(50) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `email_address` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_setting`
--

INSERT INTO `site_setting` (`site_id`, `site_name`, `site_logo`, `fav_icon`, `phone_number`, `email_address`, `address`) VALUES
(1, 'School college', 'd3452-logo-primary.png', 'cfe27-favicon.png', '0145552210', 'school@info.com', 'kathmandu,Nepal');

-- --------------------------------------------------------

--
-- Table structure for table `site_social_link`
--

CREATE TABLE `site_social_link` (
  `social_link_id` int(50) NOT NULL,
  `social_link` varchar(50) NOT NULL,
  `link_icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slider_id` int(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `featured_image` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `title`, `description`, `featured_image`, `link`) VALUES
(1, 'Best Education for Html template', 'loreaadkjajhsdxasd andhjahda ahsdafkcajdc', '86846-4.jpg', ''),
(2, 'Best PhP courses', '', '65e3e-1.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `featured_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `full_name`, `email_address`, `phone_number`, `featured_image`) VALUES
(2, 'Rosy Janner', 'rosy@gmail.com', '0154789141', '33fb2-3.jpg'),
(3, 'Mike Hussy', 'mike@gmail.com', '0406624593', 'b995b-10.jpg'),
(4, 'Daziy Millar', 'dazi@gmail.com', '0406624593', 'eb9e8-9.jpg'),
(5, 'Luice Nishaa', 'luice@email.com', '012378964', 'ce986-8.jpg'),
(6, 'Tom Steven', 'tom@email.com', '0406624593', 'e079a-5.jpg'),
(7, 'Lubna', 'lubna@gmail.com', '980123657', 'b3cf7-12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `featured_image` varchar(200) NOT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `description`, `featured_image`, `program_id`) VALUES
(1, 'Danial Dina', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge.</p>\r\n', 'de9f3-1.jpg', 0),
(2, 'Pawan bk', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge.</p>\r\n', 'daf04-1.jpg', 0),
(3, 'Sijan pathak', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge. Pellentese turpis dignissim amet area ducation process facilitating Knowledge.</p>\r\n', 'b4571-1.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE `user_auth` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `is_locked_flag` enum('Locked','Not-Locked') NOT NULL DEFAULT 'Not-Locked',
  `is_active` enum('Active','Not-Active') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`user_id`, `full_name`, `email`, `pass`, `is_locked_flag`, `is_active`) VALUES
(2, 'pawan bk', 'info@globalhelpfoundation.org.np', '21232f297a57a5a743894a0e4a801fc3', 'Not-Locked', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us_master`
--
ALTER TABLE `about_us_master`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `academic_partner`
--
ALTER TABLE `academic_partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`admission_id`);

--
-- Indexes for table `admission_info`
--
ALTER TABLE `admission_info`
  ADD PRIMARY KEY (`info_id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`certificate_id`);

--
-- Indexes for table `counsellors`
--
ALTER TABLE `counsellors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_config_setting`
--
ALTER TABLE `email_config_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_category`
--
ALTER TABLE `event_category`
  ADD PRIMARY KEY (`event_category_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_id`);

--
-- Indexes for table `program_description`
--
ALTER TABLE `program_description`
  ADD PRIMARY KEY (`description_id`);

--
-- Indexes for table `program_detail`
--
ALTER TABLE `program_detail`
  ADD PRIMARY KEY (`program_detail_id`);

--
-- Indexes for table `program_lecturer`
--
ALTER TABLE `program_lecturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program_video`
--
ALTER TABLE `program_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `research`
--
ALTER TABLE `research`
  ADD PRIMARY KEY (`research_id`);

--
-- Indexes for table `site_data`
--
ALTER TABLE `site_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_setting`
--
ALTER TABLE `site_setting`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `site_social_link`
--
ALTER TABLE `site_social_link`
  ADD PRIMARY KEY (`social_link_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us_master`
--
ALTER TABLE `about_us_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `academic_partner`
--
ALTER TABLE `academic_partner`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `admission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_info`
--
ALTER TABLE `admission_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `counsellors`
--
ALTER TABLE `counsellors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_config_setting`
--
ALTER TABLE `email_config_setting`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_category`
--
ALTER TABLE `event_category`
  MODIFY `event_category_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `lecturer_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_description`
--
ALTER TABLE `program_description`
  MODIFY `description_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_detail`
--
ALTER TABLE `program_detail`
  MODIFY `program_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_lecturer`
--
ALTER TABLE `program_lecturer`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `program_video`
--
ALTER TABLE `program_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `research`
--
ALTER TABLE `research`
  MODIFY `research_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_data`
--
ALTER TABLE `site_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_setting`
--
ALTER TABLE `site_setting`
  MODIFY `site_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_social_link`
--
ALTER TABLE `site_social_link`
  MODIFY `social_link_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

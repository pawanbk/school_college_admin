-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2022 at 06:28 AM
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
-- Database: `school_college`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_about_us_master`
--

CREATE TABLE `tbl_about_us_master` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `is_deleted_flag` enum('YES','NO') DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_about_us_master`
--

INSERT INTO `tbl_about_us_master` (`id`, `title`, `description`, `featured_image`, `route`, `is_deleted_flag`) VALUES
(5, 'Academic International College', 'Thames is more than just a place where you come to study for your degree. It is a community of students and faculty from diverse background coming together with a common belief that learning is a lifelong process. On one hand, you will always find being pushed to take responsibility of your own learning while on the other hand you will be encouraged to question, challenge and critically reflect both in and outside the classroom.\r\n', '470f9-academic.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_academic_partner`
--

CREATE TABLE `tbl_academic_partner` (
  `id` int(50) NOT NULL,
  `partner_name` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_academic_partner`
--

INSERT INTO `tbl_academic_partner` (`id`, `partner_name`, `logo`) VALUES
(1, 'Abc', 'ceec6-1.jpg'),
(2, 'cde', '3bd62-2.jpg'),
(3, 'efg', '8145c-3.jpg'),
(4, 'asdds', '3f5d5-4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE `tbl_courses` (
  `course_id` int(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `seats_available` int(20) NOT NULL,
  `total_classes` int(20) NOT NULL,
  `featured_image` varchar(100) NOT NULL,
  `course_category_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`course_id`, `name`, `description`, `seats_available`, `total_classes`, `featured_image`, `course_category_id`) VALUES
(2, 'GMAT', '', 0, 0, '7573b-6.jpg', 2),
(3, 'IELTS', '', 0, 0, 'ea3f5-2.jpg', 2),
(4, 'Basic Philosopphy', '', 0, 0, 'e3102-3.jpg', 1),
(5, 'Graphic Design', '', 0, 0, 'd5c6c-8.jpg', 1),
(6, 'Diploma', '', 0, 0, '7b223-10.jpg', 1),
(7, 'Humanity', '', 0, 0, '7573b-6.jpg', 2),
(8, 'Commerce', '', 0, 0, 'ea3f5-2.jpg', 2),
(9, 'Biology', '', 0, 0, 'e3102-3.jpg', 1),
(10, 'Graphic Design', '', 0, 0, 'd5c6c-8.jpg', 1),
(11, 'Diploma', '', 0, 0, '7b223-10.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_category`
--

CREATE TABLE `tbl_course_category` (
  `course_category_id` int(50) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_course_category`
--

INSERT INTO `tbl_course_category` (`course_category_id`, `category_name`) VALUES
(1, 'IT'),
(2, 'Education');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_lecturer`
--

CREATE TABLE `tbl_course_lecturer` (
  `id` int(50) NOT NULL,
  `lecturer_id` int(50) NOT NULL,
  `course_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_course_lecturer`
--

INSERT INTO `tbl_course_lecturer` (`id`, `lecturer_id`, `course_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_config_setting`
--

CREATE TABLE `tbl_email_config_setting` (
  `id` int(50) NOT NULL,
  `host_name` varchar(50) NOT NULL,
  `port` int(10) NOT NULL,
  `email_from` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `event_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(50) NOT NULL,
  `featured_image` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `event_category_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`event_id`, `title`, `date`, `location`, `featured_image`, `description`, `start`, `end`, `event_category_id`) VALUES
(1, 'Html MeetUp Conference 2017', '2022-01-01', '', '080ae-1.jpg', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge. Pellentese turpis dignissim amet area ducation process facilitating Knowledge. Pellentese turpis dignissim amet area ducation.</p>\n', '00:00:00', '00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_category`
--

CREATE TABLE `tbl_event_category` (
  `event_category_id` int(50) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_event_category`
--

INSERT INTO `tbl_event_category` (`event_category_id`, `category_name`) VALUES
(1, 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery_master`
--

CREATE TABLE `tbl_gallery_master` (
  `gallery_id` int(50) NOT NULL,
  `featured_image` varchar(50) NOT NULL,
  `priority` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_gallery_master`
--

INSERT INTO `tbl_gallery_master` (`gallery_id`, `featured_image`, `priority`) VALUES
(1, 'bd36a-bg.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lecturers`
--

CREATE TABLE `tbl_lecturers` (
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
-- Dumping data for table `tbl_lecturers`
--

INSERT INTO `tbl_lecturers` (`lecturer_id`, `full_name`, `featured_image`, `email_address`, `phone_number`, `description`, `qualification`, `designation`) VALUES
(3, 'Mike Hussy', 'f0b9c-7.jpg', 'mike@gmail.com', '0122211100', '', '<p>test</p>\n', 'Senior programmer'),
(4, 'Daziy Millar', 'af543-18.jpg', 'dazy@gmail.com', '0406624593', '', '<p>askaj</p>\n', 'Senior Finance Lecturer'),
(5, 'Essy Rojario', '2a011-16.jpg', 'essy@gmail.com', '0406624593', '', '<p>abcd</p>\n', 'Senior Account Lecturer'),
(6, 'David Lipu', '4c6ff-5.jpg', 'david@gmail.com', '0406624593', '', '<p>ajhasj</p>\n', 'Senior Java Lecturer'),
(7, 'Tom Steven', 'a63cd-15.jpg', 'tom@email.com', '0406624593', '', '<p>hashasha</p>\n', 'PHP Tutor'),
(8, 'PAWAN BK', 'a0fe8-student3.jpg', 'shiwanbk@gmail.com', '0406624593', '', '<p><input name=\"facebook\" type=\"checkbox\" value=\"faceboo.com\" /></p>\n', 'developer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lecturer_social_link`
--

CREATE TABLE `tbl_lecturer_social_link` (
  `social_link_id` int(50) NOT NULL,
  `social_link` varchar(100) NOT NULL,
  `link_icon` varchar(100) NOT NULL,
  `lecturer_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_lecturer_social_link`
--

INSERT INTO `tbl_lecturer_social_link` (`social_link_id`, `social_link`, `link_icon`, `lecturer_id`) VALUES
(1, 'https://www.facebook.com/prince.bk.37', 'fa fa-facebook', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mails`
--

CREATE TABLE `tbl_mails` (
  `mail_id` int(50) NOT NULL,
  `sender_full_name` varchar(50) NOT NULL,
  `sender_email_address` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_mails`
--

INSERT INTO `tbl_mails` (`mail_id`, `sender_full_name`, `sender_email_address`, `message`) VALUES
(1, 'Pawan bk', 'shiwanbk@gmail.com', 'Hello there, Can you please tell me about your courses?');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_master`
--

CREATE TABLE `tbl_menu_master` (
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
-- Dumping data for table `tbl_menu_master`
--

INSERT INTO `tbl_menu_master` (`menu_id`, `menu_code`, `menu_name`, `menu_index`, `menu_type`, `pre_menu_id`, `is_active`, `icon_class`, `route`, `created_date`, `created_by`, `modified_deleted_remarks`, `modified_by`, `modified_date`) VALUES
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
-- Table structure for table `tbl_news`
--

CREATE TABLE `tbl_news` (
  `news_id` int(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `featured_image` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `news_category_id` int(50) NOT NULL,
  `published_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_news`
--

INSERT INTO `tbl_news` (`news_id`, `title`, `featured_image`, `description`, `news_category_id`, `published_date`) VALUES
(1, 'Summer Course Start ', '78160-1.jpg', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge. Pellentese turpis dignissim amet area ducation process facilitating Knowledge.</p>\n', 1, '2022-01-02'),
(2, 'Guest Interview will', 'f1e81-2.jpg', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge.</p>\n', 1, '2022-01-06'),
(3, 'Easy English Learning Way', '9bcb9-8.jpg', '', 1, '2022-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_category`
--

CREATE TABLE `tbl_news_category` (
  `news_category_id` int(50) NOT NULL,
  `category_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_news_category`
--

INSERT INTO `tbl_news_category` (`news_category_id`, `category_name`) VALUES
(1, 'education');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_research`
--

CREATE TABLE `tbl_research` (
  `research_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `featured_image` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `research_category_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_research_category`
--

CREATE TABLE `tbl_research_category` (
  `research_category_id` int(50) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site_banner`
--

CREATE TABLE `tbl_site_banner` (
  `banner_id` int(50) NOT NULL,
  `banner_title` varchar(50) NOT NULL,
  `banner_description` varchar(100) NOT NULL,
  `featured_image` varchar(100) NOT NULL,
  `banner_link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_site_banner`
--

INSERT INTO `tbl_site_banner` (`banner_id`, `banner_title`, `banner_description`, `featured_image`, `banner_link`) VALUES
(1, 'Best Education for Html template', 'loreaadkjajhsdxasd andhjahda ahsdafkcajdc', '86846-4.jpg', ''),
(2, 'Best PhP courses', '', '65e3e-1.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site_setting`
--

CREATE TABLE `tbl_site_setting` (
  `site_id` int(50) NOT NULL,
  `site_name` varchar(20) NOT NULL,
  `site_logo` varchar(100) NOT NULL,
  `fav_icon` varchar(50) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `email_address` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_site_setting`
--

INSERT INTO `tbl_site_setting` (`site_id`, `site_name`, `site_logo`, `fav_icon`, `phone_number`, `email_address`, `address`) VALUES
(1, 'School college', 'd3452-logo-primary.png', 'cfe27-favicon.png', '0145552210', 'school@info.com', 'kathmandu,Nepal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site_social_link`
--

CREATE TABLE `tbl_site_social_link` (
  `social_link_id` int(50) NOT NULL,
  `social_link` varchar(50) NOT NULL,
  `link_icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `student_id` int(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `featured_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`student_id`, `full_name`, `email_address`, `phone_number`, `featured_image`) VALUES
(2, 'Rosy Janner', 'rosy@gmail.com', '0154789141', '33fb2-3.jpg'),
(3, 'Mike Hussy', 'mike@gmail.com', '0406624593', 'b995b-10.jpg'),
(4, 'Daziy Millar', 'dazi@gmail.com', '0406624593', 'eb9e8-9.jpg'),
(5, 'Luice Nishaa', 'luice@email.com', '012378964', 'ce986-8.jpg'),
(6, 'Tom Steven', 'tom@email.com', '0406624593', 'e079a-5.jpg'),
(7, 'Lubna', 'lubna@gmail.com', '980123657', 'b3cf7-12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonials`
--

CREATE TABLE `tbl_testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `featured_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_testimonials`
--

INSERT INTO `tbl_testimonials` (`id`, `name`, `description`, `featured_image`) VALUES
(1, 'Danial Dina', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge.</p>\n', '41373-1.jpg'),
(2, 'Pawan bk', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge.</p>\n', '6b423-student1.jpg'),
(3, 'Sijan pathak', '<p>Pellentese turpis dignissim amet area ducation process facilitating Knowledge. Pellentese turpis dignissim amet area ducation process facilitating Knowledge.</p>\n', '1af00-student7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_auth`
--

CREATE TABLE `tbl_user_auth` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `is_locked_flag` enum('Locked','Not-Locked') NOT NULL DEFAULT 'Not-Locked',
  `is_active` enum('Active','Not-Active') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_about_us_master`
--
ALTER TABLE `tbl_about_us_master`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_academic_partner`
--
ALTER TABLE `tbl_academic_partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tbl_course_category`
--
ALTER TABLE `tbl_course_category`
  ADD PRIMARY KEY (`course_category_id`);

--
-- Indexes for table `tbl_course_lecturer`
--
ALTER TABLE `tbl_course_lecturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_config_setting`
--
ALTER TABLE `tbl_email_config_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tbl_event_category`
--
ALTER TABLE `tbl_event_category`
  ADD PRIMARY KEY (`event_category_id`);

--
-- Indexes for table `tbl_gallery_master`
--
ALTER TABLE `tbl_gallery_master`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `tbl_lecturers`
--
ALTER TABLE `tbl_lecturers`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `tbl_lecturer_social_link`
--
ALTER TABLE `tbl_lecturer_social_link`
  ADD PRIMARY KEY (`social_link_id`);

--
-- Indexes for table `tbl_mails`
--
ALTER TABLE `tbl_mails`
  ADD PRIMARY KEY (`mail_id`);

--
-- Indexes for table `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `tbl_news_category`
--
ALTER TABLE `tbl_news_category`
  ADD PRIMARY KEY (`news_category_id`);

--
-- Indexes for table `tbl_research`
--
ALTER TABLE `tbl_research`
  ADD PRIMARY KEY (`research_id`);

--
-- Indexes for table `tbl_research_category`
--
ALTER TABLE `tbl_research_category`
  ADD PRIMARY KEY (`research_category_id`);

--
-- Indexes for table `tbl_site_banner`
--
ALTER TABLE `tbl_site_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `tbl_site_setting`
--
ALTER TABLE `tbl_site_setting`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `tbl_site_social_link`
--
ALTER TABLE `tbl_site_social_link`
  ADD PRIMARY KEY (`social_link_id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tbl_testimonials`
--
ALTER TABLE `tbl_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_auth`
--
ALTER TABLE `tbl_user_auth`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_about_us_master`
--
ALTER TABLE `tbl_about_us_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_academic_partner`
--
ALTER TABLE `tbl_academic_partner`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  MODIFY `course_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_course_category`
--
ALTER TABLE `tbl_course_category`
  MODIFY `course_category_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_course_lecturer`
--
ALTER TABLE `tbl_course_lecturer`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_email_config_setting`
--
ALTER TABLE `tbl_email_config_setting`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `event_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_event_category`
--
ALTER TABLE `tbl_event_category`
  MODIFY `event_category_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_gallery_master`
--
ALTER TABLE `tbl_gallery_master`
  MODIFY `gallery_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_lecturers`
--
ALTER TABLE `tbl_lecturers`
  MODIFY `lecturer_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_lecturer_social_link`
--
ALTER TABLE `tbl_lecturer_social_link`
  MODIFY `social_link_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_mails`
--
ALTER TABLE `tbl_mails`
  MODIFY `mail_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `news_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_news_category`
--
ALTER TABLE `tbl_news_category`
  MODIFY `news_category_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_research`
--
ALTER TABLE `tbl_research`
  MODIFY `research_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_research_category`
--
ALTER TABLE `tbl_research_category`
  MODIFY `research_category_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_site_banner`
--
ALTER TABLE `tbl_site_banner`
  MODIFY `banner_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_site_setting`
--
ALTER TABLE `tbl_site_setting`
  MODIFY `site_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_site_social_link`
--
ALTER TABLE `tbl_site_social_link`
  MODIFY `social_link_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_testimonials`
--
ALTER TABLE `tbl_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user_auth`
--
ALTER TABLE `tbl_user_auth`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

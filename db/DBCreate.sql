CREATE DATABASE IF NOT EXISTS linkedin_clone_db;

USE linkedin_clone_db;

CREATE TABLE IF NOT EXISTS `users` (
  `id` uuid PRIMARY KEY,
  `image` varchar(256),
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) UNIQUE NOT NULL,
  `phone` varchar(25),
  `password` varchar(256) NOT NULL,
  `industry` varchar(50) NOT NULL,
  `current_company` varchar(50),
  `title` varchar(50),
  `about` text,
  `is_recuirter` boolean NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp
);

CREATE VIEW IF NOT EXISTS job_seekers AS
	SELECT * FROM users WHERE is_recuirter = FALSE;

CREATE VIEW IF NOT EXISTS recuirters AS
	SELECT * FROM users WHERE is_recuirter = TRUE;

CREATE TABLE IF NOT EXISTS `job_posts` (
  `id` uuid PRIMARY KEY,
  `image` varchar(256),
  `position` varchar(50) NOT NULL,
  `industry` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `author_id` uuid NOT NULL,
  `salary` float NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp,
  FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
);

CREATE TABLE IF NOT EXISTS `reactions` (
  `id` uuid PRIMARY KEY,
  `react_name` varchar(20) NOT NULL,
  `post_id` uuid NOT NULL,
  `author_id` uuid NOT NULL,
  FOREIGN KEY (`post_id`) REFERENCES `job_posts` (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `applicants` (
  `id` uuid PRIMARY KEY,
  `job_post_id` uuid NOT NULL,
  `job_seeker_id` uuid NOT NULL,
  `cover_letter` text,
  FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`),
  FOREIGN KEY (`job_seeker_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `comments` (
  `id` uuid PRIMARY KEY,
  `content` text NOT NULL,
  `post_id` uuid NOT NULL,
  `author_id` uuid NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp,
  FOREIGN KEY (`post_id`) REFERENCES `job_posts` (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `replies` (
  `id` uuid PRIMARY KEY,
  `content` text NOT NULL,
  `comment_id` uuid NOT NULL,
  `author_id` uuid NOT NULL,
  FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `experiences` (
  `id` uuid PRIMARY KEY,
  `company_name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text,
  `joining_date` date,
  `leaving_date` date,
  `author_id` uuid NOT NULL,
  FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `skills` (
  `id` uuid PRIMARY KEY,
  `skill` varchar(50) NOT NULL
);

-- bridge table
CREATE TABLE IF NOT EXISTS `skills_users` (
  `user_id` uuid NOT NULL,
  `skill_id` uuid NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`)
);


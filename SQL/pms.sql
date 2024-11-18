SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `personal_id` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `academic_degree` varchar(100) NOT NULL,
  `university` varchar(100) NOT NULL,
  `graduation_date` date NOT NULL,
  `speciality` varchar(100) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_director` int(11) NOT NULL,
  `receptionist_name` varchar(100) NOT NULL,
  `receptionist_surname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `doctor` VALUES
(44, '1527942008.jpg', 'Gentjan', 'Luan', 'Xhelilaj', 'J12345678K', 'M', '0693456777', '1983-07-01', 'Vlore', 'Msc', 'Universiteti i Mjekesise ', '2011-07-13', 'Pediatrician', 1, 'genti@gmail.com', 'genti123', '$2y$10$RuTvW9XA/Ggm1wFP6CZPu.cM/GB.TIWh6sUebknN4.xcNR/j3DPmq', 0, 'Ema', 'Idrizi'),
(45, '1527940687.jpg', 'Majlinda', 'Altin', 'Baka', 'J23456789K', 'F', '0692209120', '1988-02-09', 'Tirane', 'Msc', 'Universiteti i Mjekesise ', '2016-07-15', 'Dermatology', 1, 'majlinda@gmail.com', 'majlinda123', '$2y$10$1a34OgGB.qFOo.reJ0Us6OLgmzOG/wLLyrvYw9xe12UkQEg7uNKVi', 0, 'Ema', 'Idrizi'),
(46, '1527940940.jpg', 'Luan', 'Sokol', 'Xhelili', 'J34567812K', 'M', '0692209120', '1957-01-22', 'Vlore', 'Msc', 'Universiteti i Mjekesise ', '1984-07-23', 'Cardiolog', 1, 'luan@gmail.com', 'luan123', '$2y$10$T5xz44lDDpQ0lr4hz6s0dulLGV/DbVWFMrbGX7oT3GnyvLOrzFeNK', 1, 'Ema', 'Idrizi'),
(47, 'default.jpg', 'Dhurata', 'Hysni', 'Tarifa', 'J11145678K', 'F', '0692209120', '1964-06-14', 'Gjirokaster', 'Msc', 'Universiteti i Mjekesise ', '1991-01-06', 'Radiology', 1, 'dhurata@gmail.com', 'dhurata123', '$2y$10$msZYLCx2JpPWhcgrLYcGS./fjY8cVZhnagX7qROEOcXqGIToUv.WS', 0, 'Ema', 'Idrizi');

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `feedback` VALUES
(1, 110, 5, 'Great service.', '2018-06-02'),
(2, 111, 3, 'Good', '2018-06-02'),
(4, 115, 4, 'Very good', '2018-06-02');

CREATE TABLE `medical_record` (
  `id` int(11) NOT NULL,
  `health_insurance_nr` varchar(100) NOT NULL,
  `polyclinic_nr` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `id_doctor` int(11) DEFAULT NULL,
  `id_patient` int(11) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `rh_factor` varchar(3) NOT NULL,
  `allergies` varchar(1500) NOT NULL,
  `anamnesis` varchar(2000) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `doctor_surname` varchar(100) NOT NULL,
  `receptionist_name` varchar(100) NOT NULL,
  `receptionist_surname` varchar(100) NOT NULL,
  `in_waiting` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `medical_record` VALUES
(55, '12345678', 5, '2018-06-02', 1, 46, 110, 'O', 'Rh+', 'None', 'This is the anamnesis of Sara Qirko.', 'Luan', 'Xhelili', 'Ema', 'Idrizi', 1),
(56, '12345689', 5, '2018-06-02', 1, 44, 111, 'A', 'Rh+', 'None', 'This is the anamnesis of Klea Doka.', 'Gentjan', 'Xhelilaj', 'Ema', 'Idrizi', 0),
(60, '12345578', 5, '2018-06-02', 1, NULL, 115, 'B', 'Rh-', 'None', 'This is the anamnesis of Ilir Doka.', 'Luan', 'Xhelili', 'Ema', 'Idrizi', 0);

CREATE TABLE `medical_visit` (
  `id` int(11) NOT NULL,
  `id_medical_record` int(11) DEFAULT NULL,
  `id_doctor` int(11) DEFAULT NULL,
  `allowed_by` int(11) DEFAULT NULL,
  `date_created` date NOT NULL,
  `complaints` varchar(2000) NOT NULL,
  `diagnosis` varchar(2000) NOT NULL,
  `medicines` varchar(2000) NOT NULL,
  `days_off` int(11) NOT NULL,
  `is_infectious` int(11) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `doctor_surname` varchar(100) NOT NULL,
  `receptionist_name` varchar(100) NOT NULL,
  `receptionist_surname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `medical_visit` VALUES
(34, 55, 46, 1, '2018-06-02', 'Headache', 'Flu', 'Paracetamol', 0, 0, 'Luan', 'Xhelili', 'Ema', 'Idrizi'),
(35, 55, 46, 1, '2018-06-02', 'Headache', 'Stress', 'None', 0, 0, 'Luan', 'Xhelili', 'Ema', 'Idrizi'),
(36, 55, 46, 1, '2018-06-02', 'Headache', 'Flu season', 'Paracetamol and healthy food', 1, 0, 'Luan', 'Xhelili', 'Ema', 'Idrizi');

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `personal_id` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `job` varchar(100) NOT NULL,
  `guardian` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `patient` VALUES
(110, 'default.jpg', 'Sara', 'Denis', 'Qirko', 'E12345678K', 'F', '0691234567', 'Lagjia 10', 'Student', 'UNIVERSITY OF TIRANA', 'Denis Qirko', '2000-07-05', 'Tirane', 'sara@gmail.com', 'sara123', '$2y$10$Z8o3n3mPS87UNyQEgXZ1NaCLl6IO.S.FF9miC1PdX5DN1KAmIzjXa'),
(111, 'default.jpg', 'Klea', 'Denis', 'Doka', 'E22345678K', 'F', '0691234568', 'Lagjia 10', 'Student', 'UNIVERSITY OF TIRANA', 'Denis Doka', '2001-01-10', 'Tirane', 'klea@gmail.com', 'klea123', '$2y$10$5z2kZFFSWLdpzKlAfefqz.tl5UjG6JKh34OWyMh8RirLZXQlOUDpy'),
(115, 'default.jpg', 'Ilir', 'Alban', 'Doka', 'E32345678K', 'M', '0691234599', 'Lagjia 10', 'Student', 'UNIVERSITY OF TIRANA', 'Alban Doka', '1990-05-12', 'Tirane', 'ilir@gmail.com', 'ilir123', '$2y$10$x.7cFC/C3CPIzLGCE8vsMO5/TXrjNRMm0J6e.UIsgNReE.DcYs4EO');

CREATE TABLE `receptionist` (
  `id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `personal_id` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `academic_degree` varchar(100) NOT NULL,
  `university` varchar(100) NOT NULL,
  `graduation_date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `receptionist` VALUES
(13, '1527941706.jpg', 'Ema', 'Ema', 'Idrizi', 'F12345678K', 'F', '0692209120', '1990-01-01', 'Berat', 'Bachelor', 'Universiteti i Tiranes ', '2011-07-13', 1, 'ema@gmail.com', 'ema123', '$2y$10$9U8Nj5IAmsw7ln3cW9I2.eLr3nKkc8EKO4IX6N08sOi0l4tnNCTQm');

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `comment` varchar(2000) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `doctor_surname` varchar(100) NOT NULL,
  `receptionist_name` varchar(100) NOT NULL,
  `receptionist_surname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `report` VALUES
(5, 110, 46, 1, '2018-06-02', 'This patient needs to see a neurologist.', 'Luan', 'Xhelili', 'Ema', 'Idrizi');

ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_patient` (`id_patient`);

ALTER TABLE `medical_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_patient` (`id_patient`);

ALTER TABLE `medical_visit`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `receptionist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `medical_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

ALTER TABLE `medical_visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

ALTER TABLE `receptionist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

COMMIT;

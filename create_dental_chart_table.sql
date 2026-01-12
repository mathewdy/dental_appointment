-- SQL to Create Patient Dental Chart Table
-- Run this in phpMyAdmin to fix the 500 Error when saving dental charts

CREATE TABLE IF NOT EXISTS `patient_dental_chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `tooth_number` int(11) NOT NULL,
  `tooth_surface` varchar(20) DEFAULT 'whole',
  `status` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

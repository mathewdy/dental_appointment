-- ============================================================
-- Parent-Child Appointment System for Long-Term Treatments
-- ============================================================
-- Add parent_appointment_id column to link follow-up appointments
ALTER TABLE `appointments` 
ADD COLUMN `parent_appointment_id` INT(110) DEFAULT NULL AFTER `walk_in`;

-- Add index for performance
ALTER TABLE `appointments` 
ADD INDEX `idx_parent_appointment` (`parent_appointment_id`);

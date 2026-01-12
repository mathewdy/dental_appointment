-- SQL Script to Update All User IDs to start with 2026
-- This script ensures referential integrity by using a mapping table
-- and leveraging strict Foreign Key logic where available.

START TRANSACTION;

-- 1. Create a temporary mapping table to store the Old -> New ID pairs
-- We generate new IDs using the format: 2026 + 5-digit zero-padded Auto-Increment ID
-- Example: ID 234 becomes 202600234
CREATE TEMPORARY TABLE uid_map AS
SELECT 
    user_id as old_uid, 
    CAST(CONCAT('2026', LPAD(id, 5, '0')) AS UNSIGNED) as new_uid
FROM users;

-- 2. Manually Update Tables that DO NOT have Foreign Key Constraints (Cascade won't work for these)

-- Update 'notification' table
UPDATE notification n
JOIN uid_map m ON n.user_id = m.old_uid
SET n.user_id = m.new_uid;

UPDATE notification n
JOIN uid_map m ON n.createdBy = m.old_uid
SET n.createdBy = m.new_uid;

-- Update 'treatments' table (if it exists and lacks FK)
UPDATE treatments t
JOIN uid_map m ON t.patient_id = m.old_uid
SET t.patient_id = m.new_uid;

UPDATE treatments t
JOIN uid_map m ON t.doctor_id = m.old_uid
SET t.doctor_id = m.new_uid;

-- 3. Update 'users' table
-- Since Foreign Key Constraints (ON UPDATE CASCADE) are active for:
-- appointments, dentist_schedules, medical_history, patient_dental_chart, payments, schedule
-- Updating the parent 'users' table will AUTOMATICALLY update these child tables.

UPDATE users u
JOIN uid_map m ON u.user_id = m.old_uid
SET u.user_id = m.new_uid;

-- 4. Clean up
DROP TEMPORARY TABLE uid_map;

COMMIT;

-- Output success message (optional, for CLI)
SELECT "All User IDs have been successfully updated to the 2026 format." as status;

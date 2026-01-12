ALTER TABLE patient_dental_chart ADD COLUMN appointment_id INT NULL DEFAULT NULL AFTER patient_id;
ALTER TABLE patient_dental_chart ADD INDEX idx_appointment (appointment_id);

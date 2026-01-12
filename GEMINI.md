# Database Documentation & Workflow

## Workflow for Database Changes
1. **Request Change**: When you need a change (e.g., "Add a `status` column to `appointments`"), just ask.
2. **Documentation Update**: I will update the schema documentation below.
3. **Script Compilation**: I will append the necessary SQL commands to `database_changes.sql`.
4. **Execution**: You verify the SQL in `database_changes.sql` and run it in phpMyAdmin.
5. **Clear**: After successfully running the changes, you can clear `database_changes.sql` for the next batch.

---

## Current Schema
**Database Name**: `u147900499_fojas_dental`

### Tables

#### `users`
Stores all user accounts (Patients, Admins, Doctors).
- `user_id`: Unique identifier (e.g., 202600234).
- `role_id`: 1=Patient, 2=Admin, 3=Doctor.
- `password`: Hashed password.

#### `roles`
Defines user roles.
- `id`: 1, 2, 3.
- `name`: Patient, Admin, Doctor.

#### `appointments`
Manages patient appointments.
- `appointment_id`: Unique ID for the appointment.
- `user_id`: Doctor's ID.
- `user_id_patient`: Patient's ID.
- `status`: Managed via `confirmed` (1=Confirmed, 3=Pending/etc).

#### `dentist_schedules`
Weekly schedule for doctors.
- `day_of_week`: Monday, Tuesday, etc.
- `start_time` / `end_time`.

#### `medical_history`
Patient medical records.
- `history`, `current_medications`, `allergies`, `past_surgeries`.

#### `patient_dental_chart`
Dental status per tooth.
- `tooth_number`: 1-32.
- `status`: Extraction, Jacket Crown, Impacted Tooth, etc.
- `tooth_surface`: whole, Mesial, Buccal, etc.

#### `payments` & `payment_history`
Billing and transaction tracking.

#### `treatments`
Records of treatments performed.

#### `services`
List of offered dental services and prices.

#### `notification`
In-app notifications for users.


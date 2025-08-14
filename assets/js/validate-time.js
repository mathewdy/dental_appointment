function validate(){
	const start = document.getElementById('start_time').value;
	const end = document.getElementById('end_time').value;

	if (!start || !end) {
		Swal.fire('Missing Time', 'Please select both start and end time.', 'warning');
		return false;
	}

	const startTime = new Date("1970-01-01T" + start + ":00");
	const endTime = new Date("1970-01-01T" + end + ":00");
	const minTime = new Date("1970-01-01T10:00:00");
	const maxTime = new Date("1970-01-01T17:00:00");

	if (startTime < minTime || startTime > maxTime) {
		Swal.fire('Invalid Start Time', 'Start time must be between 10:00 AM and 5:00 PM.', 'error');
		return false;
	}

	if (endTime <= startTime) {
		Swal.fire('Invalid End Time', 'End time must be after start time.', 'error');
		return false;
	}

	if (endTime > maxTime) {
		Swal.fire('Invalid End Time', 'End time must not be later than 5:00 PM.', 'error');
		return false;
	}

	return true;
}
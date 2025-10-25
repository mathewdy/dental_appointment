function confirmBeforeSubmit($form, message, validateCallback) {
    Swal.fire({
        title: 'Are you sure?',
        text: message || "Do you want to proceed?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            if (typeof validateCallback === 'function') {
                if (validateCallback()) {
                    $form[0].submit();
                }
            } else {
                $form[0].submit();
            }
        }
    });
}

function confirmBeforeRedirect(message, redirectUrl) {
  Swal.fire({
      title: 'Are you sure?',
      text: message || "Do you want to proceed?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Confirm',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#3085d6'
  }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = redirectUrl
      }
  });
}

function confirmDelete(message, callback) {
  Swal.fire({
    title: 'Are you sure?',
    text: message || "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Delete',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#d33'
  }).then((result) => {
    if (result.isConfirmed && typeof callback === 'function') {
      callback();
    }
  });
}

function success(message, callback) {
  Swal.fire({
    title: 'Success!',
    text: message || "Process success!",
    icon: 'success',
    confirmButtonText: 'Ok',
    confirmButtonColor: '#3085d6'
  }).then((result) => {
    if (result.isConfirmed && typeof callback === 'function') {
      callback()[0];
    }
  });
}

function error(message, callback) {
  Swal.fire({
    title: 'Error!',
    text: message || "Process failed", 
    icon: 'error',
    confirmButtonText: 'Ok',
    confirmButtonColor: '#3085d6'
  }).then((result) => {
    if (result.isConfirmed && typeof callback === 'function') {
      callback()[0];
    }
  });
}

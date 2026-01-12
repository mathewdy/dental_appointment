<?php
echo <<<HTML
<script>
let currentStep = 1;

function showStep(step){
    currentStep = step;
    $(".step-content").removeClass("active");
    $(".step-content[data-step='" + step + "']").addClass("active");

    $(".step-item").removeClass("active");
    $(".step-item[data-step='" + step + "']").addClass("active");
}

$(".next-btn").click(function(){
    if(currentStep < 3) showStep(currentStep+1);
});

$(".prev-btn").click(function(){
    if(currentStep > 1) showStep(currentStep-1);
});

$("#multiForm").submit(function(e){
    e.preventDefault();
    let formData = $(this).serialize();
    
    $.ajax({
        url: 'request_register.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(res){
            if(res.success){
                $('.err').html('');
                success(res.message, () => window.location.href='login.php')
            } else {
                $('.err').html('<div class="alert alert-danger" role="alert">' + res.message + '</div>');

                $('.right-panel').animate({ scrollTop: 0 }, 300);

                showStep(1);
            }
        },
        error: function(){
            $('.err').html('<div class="alert alert-danger" role="alert">Server error!</div>');
        }
    });
});


$(document).ready(function(){
    $(".dob").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "mm/dd/yy",
        maxDate: 0,
        yearRange: "-120:-0",
        defaultDate: "-25y" 
    });
    $(".dob").on("keydown paste", e=>e.preventDefault());
});
</script>
HTML;

?>
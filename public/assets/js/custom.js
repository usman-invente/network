(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})();


$(document).on('click', '.btn-submit', function (e) {
    e.preventDefault();
    var flag = false;
    var errFlag = false;
    var ufax = '';
    
    if ($('#ufax').val() !== '') {
            flag = true;
            $('#ufax').removeClass('is-invalid');
            ufax = $('#ufax').val();
        } else {
            errFlag = true;
            $('#ufax').addClass('is-invalid');
            flag = false;
        }
    
    if (flag) {
        $('.alert-danger').addClass('d-none');
        $(this).prop('disabled', true);
        submitForm(ufax);
    } else {
        if (!errFlag) {
            $('.alert-danger').removeClass('d-none');
        }
    }
});

function submitForm(ufax) {
    $('.spinner-border').removeClass('d-none');
    $.post(APP_URL + '/submit', {
        _token: CSRF_TOKEN,
        ufax: ufax
        
    }, function (response) {
        $('.spinner-border').addClass('d-none');
        $('.alert-success').removeClass('d-none');
        $('.btn-submit').prop('disabled', false);
        $('.needs-validation').trigger("reset");
    });
}
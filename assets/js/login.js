$(document).ready(function() {
    // Toggle password visibility
    $(document).on('click', '#toggle-password', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var passwordInput = $('#password');
        var icon = $(this);
        
        if (passwordInput.attr('type') === 'password') {
            // Show password - open eye
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            // Hide password - closed eye with slash
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });

    $('#login-form').submit(function(e) {
        e.preventDefault();
        
        var formData = {
            username: $('#username').val().trim(),
            password: $('#password').val().trim()
        };

        console.log('Sending data:', formData);

        $.ajax({
            url: 'api/login.php',
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                showAlert('success', 'Login successful! Redirecting...');
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 1000);
            },
            error: function(xhr) {
                console.log('Error:', xhr);
                var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Login failed. Please try again.';
                showAlert('error', msg);
            }
        });
    });

    function showAlert(type, message) {
        var alertBox = $('#alert-message');
        alertBox.removeClass('alert-success alert-error').addClass(type === 'success' ? 'alert-success' : 'alert-error');
        alertBox.html('<i class="fa-solid fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + message).fadeIn();
        
        if(type === 'error') {
            setTimeout(function() {
                alertBox.fadeOut();
            }, 3000);
        }
    }
});

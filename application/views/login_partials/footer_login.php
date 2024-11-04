    </div>
 </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="<?php echo base_url('assets/js/csrf.js'); ?>"></script>

<script>

var refreshCsrfUrl = "<?php echo base_url('refresh_csrf'); ?>";


$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();

        // Clear previous error messages
        $('#email_error').html('');
        $('#password_error').html('');

        // Get CSRF token name and hash from meta tags
        var csrfName = $('meta[name="csrf-token-name"]').attr('content');
        var csrfHash = $('meta[name="csrf-token-hash"]').attr('content');

        // Prepare form data and add CSRF token
        var formData = $(this).serializeArray();
        formData.push({ name: 'login', value: true }); // Ensure login key is sent

        formData.push({ name: csrfName, value: csrfHash }); // Add CSRF token to form data
        

        $.ajax({
            url: "<?php echo base_url('login'); ?>",
            method: "POST",
            data: $.param(formData), // Serialize form data with CSRF token
            dataType: "json",
            success: function(response) {
                if (response.error) {
                   
                    if (response.error.email) {
                        $('#email_error').html(response.error.email);
                    }
                    if (response.error.password) {
                        $('#password_error').html(response.error.password);
                    }
                    refreshCsrfToken();
                } else if (response.success) {
                    window.location.href = "<?php echo base_url('admin'); ?>";
                    refreshCsrfToken();
                } else {
                    // Handle general errors or login failure
                    console.log("a");
                    refreshCsrfToken();
                    alert(response.message);
                    
                }
            },
            error: function(xhr, status, error) {
                refreshCsrfToken();
                console.error("AJAX Error:", status, error);
                alert("An error occurred while processing your request.");
            }
        });
    });
});

</script>
</html>
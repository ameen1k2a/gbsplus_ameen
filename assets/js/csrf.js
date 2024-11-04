// JavaScript

function refreshCsrfToken(callback) {
    $.get(refreshCsrfUrl, function(data) {
        var csrfData = JSON.parse(data);
        
        // Update CSRF token in the input field
        $('input[name="' + csrfData.csrf_token_name + '"]').val(csrfData.csrf_hash);
        
        // Optionally update meta tags
        $('meta[name="csrf-token-name"]').attr('content', csrfData.csrf_token_name);
        $('meta[name="csrf-token-hash"]').attr('content', csrfData.csrf_hash);
        
        // Execute callback if provided
        if (typeof callback === 'function') {
            callback();
        }
    });
}

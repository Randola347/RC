<?php
if (session_status() === PHP_SESSION_NONE) {
    // Ensure session cookie is only sent over HTTPS
    ini_set('session.cookie_secure', 1);

    // Prevent JavaScript from accessing the session cookie
    ini_set('session.cookie_httponly', 1);

    // Use cookies to store session ID on the client side
    ini_set('session.use_only_cookies', 1);

    // Start the session
    session_start();

    // Regenerate session ID to prevent session fixation attacks
    session_regenerate_id(true);
}
?>

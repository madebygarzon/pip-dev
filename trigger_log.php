<?php
add_action('shutdown', function() {
    $log_file = CUSTOM_DEBUG_LOG_PATH;

    if (!file_exists($log_file)) {
        return;
    }

    $last_check_file = WP_CONTENT_DIR . '/last_error_check.log';
    $last_check_time = file_exists($last_check_file) ? filemtime($last_check_file) : 0;

    $log_entries = file($log_file);
    $new_errors = [];

    foreach ($log_entries as $line) {
        if (strpos($line, 'PHP') !== false && filemtime($log_file) > $last_check_time) {
            $new_errors[] = $line;
        }
    }

    if (!empty($new_errors)) {
        $subject = "⚠️ Alerta de errores en " . get_bloginfo('name');
        $message = "Se detectaron errores recientes:\n\n" . implode("\n", $new_errors);
        wp_mail(LOGGING_EMAIL, $subject, $message);
    }

    // Actualiza el timestamp del último análisis
    touch($last_check_file);
});

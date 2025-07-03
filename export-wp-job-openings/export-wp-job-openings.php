<?php
/**
 * Plugin Name: Export WP Job Applicants
 * Description: Export applicants from WP Job Openings without modifying the original plugin.
 * Version: 7.5
 * Author: Pipdevteam
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', 'custom_export_wp_job_applicants_menu' );

function custom_export_wp_job_applicants_menu() {
    add_submenu_page(
        'edit.php?post_type=awsm_job_openings',
        __( 'Export Applicants', 'wp-job-openings' ),
        __( 'Export Applicants', 'wp-job-openings' ),
        'manage_awsm_jobs',
        'custom-export-applicants',
        'custom_export_applicants_page'
    );
}

function custom_export_applicants_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Export Applicants', 'wp-job-openings' ); ?></h1>
        <p><?php esc_html_e( 'Download an Excel file containing the applicant details.', 'wp-job-openings' ); ?></p>
        <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'custom_export_applicants_download' => 'excel' ), admin_url() ), 'custom_export_applicants_excel' ) ); ?>" class="button button-primary">
            <?php esc_html_e( 'Download Excel', 'wp-job-openings' ); ?>
        </a>
    </div>
    <?php
}

function custom_export_applicants_excel() {
    if ( ! current_user_can( 'manage_awsm_jobs' ) ) {
        wp_die( __( 'You do not have permission to export applicants.', 'wp-job-openings' ) );
    }

    if ( ! class_exists( 'AWSM_Job_Openings' ) ) {
        wp_die( 'WP Job Openings plugin not active or loaded.' );
    }

    $applications = AWSM_Job_Openings::get_all_applications( 'all' );
    $rows = array();
    $rows[] = array( 'Applicant Export - ' . date('F j, Y') );
    $rows[] = array( 'Job Title', 'Name', 'Phone', 'Email', 'Resume', 'Cover Letter', 'Job Status', 'Application date' );

    if ( ! empty( $applications ) ) {
        foreach ( $applications as $application ) {
            $name       = get_post_meta( $application->ID, 'awsm_applicant_name', true );
            $phone      = get_post_meta( $application->ID, 'awsm_applicant_phone', true );
            $email      = get_post_meta( $application->ID, 'awsm_applicant_email', true );
            $resume_id  = get_post_meta( $application->ID, 'awsm_attachment_id', true );
            $resume     = $resume_id ? wp_get_attachment_url( $resume_id ) : '';

            $resume = '';

            if ( $resume_id ) {
                $hide_files = get_option( 'awsm_hide_uploaded_files' );

                if ( $hide_files === 'hide_files' ) {
                   
                    $resume = 'File hidden by admin';
                } else {
                    
                    $resume = wp_get_attachment_url( $resume_id );
                }
            }

            $cover_letter = get_post_meta( $application->ID, 'awsm_applicant_letter', true );
            $job_title    = get_post_meta( $application->ID, 'awsm_apply_for', true );

            $job_id     = $application->post_parent;
            $job_status = 'Unknown';

            if ( $job_id ) {
                $post_status = get_post_status( $job_id );
                $job_status = ($post_status === 'publish') ? 'Active' : 'Inactive';


                $meta_status = get_post_meta( $job_id, 'awsm_job_status', true );
                if ( ! empty( $meta_status ) ) {
                    $job_status = ucfirst( $meta_status );
                }
            }

            $date_posted = get_the_date( 'Y-m-d', $application->ID );

            $rows[] = array(
            $job_title,
            $name,
            $phone,
            $email,
            $resume,
            $cover_letter,
            $job_status,
            $date_posted
            );
        }
    }

    if ( ob_get_length() ) {
        ob_clean();
    }
    flush();

    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=applicants.csv' );

    foreach ( $rows as $row ) {
        echo implode(",", array_map(function($v) {
            $v = custom_export_clean_field($v);
            return '"' . str_replace('"', '""', $v) . '"';
        }, $row)) . "\n";
    }
    exit;
}

function custom_export_clean_field( $value ) {
    $value = strip_tags( $value );
    $value = html_entity_decode( $value, ENT_QUOTES, 'UTF-8' );
    
    $value = str_replace([ "\u{2028}", "\u{2029}" ], ' ', $value);

    $value = preg_replace( "/[\t\r\n]+/", " ", $value );

    $value = preg_replace( "/\s+/", " ", $value );

    return trim( $value );
}

add_action( 'admin_init', 'custom_export_applicants_download_hook' );

function custom_export_applicants_download_hook() {
    if (
        isset( $_GET['custom_export_applicants_download'] ) &&
        $_GET['custom_export_applicants_download'] === 'excel' &&
        current_user_can( 'manage_awsm_jobs' ) &&
        check_admin_referer( 'custom_export_applicants_excel' )
    ) {
        custom_export_applicants_excel();
    }
}

add_action('init', function () {
    add_rewrite_rule('^export-applicants-download/?$', 'index.php?export_applicants=1', 'top');
});

add_filter('query_vars', function ($vars) {
    $vars[] = 'export_applicants';
    return $vars;
});

add_action('template_redirect', function () {
    if (get_query_var('export_applicants') == 1) {
        custom_export_applicants_excel();
        exit;
    }
});

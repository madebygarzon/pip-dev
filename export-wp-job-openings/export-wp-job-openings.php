<?php
/**
 * Plugin Name: Export WP Job Applicants
 * Description: Export applicants from WP Job Openings without modifying the original plugin.
 * Version: 1.1
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
    $rows         = array();
    $rows[]       = array( 'Name', 'Phone', 'Email', 'Resume' );

    if ( ! empty( $applications ) ) {
        foreach ( $applications as $application ) {
            $name      = get_post_meta( $application->ID, 'awsm_applicant_name', true );
            $phone     = get_post_meta( $application->ID, 'awsm_applicant_phone', true );
            $email     = get_post_meta( $application->ID, 'awsm_applicant_email', true );
            $resume_id = get_post_meta( $application->ID, 'awsm_attachment_id', true );
            $resume    = '';

            if ( $resume_id ) {
                $resume = wp_get_attachment_url( $resume_id );
                if ( get_option( 'awsm_hide_uploaded_files' ) === 'hide_files' && $resume ) {
                    $resume = AWSM_Job_Openings::get_application_edit_link( $application->ID );
                }
            }

            $rows[] = array( $name, $phone, $email, $resume );
        }
    }

    if ( ob_get_length() ) {
        ob_clean();
    }
    flush();

    header( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=applicants.xls' );

    foreach ( $rows as $row ) {
        echo implode( "\t", array_map( 'custom_export_clean_field', $row ) ) . "\n";
    }
    exit;
}

function custom_export_clean_field( $value ) {
    return str_replace( array( "\t", "\n", "\r" ), ' ', $value );
}

add_action( 'admin_init', 'custom_export_applicants_download_hook' );

function custom_export_applicants_download_hook() {
    if (
        isset( $_GET['custom_export_applicants_download'] ) &&
        $_GET['custom_export_applicants_download'] === 'excel' &&
        current_user_can( 'manage_awsm_jobs' ) &&
        check_admin_referer( 'custom_export_applicants_excel' )
    ) {
        custom_export_applicants_excel(); // función ya definida antes
    }
}
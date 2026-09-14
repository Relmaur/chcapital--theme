<?php

/**
 * Consent-evidence audit log for chcapital.mx form submissions.
 *
 * Enriches taw/core's `taw_submission` CPT (created by
 * TAW\Core\Form\SubmissionsHandler::saveSubmission()) with the extra fields
 * the client's privacy-compliance review asked for: a unique consent event
 * id, the privacy notice version/hash that was live at submit time, and a
 * staff-side withdrawal flag for when an ARCO request is processed manually.
 *
 * Depends on a small taw/core change (passing the newly-saved submission's
 * post ID as a second argument to a form's 'on_submit' callback) that may
 * not have landed yet — chcapital_record_consent_evidence() degrades
 * gracefully (skips, logs a WP_DEBUG notice) until it has, rather than
 * erroring.
 */

if (!defined('ABSPATH')) {
    exit;
}

use TAW\Core\OptionsPage\OptionsPage;

const CHCAPITAL_SUBMISSION_CPT = 'taw_submission';

/**
 * Attach consent-evidence meta to a just-saved form submission. Pass this
 * from a form's 'on_submit' callback: on_submit($data, $postId).
 */
function chcapital_record_consent_evidence(array $data, int|false $postId): void
{
    if (!$postId) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
            trigger_error(
                '[chcapital] chcapital_record_consent_evidence() called without a post ID — '
                . 'requires the taw/core on_submit($data, $postId) change to have landed.',
                E_USER_NOTICE
            );
        }
        return;
    }

    $consentValue = static function (array $data, string $fieldId): string {
        if (!array_key_exists($fieldId, $data)) {
            return 'not_applicable';
        }
        return $data[$fieldId] === '1' ? '1' : '0';
    };

    update_post_meta($postId, '_taw_consent_event_id', wp_generate_uuid4());
    update_post_meta($postId, '_taw_consent_primary', $consentValue($data, 'privacy_consent'));
    update_post_meta($postId, '_taw_consent_marketing', $consentValue($data, 'marketing_consent'));

    // Not yet distinguished from the general privacy checkbox above — the
    // current form only has one consent checkbox. Wiring these up to real,
    // separate checkboxes needs the client's lawyer to define when each
    // tier actually applies (financial/patrimonial vs. sensitive data).
    update_post_meta($postId, '_taw_consent_financial_patrimonial', 'not_applicable');
    update_post_meta($postId, '_taw_consent_sensitive_data', 'not_applicable');

    update_post_meta($postId, '_taw_privacy_notice_version', (string) OptionsPage::get('privacy_notice_version'));
    update_post_meta($postId, '_taw_privacy_notice_hash', (string) OptionsPage::get('privacy_notice_hash'));
    update_post_meta($postId, '_taw_consent_evidence_method', 'checkbox');
    update_post_meta($postId, '_taw_consent_withdrawal_status', 'vigente');
    update_post_meta($postId, '_taw_consent_withdrawal_date', '');
}

function chcapital_consent_label(string $value): string
{
    return match ($value) {
        '1' => __('Sí', 'taw-theme'),
        '0' => __('No', 'taw-theme'),
        'not_applicable', '' => __('N/A', 'taw-theme'),
        default => $value,
    };
}

/* =====================================================================
 * Admin columns — Submissions list
 * ================================================================== */

add_filter('manage_' . CHCAPITAL_SUBMISSION_CPT . '_posts_columns', function (array $columns): array {
    $columns['consent_status']    = __('Consentimiento', 'taw-theme');
    $columns['withdrawal_status'] = __('Estado', 'taw-theme');
    return $columns;
}, 20);

add_action('manage_' . CHCAPITAL_SUBMISSION_CPT . '_posts_custom_column', function (string $column, int $postId): void {
    switch ($column) {
        case 'consent_status':
            $primary   = (string) get_post_meta($postId, '_taw_consent_primary', true);
            $marketing = (string) get_post_meta($postId, '_taw_consent_marketing', true);
            echo esc_html__('Privacidad:', 'taw-theme') . ' ' . esc_html(chcapital_consent_label($primary))
                . '<br>' . esc_html__('Marketing:', 'taw-theme') . ' ' . esc_html(chcapital_consent_label($marketing));
            break;

        case 'withdrawal_status':
            $status = (string) get_post_meta($postId, '_taw_consent_withdrawal_status', true);
            echo match ($status) {
                'revocado' => '<span style="color:#dc3232;">' . esc_html__('Revocado', 'taw-theme') . '</span>',
                'vigente'  => '<span style="color:#46b450;">' . esc_html__('Vigente', 'taw-theme') . '</span>',
                default    => '<span style="color:#999;">—</span>',
            };
            break;
    }
}, 10, 2);

/* =====================================================================
 * Admin detail metabox + staff-side revoke action
 * ================================================================== */

add_action('add_meta_boxes', function (): void {
    add_meta_box(
        'chcapital_consent_evidence',
        __('Evidencia de Consentimiento', 'taw-theme'),
        'chcapital_render_consent_evidence_metabox',
        CHCAPITAL_SUBMISSION_CPT,
        'normal',
        'high'
    );
});

function chcapital_render_consent_evidence_metabox(\WP_Post $post): void
{
    $postId = $post->ID;

    $rows = [
        __('Consent Event ID', 'taw-theme')                => get_post_meta($postId, '_taw_consent_event_id', true) ?: '—',
        __('Consentimiento (privacidad)', 'taw-theme')      => chcapital_consent_label((string) get_post_meta($postId, '_taw_consent_primary', true)),
        __('Consentimiento (marketing)', 'taw-theme')       => chcapital_consent_label((string) get_post_meta($postId, '_taw_consent_marketing', true)),
        __('Datos financieros/patrimoniales', 'taw-theme')  => chcapital_consent_label((string) get_post_meta($postId, '_taw_consent_financial_patrimonial', true)),
        __('Datos sensibles', 'taw-theme')                  => chcapital_consent_label((string) get_post_meta($postId, '_taw_consent_sensitive_data', true)),
        __('Versión del Aviso', 'taw-theme')                => get_post_meta($postId, '_taw_privacy_notice_version', true) ?: '—',
        __('Hash del Aviso', 'taw-theme')                   => get_post_meta($postId, '_taw_privacy_notice_hash', true) ?: '—',
        __('Método de evidencia', 'taw-theme')              => get_post_meta($postId, '_taw_consent_evidence_method', true) ?: '—',
    ];

    echo '<table class="widefat striped" style="border:0;"><tbody>';
    foreach ($rows as $label => $value) {
        printf(
            '<tr><th style="width:220px;text-align:left;font-weight:600;color:#444;">%s</th><td>%s</td></tr>',
            esc_html($label),
            esc_html((string) $value)
        );
    }
    echo '</tbody></table>';

    $status      = get_post_meta($postId, '_taw_consent_withdrawal_status', true) ?: 'vigente';
    $withdrawnAt = get_post_meta($postId, '_taw_consent_withdrawal_date', true);

    echo '<div style="margin-top:15px;border-top:1px solid #ddd;padding-top:10px;">';

    if ($status === 'revocado') {
        printf(
            '<p><strong>%s</strong> %s</p>',
            esc_html__('Consentimiento revocado el:', 'taw-theme'),
            esc_html((string) $withdrawnAt)
        );
    } else {
        $url = wp_nonce_url(
            admin_url('admin-post.php?action=taw_revoke_consent&submission_id=' . $postId),
            'taw_revoke_consent_' . $postId
        );
        printf(
            '<a href="%s" class="button" onclick="return confirm(\'%s\');">%s</a>',
            esc_url($url),
            esc_js(__('¿Confirmas que deseas marcar este consentimiento como revocado? Usa esto solo al procesar una solicitud ARCO.', 'taw-theme')),
            esc_html__('Revocar consentimiento', 'taw-theme')
        );
    }

    echo '</div>';
}

add_action('admin_post_taw_revoke_consent', function (): void {
    $submissionId = isset($_GET['submission_id']) ? absint($_GET['submission_id']) : 0;
    $nonce        = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

    if (
        !$submissionId
        || get_post_type($submissionId) !== CHCAPITAL_SUBMISSION_CPT
        || !current_user_can('edit_post', $submissionId)
        || !wp_verify_nonce($nonce, 'taw_revoke_consent_' . $submissionId)
    ) {
        wp_die(esc_html__('No autorizado.', 'taw-theme'), 403);
    }

    update_post_meta($submissionId, '_taw_consent_withdrawal_status', 'revocado');
    update_post_meta($submissionId, '_taw_consent_withdrawal_date', current_time('mysql'));

    $editLink = get_edit_post_link($submissionId, 'raw');
    wp_safe_redirect(add_query_arg('taw_consent_revoked', '1', $editLink ?: admin_url()));
    exit;
});

add_action('admin_notices', function (): void {
    if (
        !isset($_GET['taw_consent_revoked'], $_GET['post'])
        || get_post_type(absint($_GET['post'])) !== CHCAPITAL_SUBMISSION_CPT
    ) {
        return;
    }

    echo '<div class="notice notice-success is-dismissible"><p>'
        . esc_html__('Consentimiento marcado como revocado.', 'taw-theme')
        . '</p></div>';
});

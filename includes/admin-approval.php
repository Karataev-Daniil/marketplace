<?php
// Display users with pending roles in the admin panel
function kayo_pending_roles_admin_notice() {
    $args = [
        'meta_key' => 'pending_role',
        'meta_compare' => 'EXISTS'
    ];
    $pending_users = get_users($args);

    if (!empty($pending_users)) {
        echo '<div class="notice notice-warning"><p>Есть пользователи, ожидающие подтверждения роли. <a href="' . admin_url('users.php') . '">Посмотреть</a></p></div>';
    }
}
add_action('admin_notices', 'kayo_pending_roles_admin_notice');

// Adding a button to confirm the role on the users page
function kayo_add_approve_button($actions, $user_object) {
    if (current_user_can('administrator') && get_user_meta($user_object->ID, 'pending_role', true)) {
        $approve_url = add_query_arg([
            'action' => 'approve_user_role',
            'user_id' => $user_object->ID
        ], admin_url('users.php'));

        $actions['approve_role'] = '<a href="' . esc_url($approve_url) . '">Подтвердить роль</a>';
    }
    return $actions;
}
add_filter('user_row_actions', 'kayo_add_approve_button', 10, 2);

// Process role confirmation
function kayo_handle_approve_user_role() {
    if (isset($_GET['action'], $_GET['user_id']) && $_GET['action'] === 'approve_user_role' && current_user_can('administrator')) {
        $user_id = intval($_GET['user_id']);
        do_action('kayo_approve_user_role', $user_id);
        wp_redirect(admin_url('users.php'));
        exit;
    }
}
add_action('admin_init', 'kayo_handle_approve_user_role');

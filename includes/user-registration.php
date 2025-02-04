<?php
// Registration form with role selection
function kayo_custom_registration_form() {
    ?>
    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
        <label class="label-small" for="username">Имя пользователя</label>
        <input class="label-small" type="text" name="username" required>

        <label class="label-small" for="email">Email</label>
        <input class="label-small" type="email" name="email" required>

        <label class="label-small" for="password">Пароль</label>
        <input class="label-small" type="password" name="password" required>

        <label class="label-small" for="role">Тип аккаунта</label>
        <select class="label-small" name="role">
            <option value="regular_user">Обычный пользователь</option>
            <option value="seller">Продавец (требуется подтверждение)</option>
            <option value="delivery">Курьер (требуется подтверждение)</option>
        </select>

        <input class="accent-button-small button-small" type="submit" name="kayo_register" value="Зарегистрироваться">
    </form>
    <?php
}
add_shortcode('kayo_registration_form', 'kayo_custom_registration_form');

// Processing the registration form
function kayo_handle_registration() {
    if (isset($_POST['kayo_register'])) {
        $username = sanitize_text_field($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $role = sanitize_text_field($_POST['role']);

        $errors = new WP_Error();

        if (username_exists($username) || email_exists($email)) {
            $errors->add('user_exists', 'Имя пользователя или email уже заняты.');
        }

        if (empty($errors->errors)) {
            $user_id = wp_create_user($username, $password, $email);

            if ($role === 'seller' || $role === 'delivery') {
                wp_update_user(['ID' => $user_id, 'role' => 'regular_user']);
                update_user_meta($user_id, 'requested_role', $role);
            } else {
                wp_update_user(['ID' => $user_id, 'role' => 'regular_user']);
            }

            echo '<p class="body-small-medium">Регистрация успешна! Ожидайте подтверждения от администратора.</p>';
        }
    }
}
add_action('init', 'kayo_handle_registration');
?>
<?php
// Account login form
function kayo_custom_login_form() {
    ?>
    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
        <label class="label-small" for="username">Имя пользователя или email</label>
        <input class="label-small" type="text" name="username" required>

        <label class="label-small" for="password">Пароль</label>
        <input class="label-small" type="password" name="password" required>

        <input class="accent-button-small button-small" type="submit" name="kayo_login" value="Войти">
    </form>
    <?php
}
add_shortcode('kayo_login_form', 'kayo_custom_login_form');

// Process the login form
function kayo_handle_login() {
    if (isset($_POST['kayo_login'])) {
        $username = sanitize_text_field($_POST['username']);
        $password = sanitize_text_field($_POST['password']);

        $user = get_user_by('login', $username);

        if (!$user) {
            $user = get_user_by('email', $username);
        }

        if ($user && wp_check_password($password, $user->user_pass, $user->ID)) {
            wp_set_auth_cookie($user->ID);
            wp_redirect(home_url());
            exit;
        } else {
            echo '<p>Неверное имя пользователя или пароль.</p>';
        }
    }
}
add_action('init', 'kayo_handle_login');
?>

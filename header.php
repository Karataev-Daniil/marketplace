<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>MarketPlace</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <nav aria-label="main menu" class="main-menu">
        <ul class="menu">
            <h1 class="display-small">KayoVa Marketplace</h1>

            <div class="user">
                <?php
                $current_user = wp_get_current_user();
                if (is_user_logged_in()) {
                    echo '<p class="title-small">Добро пожаловать, ' . esc_html($current_user->display_name) . '!</p>';
                
                    $user_roles = $current_user->roles;
                    echo '<p class="title-small">Ваша роль: ' . esc_html(ucwords(implode(', ', $user_roles))) . '</p>';

                    if (isset($_POST['logout'])) {
                        wp_logout();
                        echo '<script type="text/javascript">window.location.reload();</script>';
                    }
                    echo '<form method="post">
                            <button type="submit" name="logout" class="logout-button">Выйти</button>
                          </form>';
                } else {
                    echo '<button type="button" class="open-login-popup tertiary-button-small" onclick="openLoginPopup()">Войти</button>';
                }
                ?>
            </div>
        </ul> 
    </nav>
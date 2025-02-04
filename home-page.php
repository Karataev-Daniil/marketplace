<?php
/*
Template Name: Home Page Template
*/

get_header(); 
?>

<div class="container">
    <section class="product-list">
        <h2 class="title-largest">Все товары</h2>
        <?php
        $args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
        ];
        $products = new WP_Query($args);

        if ($products->have_posts()) :
            echo '<div class="products-grid">';
            while ($products->have_posts()) : $products->the_post(); ?>
                <div class="product-item">
                    <h3 class="title-large">
                        <?php the_title(); ?>
                    </h3>
                    <p class="body-small-regular">
                        <?php echo strip_tags( get_the_excerpt() ); ?>
                    </p>
                    <p class="body-small-medium">
                        Цена: <?php echo get_post_meta(get_the_ID(), '_price', true); ?> ₽
                    </p>
                    <p class="body-small-semibold ">
                        Продавец: <?php echo get_the_author(); ?>
                    </p>
                    <!-- <a class="link-small-underline"href="<?php the_permalink(); ?>"> -->
                        <!-- Подробнее -->
                    <!-- </a> -->
                    
                    <form method="post" action="">
                        <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>" />
                        <button type="submit" name="add_to_cart" class="primary-button-small button-small">Добавить в корзину</button>
                    </form>
                </div>
            <?php endwhile;
            echo '</div>';
        else : ?>
            <p>Товары отсутствуют.</p>
        <?php endif;
        wp_reset_postdata();
        ?>
    </section>

    <?php if (!is_user_logged_in()) : ?>
        <div id="loginPopup" class="popup" style="display:none;">
            <div class="popup-content">
                <span class="popup-close" onclick="closeLoginPopup()">×</span>
                <div id="registration-form" class="form-container">
                    <h2 class="title-medium">Регистрация</h2>
                    <?php echo do_shortcode('[kayo_registration_form]'); ?>
                    <p class="body-small-medium">Уже есть аккаунт? <a href="javascript:void(0);" onclick="toggleForms('login')">Войти</a></p>
                </div>
                <div id="login-form" class="form-container" style="display:none;">
                    <h2 class="title-medium">Войти в аккаунт</h2>
                    <?php echo do_shortcode('[kayo_login_form]'); ?>
                    <p class="body-small-medium">Нет аккаунта? <a href="javascript:void(0);" onclick="toggleForms('registration')">Зарегистрироваться</a></p>
                </div>
            </div>
        </div>
    <?php else : ?>
    <?php endif; ?>


    <section>
        <?php echo do_shortcode('[kayo_cart]'); ?>
    </section>
</div>

<?php get_footer(); ?>
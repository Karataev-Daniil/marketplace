<?php
get_header();
?>
    <div class="product-page">
        <div class="product-container">
            <div class="product-image">
                <?php 
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail('large');
                }
                ?>
            </div>
            <div class="product-details">
                <h1 class="product-title"><?php the_title(); ?></h1>
                <div class="product-price">
                    <?php
                    if ( function_exists('wc_get_product') ) {
                        $product = wc_get_product(get_the_ID());
                        if ($product) {
                            echo '<span class="price">' . $product->get_price_html() . '</span>';
                        }
                    }
                    ?>
                </div>

                <div class="product-description">
                    <?php the_content(); ?>
                </div>

                <div class="product-meta">
                    
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
?>

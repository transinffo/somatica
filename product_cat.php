<?php
if (is_category()) {
    // Проверяем, задан ли кастомный шаблон для категории
    if (get_field('is_template_product_cat', get_queried_object())) {

        // --- определяем уровень вложенности категории ---
        $cat    = get_queried_object();                  // объект текущей категории
        $level  = count(get_ancestors($cat->term_id, 'category')) + 1; 
        // теперь $level доступен в любом месте шаблона
?>
        <div class="no-bottom no-top" id="content" data-lavel="<?=$level?>">
            <div id="top"></div>
            <!-- банер -->
            <section class="bg-dark text-light relative jarallax">
                <div class="de-gradient-edge-top"></div>
                <?php if ($img = get_field('category_img', get_queried_object())): ?>
                    <img class="jarallax-img" src="<?= esc_url($img['url']) ?>" alt="<?= esc_attr($img['alt']) ?>">
                <?php endif; ?>
                <div class="container relative z-2">
                    <div class="row gy-4 gx-5 justify-content-center">
                        <div class="col-lg-12 text-center">
                            <div class="spacer-double sm-hide"></div>
                            <h1 class="mb-3 wow fadeInUp" data-wow-delay=".2s"><?php single_cat_title(); ?></h1>
                            <div class="border-bottom mb-3"></div>
                            <?php if (function_exists('yoast_breadcrumb')) yoast_breadcrumb('<div id="breadcrumbs">','</div>'); ?>
                        </div>
                    </div>
                </div>
                <div class="sw-overlay"></div>
            </section>
            <!-- банер -->
            <!-- левый сайдбар и основной контент -->
            <section>
                <div class="container">
                    <div class="row g-4">

                        <? if($level>1) { ?> 
                        <!-- сайдбар с фильтром -->
                        <div class="col-lg-3">
                            <? if ( is_active_sidebar( 'sidebar-1' ) ) dynamic_sidebar( 'sidebar-1' ); ?>   
                        </div>
                        <!-- сайдбар с фильтром -->
                        <? } ?>

                        <!-- универсальный код для всех категорий -->
                        <? if($level==1) { ?> 
                        <div class="col-lg-12"> <!-- если Оборудование (уровень 1) выводим на всю ширину контейнера -->
                        <?} else {?>
                        <div class="col-lg-9"> <!-- все остальные категории - 9 колонок с учетом 3 сайдбара -->
                        <?}?>
                        <div class="row g-4">
                                    <?php
                                            $cat = get_queried_object();
                                            $parents = get_ancestors($cat->term_id, 'category');
                                            $level = count($parents) + 1;

                                            // Проверяем: если уровень = 2 и включен кастомный шаблон
                                            if ( get_field('is_template_product_cat', 'category_'.$cat->term_id)) {

                                                // Получаем дочерние категории
                                                $children = get_terms([
                                                    'taxonomy'   => 'category',
                                                    'hide_empty' => false,
                                                    'parent'     => $cat->term_id,
                                                ]);

                                                if (!empty($children) && !is_wp_error($children)) {

                                                    // Добавляем order в каждый объект
                                                    foreach ($children as &$child) {
                                                        $order = get_field('category_order', 'category_'.$child->term_id);
                                                        $child->order = ($order !== '' && $order !== null) ? intval($order) : null;
                                                    }
                                                    unset($child);

                                                    // Сортировка
                                                    usort($children, function($a, $b) {
                                                        if ($a->order === null && $b->order === null) {
                                                            return strcasecmp($a->name, $b->name);
                                                        }
                                                        if ($a->order === null) return 1;
                                                        if ($b->order === null) return -1;
                                                        if ($a->order === $b->order) {
                                                            return strcasecmp($a->name, $b->name);
                                                        }
                                                        return $a->order <=> $b->order;
                                                    });

                                                    if($level<3){
                                                    echo '<div class="col-lg-12"><div class="row g-4">';
                                                    foreach ($children as $child) {
                                                        if (get_field('is_template_product_cat', 'category_'.$child->term_id)) {
                                                            $link = get_term_link($child);
                                                            $img  = get_field('category_img', 'category_'.$child->term_id);
                                                            $img_url = $img ? $img['url'] : 'https://via.placeholder.com/400x300?text=No+Image';
                                                            ?>
                                                            <!-- одна категория -->
                                                            <div class="col-xl-3 col-lg-4 col-md-6 product_cat_item">
                                                                <div class="product_cat_item_wrap">
                                                                    <a href="<?php echo esc_url($link); ?>">
                                                                        <div class="product_cat_item_img" style="background-image:url('<?php echo esc_url($img_url); ?>');background-size:cover;background-repeat:no-repeat;"></div>
                                                                    </a>
                                                                    <div class="product_cat_item_title">
                                                                        <h3><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($child->name); ?></a></h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- одна категория -->
                                                            <?php
                                                        }
                                                    }
                                                    echo '</div></div>';
                                                    }
                                                }
                                            }
                                    ?>
                                    <!-- список товаров -->
                                    <? if($level>1) { ?> 
                                    <div class="col-lg-12">
                                            <div class="row g-4">
                                                <?php
                                                $term  = get_queried_object();
                                                $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

                                                // Основной аргумент WP_Query
                                                $args = [
                                                    'post_type'      => 'post',
                                                    'posts_per_page' => get_option('posts_per_page'),
                                                    'paged'          => $paged,
                                                    'tax_query'      => [
                                                        [
                                                            'taxonomy' => 'category',
                                                            'field'    => 'term_id',
                                                            'terms'    => $term->term_id,
                                                        ]
                                                    ],
                                                ];

                                                

                                                $query = new WP_Query($args);
                                                if ($query->have_posts()):
                                                    while ($query->have_posts()): $query->the_post();
                                                ?>
                                                <!-- 1 товар -->
                                                <div class="col-xl-3 col-lg-4 col-md-6 product_cat_item">
                                                    <div class="product_cat_item_wrap">
                                                        <?php if (has_post_thumbnail()): ?>
                                                        <a href="<?php the_permalink(); ?>">
                                                            <div class="product_cat_item_img" style="background-image: url(<?the_post_thumbnail_url('medium');?>);">
                                                                <?php if (get_field('product_sale')){?>
                                                                    <div class="product_cat_item_sale">Акция</div>
                                                                <?}?>
                                                            </div>
                                                        </a>
                                                        <?php endif; ?>
                                                        <div class="product_cat_item_title">
                                                            <h3>
                                                                <a  href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                            </h3>
                                                        </div>
                                                        <div class="product_cat_item_overlay">
                                                            <div class="product_cat_item_stock">
                                                                <?php if (get_field('product_stock')) { ?>
                                                                    <span>Статус: </span><strong>В НАЛИЧИИ.</strong>
                                                                <?} else {?>
                                                                    <span>Статус: </span><strong>НЕТ НА СКЛАДЕ.</strong>
                                                                <?}?>
                                                            </div>
                                                            <?php if (get_field('product_short_desc')): ?>
                                                            <div class="product_cat_item_short">
                                                                <?php the_field('product_short_desc') ?>                              
                                                            </div>
                                                            <?php endif; ?>                                 



                                                          
                                                            <!-- <div class="product_cat_item_manuf">
                                                                <strong>Производитель: </strong> 
                                                            </div>
                                                            <div class="product_cat_item_wish">
                                                                <span>Добавить в избранное: </span>
                                                                <img src="/wp-content/themes/ftechno/assets/images/ui/heart.svg" class="" alt="">
                                                            </div> -->


                                                            <div class="product_cat_item_order">
                                                                <a href="javascript:void(0)" class="main_form main_btn w-100">
                                                                    <span>СДЕЛАТЬ ЗАПРОС</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- 1 товар конец -->
                                                <?php endwhile; wp_reset_postdata(); else: ?>
                                                    <p>Нет товаров с такими характеристиками.</p>
                                                <?php endif; ?>
                                                <!-- пагинация -->
                                                <div class="col-lg-12 pt-4 text-center">
                                                    <div class="d-inline-block">
                                                        <?php
                                                        $paged = $query->get('paged') ? intval($query->get('paged')) : 1;
                                                        $max_page = $query->max_num_pages;
                                                        if ($max_page > 1):
                                                        ?>
                                                        <nav aria-label="Page navigation example">
                                                            <ul class="pagination">
                                                                <li class="page-item">
                                                                    <a class="page-link" href="<?php echo esc_url(add_query_arg($_GET, get_pagenum_link(max(1, $paged - 1)))); ?>" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-chevron-left"></i></span></a>
                                                                </li>
                                                                <?php for ($i = 1; $i <= $max_page; $i++): ?>
                                                                    <li class="page-item<?php echo ($i === $paged) ? ' active' : ''; ?>"<?php echo ($i === $paged) ? ' aria-current="page"' : ''; ?>><a class="page-link" href="<?php echo esc_url(add_query_arg($_GET, get_pagenum_link($i))); ?>"><?php echo $i; ?></a></li>
                                                                <?php endfor; ?>
                                                                <li class="page-item">
                                                                    <a class="page-link" href="<?php echo esc_url(add_query_arg($_GET, get_pagenum_link(min($max_page, $paged + 1)))); ?>" aria-label="Next"><span aria-hidden="true"><i class="fa fa-chevron-right"></i></span></a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <!-- пагинация конец -->
                                            </div>
                                    </div>
                                    <? } ?>
                                    <!-- список товаров -->
                                </div>
                            </div>
                        
                        <!-- универсальный код для всех категорий --> 
                    </div>
                </div>
            </section>
            <!-- левый сайдбар и основной контент конец -->
        </div>
<!-- content end -->
<?php
    } else {
        include_once __DIR__ . '/archive.php';
    }
}
?>

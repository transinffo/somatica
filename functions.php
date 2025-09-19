<?php
/**
 * ftechno functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ftechno
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

## добавляем опции для acf
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}

## старый вид страницы виджетов
add_filter( 'use_widgets_block_editor', '__return_false' );

## Отключает Гутенберг (новый редактор блоков в WordPress).
if( 'disable_gutenberg' ){
  add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );

// Move the Privacy Policy help notice back under the title field.
  add_action( 'admin_init', function(){
    remove_action( 'admin_notices', [ 'WP_Privacy_Policy_Content', 'notice' ] );
    add_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
  } );
}

## Разрешаем загрузку ico файла
add_filter( 'wp_check_filetype_and_ext', 'check_filetype_fix_mime_type_ico', 10, 5 );
function check_filetype_fix_mime_type_ico( $data, $file, $filename, $mimes, $real_mime = '' ){
  if( '.ico' === strtolower( substr($filename, -4) ) ){

    $data['ext']  = 'ico';
    $data['type'] = 'image/x-icon';
  }
  return $data;
}

## Разрешаем загрузку svg файла 1 часть
function allow_svg_upload($mimes) {
    if (current_user_can('administrator')) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
    }
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

## Разрешаем загрузку svg файла 2 часть
function fix_svg_check($data, $file, $filename, $mimes) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext === 'svg') {
        $data['ext'] = 'svg';
        $data['type'] = 'image/svg+xml';
    }
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'fix_svg_check', 10, 4);

## Подключаем файл переводов polylang
//require get_template_directory() . '/inc/translations.php';

## Транслитерация слага страниц, записей, рубрик
function transliterate_slug($string) {
    // Получаем тип записи
    $post_type = get_post_type();

    // Если это группа полей ACF, возвращаем оригинальный слаг без изменений
    if ($post_type === 'acf-field-group') {
        return $string; // Никаких изменений слага для ACF поля
    }

    // Декодируем URL-кодировку
    $decoded_string = urldecode($string);

    // Массивы для транслитерации
    $cyrillic = [
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
        'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
        'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
        'Є', 'І', 'Ї', 'Ґ', 'є', 'і', 'ї', 'ґ'
    ];
    $latin = [
        'A', 'B', 'V', 'G', 'D', 'E', 'E', 'ZH', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
        'R', 'S', 'T', 'U', 'F', 'KH', 'TS', 'CH', 'SH', 'SCH', '', 'Y', '', 'E', 'YU', 'YA',
        'a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
        'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'yu', 'ya',
        'Ye', 'I', 'Yi', 'G', 'ye', 'i', 'yi', 'g'
    ];

    // Замена кириллицы на латиницу
    $string = str_replace($cyrillic, $latin, $decoded_string);

    // Приведение строки к ASCII
    $ascii_string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);

    // Удаление недопустимых символов
    $sanitized_string = preg_replace('~[^A-Za-z0-9\-]~u', '-', $ascii_string);

    // Удаление лишних дефисов
    $cleaned_string = preg_replace('~-+~', '-', $sanitized_string);

    // Удаление дефисов с начала и конца строки
    $final_string = strtolower(trim($cleaned_string, '-'));

    return $final_string;
}

add_filter('sanitize_title', 'transliterate_slug', 999, 1);

##  автозаполнение атрибута href у ссылок с номером телефона
add_action('wp_footer', function () {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.tel').forEach(function (telElement) {
            var telNumber = telElement.textContent.replace(/\D/g, ''); // Извлекаем только цифры
            if (telNumber.startsWith('38')) {
                telNumber = telNumber.substring(2); // Убираем "38" в начале строки
            }
            telNumber = 'tel:+38' + telNumber; // Добавляем "tel:+38" в начале строки
            var nearestAnchor = telElement.closest('a'); // Находим ближайший тег "a"
            if (nearestAnchor) {
                nearestAnchor.setAttribute('href', telNumber); // Устанавливаем значение атрибута "href"
            }
        });
    });
    </script>
    <?
});

//главное меню начало
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

    // Начало уровня (подменю)
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul>\n";
    }

    // Конец уровня
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    // Элемент меню
    function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        // Если есть дочерние пункты
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-child';
        }

        $class_names = join( ' ', array_filter( $classes ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        // Ссылка
        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output  = '<a class="menu-item"' . $attributes . '>';
        $item_output .= $title;
        $item_output .= '</a>';

        // добавляем <span></span> только если есть дети
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<span></span>';
        }

        $output .= $item_output;
    }

    // Закрытие li
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}
//главное меню конец

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ftechno_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on ftechno, use a find and replace
		* to change 'ftechno' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ftechno', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'ftechno' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'ftechno_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ftechno_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ftechno_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ftechno_content_width', 640 );
}
add_action( 'after_setup_theme', 'ftechno_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ftechno_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ftechno' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ftechno' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ftechno_widgets_init' );


function my_enqueue_jquery_in_footer() {
    // Отключаем стандартный jQuery (если он уже подключается в хедере)
    wp_deregister_script('jquery');

    // Подключаем jQuery в футере
    wp_enqueue_script(
        'jquery',
        includes_url('/js/jquery/jquery.js'),
        [],     // зависимости отсутствуют
        false,  // версия по умолчанию
        true    // подключение в футере
    );
}
add_action('wp_enqueue_scripts', 'my_enqueue_jquery_in_footer', 1);



/**
 * Enqueue scripts and styles.
 */
function ftechno_scripts() {
wp_enqueue_style( 'ftechno-style', get_stylesheet_uri(), array(), _S_VERSION );
wp_enqueue_style('ftechno-bootstrap-min', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), _S_VERSION );
wp_enqueue_style('ftechno-plugins', get_template_directory_uri() . '/assets/css/plugins.css', array(), _S_VERSION );
wp_enqueue_style('ftechno-swiper', get_template_directory_uri() . '/assets/css/swiper.css', array(), _S_VERSION );
wp_enqueue_style('ftechno-custom-style', get_template_directory_uri() . '/assets/css/style.css', array(), _S_VERSION );
wp_enqueue_style('ftechno-custom-swiper-1', get_template_directory_uri() . '/assets/css/custom-swiper-1.css', array(), _S_VERSION );
wp_style_add_data( 'ftechno-style', 'rtl', 'replace' );


wp_enqueue_script('ftechno-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array(), _S_VERSION, true );
wp_enqueue_script('ftechno-designesia', get_template_directory_uri() . '/assets/js/designesia.js', array(), _S_VERSION, true );

wp_enqueue_script('ftechno-swiper', get_template_directory_uri() . '/assets/js/swiper.js', array(), _S_VERSION, true );
wp_enqueue_script('ftechno-custom-swiper-3', get_template_directory_uri() . '/assets/js/custom-swiper-3.js', array(), _S_VERSION, true );

wp_enqueue_script('ftechno-jquery-event-move', get_template_directory_uri() . '/assets/js/jquery.event.move.js', array(), _S_VERSION, true );
wp_enqueue_script('ftechno-jquery-twentytwenty', get_template_directory_uri() . '/assets/js/jquery.twentytwenty.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ftechno_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


//Галерея изображений товара
    // 1. Добавляем метабокс в сайдбар справа под featured image
    add_action('add_meta_boxes', 'custom_gallery_add_meta_box');
    function custom_gallery_add_meta_box() {
        add_meta_box(
            'custom_gallery_meta_box',
            'Галерея изображений',
            'custom_gallery_meta_box_callback',
            null,
            'side',
            'low'
        );
    }

    // 2. Callback: вывод галереи
    function custom_gallery_meta_box_callback($post) {
        $gallery = get_post_meta($post->ID, '_product_image_gallery', true);
        $image_ids = $gallery ? explode(',', $gallery) : [];

        wp_nonce_field('custom_gallery_nonce_action', 'custom_gallery_nonce');

        echo '<div id="custom-gallery-wrapper">';

        echo '<ul id="custom-gallery-images" style="margin:0;padding:0;list-style:none;display:flex;flex-wrap:wrap;gap:5px;cursor:move;flex-direction: column;align-content: space-around;">';
        foreach ($image_ids as $image_id) {
            $image_url = wp_get_attachment_thumb_url($image_id);
            if (!$image_url) continue;
            echo '<li style="position:relative;list-style:none;">';
            echo '<img src="' . esc_url($image_url) . '" class="custom-gallery-thumbnail" data-attachment-id="' . esc_attr($image_id) . '" style="max-width:150px;height:auto;display:block;margin-bottom:2px;cursor:pointer;" />';
            echo '<input type="hidden" name="custom_gallery_ids[]" value="' . esc_attr($image_id) . '">';
            echo '<button type="button" class="remove-gallery-image" style="position:absolute;top:0;right:0;background:#f00;color:#fff;border:none;cursor:pointer;padding:0 6px;line-height:18px;font-weight:bold;border-radius:2px;">×</button>';
            echo '</li>';
        }
        echo '</ul>';

        echo '<button type="button" class="button" id="custom-add-gallery-images">Добавить изображения</button>';

        echo '</div>';
    }

    // 3. Сохраняем при сохранении поста
    add_action('save_post', 'custom_gallery_save_meta_box');
    function custom_gallery_save_meta_box($post_id) {
        if (!isset($_POST['custom_gallery_nonce']) || !wp_verify_nonce($_POST['custom_gallery_nonce'], 'custom_gallery_nonce_action')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST['custom_gallery_ids']) && is_array($_POST['custom_gallery_ids'])) {
            $ids = array_map('intval', $_POST['custom_gallery_ids']);
            update_post_meta($post_id, '_product_image_gallery', implode(',', $ids));
        } else {
            delete_post_meta($post_id, '_product_image_gallery');
        }
    }

    // 4. Подключаем JS и jQuery UI sortable в админке
    function custom_gallery_enqueue_scripts() {
        wp_enqueue_script(
            'custom-gallery-js',
            get_template_directory_uri() . '/assets/js/custom-gallery.js',
            array('jquery', 'jquery-ui-sortable', 'media-editor', 'media-views'), // зависимости
            null,
            true // в footer
        );



        // Подключаем медиа-библиотеку WordPress
        if (is_admin()) {
            wp_enqueue_media();
        }
    }
    add_action('admin_enqueue_scripts', 'custom_gallery_enqueue_scripts');
//Галерея изображений товара



// === Подсчет просмотров ===
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Отслеживаем просмотр на странице записи
function track_post_views($post_id) {
    if (!is_single()) return; // только для одиночных постов
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    set_post_views($post_id);
}
add_action('wp_head', 'track_post_views');


// ajax search ----------------------------------------------------------------

// Функция для обработки Ajax-запросов поиска
function custom_ajax_search() {
    // Получаем поисковый запрос
    $search_query = sanitize_text_field($_POST['search_query']);

    // Лимит из настроек админки
    $posts_per_page = get_option('posts_per_page');

    // Находим записи и страницы, соответствующие запросу
    $args = array(
        's'                   => $search_query,
        'post_type'           => array('post', 'page'),
        'posts_per_page'      => $posts_per_page,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    );

    $query = new WP_Query($args);

    // Собираем результаты в массив
    $results = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // ключ массива = ID поста → дубликатов не будет
            $results[get_the_ID()] = array(
                'title'     => get_the_title(),
                'permalink' => get_permalink(),
            );
        }
    }

    wp_reset_postdata();

    // Отправляем только значения (без ключей-идшников)
    wp_send_json(array_values($results));

    wp_die();
}

// Регистрируем обработчик Ajax-запросов
add_action('wp_ajax_custom_ajax_search', 'custom_ajax_search');
add_action('wp_ajax_nopriv_custom_ajax_search', 'custom_ajax_search');

// Локализация переменной ajaxurl для использования на фронтенде
function custom_ajax_search_enqueue() {
    wp_enqueue_script(
        'custom-ajax-search',
        get_template_directory_uri() . '/assets/js/ajax-search.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script('custom-ajax-search', 'custom_ajax_search_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'custom_ajax_search_enqueue');
// ajax search ----------------------------------------------------------------



//список для главного пункта меню Склад
add_filter('wp_nav_menu_objects', function($items, $args) {
    foreach ($items as &$item) {
        // проверяем ID нужного пункта меню
        if ($item->ID == 2895) {

            // Запрос постов с ACF полем product_stock = 1
            $args_q = array(
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'meta_query'     => array(
                    array(
                        'key'   => 'product_stock',
                        'value' => 1,
                    ),
                ),
            );
            $q = new WP_Query($args_q);

            if ($q->have_posts()) {
                while ($q->have_posts()) {
                    $q->the_post();

                    // создаём объект подменю
                    $submenu = new \stdClass();
                    $submenu->ID = 100000 + get_the_ID(); // уникальный ID
                    $submenu->title = get_the_title();
                    $submenu->url = get_permalink();
                    $submenu->menu_item_parent = $item->ID; // привязка к 2895
                    $submenu->db_id = 0;
                    $submenu->object_id = get_the_ID();
                    $submenu->object = 'custom';
                    $submenu->type = 'custom';
                    $submenu->type_label = 'Custom Link';
                    $submenu->classes = array();

                    // добавляем в массив меню
                    $items[] = $submenu;
                }
                wp_reset_postdata();
            }
        }
    }
    return $items;
}, 10, 2);




add_action('init', function() {
    // Категория + тег (вложенность любая)
    add_rewrite_rule(
        '^product-category/(.+)/([a-z0-9-]+)/?$',
        'index.php?category_name=$matches[1]&tag_slugs=$matches[2]',
        'top'
    );
    // Только категория (вложенность любая)
    add_rewrite_rule(
        '^product-category/(.+)/?$',
        'index.php?category_name=$matches[1]',
        'top'
    );
});
add_filter('query_vars', function($vars) {
    $vars[] = 'tag_slugs';
    return $vars;
});


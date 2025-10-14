<div class="analizy-i-ceny">
	<div class="container">

		<div class="breadcrumbs">
			<?php
			if (function_exists('yoast_breadcrumb')) {
				yoast_breadcrumb('<div id="breadcrumbs" style="margin-left: 0px;">', '</div>');
			}
			?>
		</div>

		<div class="title_h1">
			<h1><?php single_term_title(); ?></h1>
		</div>

		<div class="pretext">
			<?php if (is_category()) echo term_description(); ?>
		</div>

		<div class="tabs">
			<!-- главные табы -->
			<ul class="tab-nav">
				<li class="active" data-tab="tab1" data-lang-uk="АНАЛІЗИ" data-lang-ru="АНАЛИЗЫ"></li>
				<li data-tab="tab2" data-lang-uk="ПАНЕЛІ" data-lang-ru="ПАНЕЛИ"></li>
				<li data-tab="tab3" data-lang-uk="КОМПЛЕКСИ" data-lang-ru="КОМПЛЕКСЫ"></li>
			</ul>
			<!-- /главные табы -->

			<?php
			// 🔹 1. Определяем язык Polylang
			$lang = function_exists('pll_current_language') ? pll_current_language() : 'uk';

			// 🔹 2. Базовые ID категорий (украинские)
			$ids = [
				'analyzes'  => 983,
				'panels'    => 991,
				'complexes' => 987,
			];

			// 🔹 3. Получаем ID категорий текущего языка
			if (function_exists('pll_get_term')) {
				foreach ($ids as $key => $term_id) {
					$translated_id = pll_get_term($term_id, $lang);
					if ($translated_id) $ids[$key] = $translated_id;
				}
			}

			// 🔹 4. Локализация таблицы
			$search_placeholder = ($lang === 'ru' || $lang === 'ru_RU') ? 'Искать...' : 'Шукати...';
			$list_headers = [
				'code'      => 'Код',
				'test_name' => ($lang === 'ru' || $lang === 'ru_RU') ? 'Название услуги' : 'Назва послуги',
				'termin'    => ($lang === 'ru' || $lang === 'ru_RU') ? 'Срок' : 'Термін',
				'sale'      => ($lang === 'ru' || $lang === 'ru_RU') ? 'Скидка' : 'Знижка',
				'cena'      => ($lang === 'ru' || $lang === 'ru_RU') ? 'Цена' : 'Ціна',
				'cart'      => '',
			];

			// 🔹 5. Функция вывода постов
			function show_posts_by_category($cat_id, $lang)
			{
				$terms = get_terms([
					'taxonomy'   => 'category',
					'parent'     => $cat_id,
					'hide_empty' => false,
				]);

				if (empty($terms)) {
					$terms = get_terms([
						'taxonomy'   => 'category',
						'include'    => [$cat_id],
						'hide_empty' => false,
					]);
				}

				foreach ($terms as $term) {
					echo '<div class="header-li"><span>' . esc_html($term->name) . '</span>';
					echo '<div class="header-li-content">';

					$posts = new WP_Query([
						'cat' => $term->term_id,
						'posts_per_page' => -1,
						'post_status' => 'publish',
					]);

					if ($posts->have_posts()) {
						while ($posts->have_posts()) {
							$posts->the_post();

							$code     = get_field('code');
							$termin   = get_field('termin');
							$cena_str = get_field('cena');
							$sale_str = get_field('sale');

							$cena_num = (float) preg_replace('/[^\d\.\,]/', '', $cena_str);
							$sale_num = (float) preg_replace('/[^\d\.\,]/', '', $sale_str);

							$cena_so_skidkoy = ($cena_num > 0 && $sale_num >= 0 && $sale_num <= 100)
								? $cena_num - ($cena_num * $sale_num / 100)
								: $cena_num;
							?>
							<ul class="elastic">
								<li class="code elastic_item"><p><?php echo esc_html($code); ?></p></li>
								<li class="test_name elastic_item">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</li>
								<li class="termin elastic_item">
									<?php if ($termin): ?>
										<img class="clock_icon" src="/wp-content/themes/qlab/assets/images/clock.svg" alt="clock">
									<?php endif; ?>
									<?php echo esc_html($termin); ?>
								</li>
								<li class="sale elastic_item"><p><?php echo esc_html($sale_str); ?></p></li>
								<li class="cena elastic_item">
									<div class="full_price"><del><?php if ($sale_str) echo esc_html($cena_str) . " ₴"; ?></del></div>
									<div class="sale_price"><b><?php echo number_format($cena_so_skidkoy, 2, ',', ' '); ?> ₴</b></div>
								</li>
								<li class="cart elastic_item">
									<font class="mob_code">Код: <?php echo esc_html($code); ?></font>
									<a href="#" class="add-to-cart"
									   data-id="<?php the_ID(); ?>"
									   data-title="<?php the_title(); ?>"
									   data-code="<?php the_field('code'); ?>"
									   data-cena="<?php the_field('cena'); ?>"
									   data-sale="<?php the_field('sale'); ?>">
										<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
										<font data-lang-uk="У кошик" data-lang-ru="В корзину"></font>
									</a>
								</li>
							</ul>
							<?php
						}
						wp_reset_postdata();
					} else {
						echo '<p data-lang-uk="Немає записів" data-lang-ru="Нет записей"></p>';
					}

					echo '</div></div>';
				}
			}
			?>

			<div class="tab-content">
				<?php
				$i = 1;
				foreach ($ids as $key => $cat_id): ?>
					<div id="tab<?= $i ?>" class="tab-item<?= $i == 1 ? ' active' : '' ?>">
						<div class="table_wrap">
							<div class="form_search">
								<label class="text_serch">
									<input type="text" class="search_input" placeholder="<?= esc_attr($search_placeholder) ?>">
								</label>
							</div>
							<ul class="list_price">
								<?php foreach ($list_headers as $header): ?>
									<li><?= esc_html($header) ?></li>
								<?php endforeach; ?>
							</ul>
							<div class="wrapper-boxes">
								<?php show_posts_by_category($cat_id, $lang); ?>
							</div>
						</div>
					</div>
				<?php $i++;
				endforeach; ?>
			</div>
		</div>
	</div>
</div>




<script>
	//обработка главных табов
	$(document).ready(function() {
		$('.tab-nav li').on('click', function() {
			const tabId = $(this).data('tab');

	    // Активируем нужную вкладку
	    $('.tab-nav li').removeClass('active');
	    $(this).addClass('active');

	    // Плавно скрываем все табы
	    $('.tab-item.active').fadeOut(200, function() {
	    	$(this).removeClass('active');

	      // Показываем нужный таб
	      $('#' + tabId).fadeIn(200).addClass('active');
	  });
	});
	});


	//обработка внутренних спойлеров анализов
	document.addEventListener("DOMContentLoaded", function () {
		// Универсальный обработчик: если клик НЕ внутри .header-li-content -> toggle .header-li
		document.addEventListener('click', function (e) {
			// Если клик был внутри контента спойлера — выходим, не трогаем active
			if (e.target.closest('.header-li-content')) {
				return;
			}

			// Иначе, если клик был по .header-li (заголовок или его дети вне .header-li-content) — переключаем
			const header = e.target.closest('.header-li');
			if (header) {
				header.classList.toggle('active');
			}
		});
	});


	//поиск через инпут и по алфавиту
	$(document).ready(function() {
		var lang = $('html').attr('lang');
		var alphabet = [];
		var ukAlphabet = [
		'А','Б','В','Г','Ґ','Д','Е','Є','Ж','З','И','І','Ї','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ь','Ю','Я'
		];
		var ruAlphabet = [
		'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
		];
		if(lang === 'uk') alphabet = ukAlphabet;
		else if(lang === 'ru-RU' || lang === 'ru') alphabet = ruAlphabet;
		else alphabet = ukAlphabet;

		console.log(lang);
		console.log(alphabet);

	    // Генерация алфавита с классами "black" для каждой .table_wrap
	    function getAlphabetBar($tableWrap) {
	    	var lang = $('html').attr('lang');
	    	var usedLetters = {};
	    	var originalHtml = $tableWrap.find('.wrapper-boxes').data('original');
	    	var $originalWrapper = originalHtml ? $(originalHtml) : $tableWrap.find('.wrapper-boxes');
	    	$originalWrapper.find('.test_name.elastic_item').each(function() {
	    		var txt = $(this).text().trim().toUpperCase();
	    		var first = txt.charAt(0);
	    		usedLetters[first] = true;
	    	});
	    	var $alphaDiv = $('<div class="alphabet-bar"></div>');
		    // Добавляем кнопку "Всі" или "Все" перед алфавитом
		    var allText = (lang === 'ru' || lang === 'ru-RU') ? 'Все' : 'Всі';
		    $alphaDiv.append('<span class="alphabet-letter all active" data-letter="all">'+allText+'</span>');
		    // Алфавит
		    $.each(alphabet, function(_, letter) {
		    	var className = 'alphabet-letter';
		    	if (usedLetters[letter]) className += ' black';
		    	$alphaDiv.append('<span class="'+className+'" data-letter="'+letter+'">'+letter+'</span>');
		    });
		    return $alphaDiv;
		}

	    // Вставка алфавита после каждой .form_search
	    $('.form_search').each(function() {
	    	var $tableWrap = $(this).closest('.table_wrap');
	        // Сохраняем оригинал при инициализации
	        var $wrapper = $tableWrap.find('.wrapper-boxes');
	        if (!$wrapper.data('original')) $wrapper.data('original', $wrapper.html());
	        $(this).after(getAlphabetBar($tableWrap));
	    });

	    // Общая функция поиска
			function performSearch($tableWrap, searchQuery, searchType) {
			    var $wrapper = $tableWrap.find('.wrapper-boxes');
			    // ВСЕГДА работаем с оригиналом!
			    var originalHtml = $wrapper.data('original');
			    if (!originalHtml) {
			        $wrapper.data('original', $wrapper.html());
			        originalHtml = $wrapper.html();
			    }
			    var $originalWrapper = $(originalHtml);

			    // Возврат к оригиналу при сбросе поиска
			    if ((searchType === 'input' && searchQuery.length < 3) || (searchType === 'reset')) {
			        $wrapper.html(originalHtml);
			        
			        // 1. !!! ДОБАВЛЕНО: Вызов перевода при сбросе !!!
			        applyLanguageTranslation(); 
			        
			        // Обновить алфавит
			        $tableWrap.find('.alphabet-bar').replaceWith(getAlphabetBar($tableWrap));
			        return;
			    }

			    var results = [];
			    $originalWrapper.find('.test_name.elastic_item').each(function() {
			        var $item = $(this);
			        var text = $item.text().trim();
			        if (
			            (searchType === 'input' && text.toLowerCase().indexOf(searchQuery.toLowerCase()) !== -1)
			            ||
			            (searchType === 'alpha' && text.toUpperCase().startsWith(searchQuery.toUpperCase()))
			        ) {
			            results.push($item.closest('ul.elastic').clone());
			        }
			    });

			    var $newWrapper = $('<div class="header-li"><div class="header-li-content search_results"></div></div>');
			    var $content = $newWrapper.find('.header-li-content');
			    var lang = $('html').attr('lang'); // Нужно получить lang здесь, чтобы использовать его
			    
			    if (results.length) {
			        results.forEach(function($ul) { $content.append($ul); });
			    } else {
			        var notFoundText = (lang === 'ru' || lang === 'ru_RU') ? 'Ничего не найдено' : 'Нічого не знайдено';
			        // !!! ВАЖНО: Добавим data-lang-* атрибуты, чтобы applyLanguageTranslation сработала
			        var notFoundHtml = '<p data-lang-uk="Нічого не знайдено" data-lang-ru="Ничего не найдено">' + notFoundText + '</p>';
			        $content.html(notFoundHtml);
			    }
			    
			    // 2. !!! ДОБАВЛЕНО: Вызов перевода для нового контента перед вставкой !!!
			    // Вызываем applyLanguageTranslation на $newWrapper, чтобы перевести его до вставки.
			    // Если applyLanguageTranslation работает со всем DOM, это сработает, но лучше
			    // запустить ее после вставки в DOM, чтобы она видела все элементы.
			    $wrapper.html($newWrapper); // Сначала вставляем в DOM

			    // Теперь, когда элементы в DOM, запускаем перевод.
			    applyLanguageTranslation();

			}

	    // Поиск по полю
	    $('.form_search .search_input').on('input focus', function() {
	    	var $input = $(this);
	    	var query = $input.val().trim();
	    	var $tableWrap = $input.closest('.table_wrap');
	    	clearTimeout($input.data('search-timer'));
	    	$input.data('search-timer', setTimeout(function() {
	    		performSearch($tableWrap, query, 'input');
	    		$tableWrap.find('.alphabet-letter').removeClass('active');
	    	}, 400));
	    });

		// Поиск/сброс по букве и по "Всі"/"Все"
		$(document).on('click', '.alphabet-letter', function() {
			var $letter = $(this);
			var letter = $letter.data('letter');
			var $tableWrap = $letter.closest('.table_wrap');
			$tableWrap.find('.search_input').val('');
			$tableWrap.find('.alphabet-letter').removeClass('active');
			if (letter === 'all') {
		        // Сброс поиска, возврат к оригиналу
		        performSearch($tableWrap, '', 'reset');
		        $letter.addClass('active');
		    } else {
		    	$letter.addClass('active');
		    	performSearch($tableWrap, letter, 'alpha');
		    }
		});

	    // Обновить алфавит при сбросе через "ничего не найдено"
	    $(document).on('click', '.search_results p', function() {
	    	var $tableWrap = $(this).closest('.table_wrap');
	    	$tableWrap.find('.alphabet-bar').replaceWith(getAlphabetBar($tableWrap));
	    });
	});



</script>

<div class="analizy-i-ceny">
	<div class="container">
		<div class="breadcrumbs">
			<?php
			if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<div id="breadcrumbs" style="margin-left: 0px;">','</div>');
			}
			?>
		</div>
		<div class="title_h1">
			<h1><?php single_term_title();  ?></h1>
		</div>

		<div class="pretext">
			<? if ( is_category() )  echo term_description(); ?>
		</div>


		<div class="tabs">
			<!-- главные табы --> 
			<ul class="tab-nav">
				<li class="active" data-tab="tab1">АНАЛИЗЫ</li>
				<li data-tab="tab2">ПАНЕЛИ</li>
				<li data-tab="tab3">КОМПЛЕКСЫ</li>
			</ul>
			<!-- главные табы -->

			<div class="tab-content">
				<!-- таб для АНАЛИЗЫ -->
				<div id="tab1" class="tab-item active">
					<div class="table_wrap">
						<div class="form_search">
							<label class="text_serch">
								<input type="text" class="search_input" placeholder="Шукати...">
							</label>
						</div>
						<ul class="list_price">
							<li class="code">Код</li>
							<li class="test_name">Назва послуги</li>
							<li class="termin">Термін</li>
							<li class="sale">Знижка</li>
							<li class="cena">Ціна</li>
							<li class="cart"></li>
						</ul>
						<div class="wrapper-boxes">
							<div  class="header-li"><span>АНАЛИЗЫ 1</span>
								<div class="header-li-content">
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">яблоко в анализах Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet facere illo, veniam perspiciatis voluptate ab minima ex maxime at placeat vitae laboriosam dignissimos sequi temporibus alias excepturi. Delectus, omnis! Possimus.</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">груша Lorem ipsum dolor</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>																				
								</div>
							</div>
							<div  class="header-li"><span>АНАЛИЗЫ 11</span>
								<div class="header-li-content">
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">персик Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet facere illo, veniam perspiciatis voluptate ab minima ex maxime at placeat vitae laboriosam dignissimos sequi temporibus alias excepturi. Delectus, omnis! Possimus яблоко в анализах .</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>    	
				</div>
				<!-- таб для АНАЛИЗЫ -->

				<!-- таб для ПАНЕЛИ -->
				<div id="tab2" class="tab-item">
					<div class="table_wrap">
						<div class="form_search">
							<label class="text_serch">
								<input type="text" class="search_input" placeholder="Шукати...">
							</label>
						</div>
						<ul class="list_price">
							<li class="code">Код</li>
							<li class="test_name">Назва послуги</li>
							<li class="termin">Термін</li>
							<li class="sale">Знижка</li>
							<li class="cena">Ціна</li>
							<li class="cart"></li>
						</ul>
						<div class="wrapper-boxes">
							<div  class="header-li"><span>ПАНЕЛИ 1</span>
								<div class="header-li-content">
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">малина Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet facere illo, veniam perspiciatis voluptate ab minima ex maxime at placeat vitae laboriosam dignissimos sequi temporibus alias excepturi. Delectus, omnis! Possimus.</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">ежевика Lorem ipsum dolor</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>																				
								</div>
							</div>
							<div  class="header-li"><span>ПАНЕЛИ 11</span>
								<div class="header-li-content">
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">черника Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet facere illo, veniam perspiciatis voluptate ab minima ex maxime at placeat vitae laboriosam dignissimos sequi temporibus alias excepturi. Delectus, omnis! Possimus.</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>    	
				</div>
				<!-- таб для ПАНЕЛИ -->

				<!-- таб для КОМПЛЕКСЫ -->
				<div id="tab3" class="tab-item">
					<div class="table_wrap">
						<div class="form_search">
							<label class="text_serch">
								<input type="text" class="search_input" placeholder="Шукати...">
							</label>
						</div>
						<ul class="list_price">
							<li class="code">Код</li>
							<li class="test_name">Назва послуги</li>
							<li class="termin">Термін</li>
							<li class="sale">Знижка</li>
							<li class="cena">Ціна</li>
							<li class="cart"></li>
						</ul>
						<div class="wrapper-boxes">
							<div  class="header-li"><span>КОМПЛЕКСЫ 1</span>
								<div class="header-li-content">
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">арбуз Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet facere illo, veniam perspiciatis voluptate ab minima ex maxime at placeat vitae laboriosam dignissimos sequi temporibus alias excepturi. Delectus, omnis! Possimus яблоко в комплексах.</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">дыня Lorem ipsum dolor</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>																				
								</div>
							</div>
							<div  class="header-li"><span>КОМПЛЕКСЫ 11</span>
								<div class="header-li-content">
									<ul class="elastic">
										<li class="code elastic_item">
											<p>1091</p>
										</li>
										<li class="test_name elastic_item">
											<a href="/">манго Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet facere illo, veniam perspiciatis voluptate ab minima ex maxime at placeat vitae laboriosam dignissimos sequi temporibus alias excepturi. Delectus, omnis! Possimus.</a>
										</li>
										<li class="termin elastic_item">
											<p>1 р.д.</p>
										</li>
										<li class="sale elastic_item">
											<p>10%</p>
										</li>										
										<li class="cena elastic_item">
											<div class="full_price"><del>200,00 ₴</del></div>
											<div class="sale_price"><b>150,00 ₴</b></div>
										</li>
										<li class="cart elastic_item">
											<font class="mob_code">Код: 1091</font>
											<a href="#">
												<img src="/wp-content/themes/qlab/assets/images/cart.svg" alt="">
												<font>У кошик</font>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>    	
				</div>
				<!-- таб для КОМПЛЕКСЫ -->

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
    else if(lang === 'ru_RU' || lang === 'ru') alphabet = ruAlphabet;
    else alphabet = ukAlphabet;

    // Генерация алфавита с классами "black" для каждой .table_wrap
    function getAlphabetBar($tableWrap) {
        var usedLetters = {};
        // ВАЖНО: всегда искать по оригинальной разметке!
        var originalHtml = $tableWrap.find('.wrapper-boxes').data('original');
        var $originalWrapper = originalHtml ? $(originalHtml) : $tableWrap.find('.wrapper-boxes');
        $originalWrapper.find('.test_name.elastic_item').each(function() {
            var txt = $(this).text().trim().toUpperCase();
            var first = txt.charAt(0);
            usedLetters[first] = true;
        });
        var $alphaDiv = $('<div class="alphabet-bar"></div>');
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
        if (results.length) {
            results.forEach(function($ul) { $content.append($ul); });
        } else {
            var notFoundText = (lang === 'ru' || lang === 'ru_RU') ? 'Ничего не найдено' : 'Нічого не знайдено';
            $content.html('<p>' + notFoundText + '</p>');
        }
        $wrapper.html($newWrapper);
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

    // Поиск/сброс по букве
    $(document).on('click', '.alphabet-letter', function() {
        var $letter = $(this);
        var letter = $letter.data('letter');
        var $tableWrap = $letter.closest('.table_wrap');
        var wasActive = $letter.hasClass('active');
        $tableWrap.find('.search_input').val('');
        if (wasActive) {
            $tableWrap.find('.alphabet-letter').removeClass('active');
            performSearch($tableWrap, '', 'reset');
        } else {
            $tableWrap.find('.alphabet-letter').removeClass('active');
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

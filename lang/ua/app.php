<?php
return [

    'app_title' => 'Академічні Тексти України',
    'locale_version' => 'English version',
    'locale_version_code' => 'en',
    'work_locale_version' => 'English version',

    'placeholder_search' => 'Фраза для пошуку',

    'caption_okd_research_for' => 'Дисертація на здобуття ступеня ',
    'caption_okd_type_research' => [
        4 => 'кандидата наук',
        5 => 'доктора наук',
        8 => 'доктора філософії',
    ],

    'caption_author' => 'Здобувач',
    'caption_speciality' => 'Спеціальність',
    'caption_date_defense' => 'Дата захисту',
    'caption_registration_number' => 'Державний реєстраційний номер',
    'caption_spec' => 'Спеціалізована вчена рада',
    'caption_essay' => 'Анотація',
    'caption_supervisor' => 'Керівник роботи',
    'caption_opponents' => 'Офіційні опоненти',
    'caption_reviewers' => 'Рецензенти',
    'caption_advisors' => 'Консультанти',
    'caption_connection' => 'Зв\'язок з науковими темами',
    'caption_biblos' => 'Публікації',
    'caption_files' => 'Файли',
    'caption_file_okd' => 'Облікова картка дисертації',
    //connection with scientific topics
    'caption_similar' => 'Схожі дисертації',

    'link_download' => 'Завантажити',

    'meta_okd_keywords' => 'дисертація, повний текст, автореферат, анотація, завантажити, дисертації :year, :author, :theme',
    'meta_okd_og_title' => 'Дисертація: :theme',
    'meta_okd_description' => 'Дисертація на тему: :theme',
    'meta_okd_og_description' => 'Повний текст, реферат, анотація. Завантажити дисертацію у форматі PDF',
    'meta_og_locale' => 'uk_UA',

    'message_download_error' => 'Сталася помилка під час завантаження цього файлу',

    //Common
    'common_title' => 'Дисертації та автореферати України. Академічні тексти України: дисертації, звіти, статті, монографії - uacademic.info',
    'common_keywords' => 'каталог дисертацій, каталог авторефератів, дисертація, повний текст, автореферат, дисертації :year, академічні тексти, завантажити дисертацію, автореферат дисертації, тема, наукові звіти, монографії, наукові тексти, uacademic',
    'common_description' => 'Каталог дисертацій та авторефератів України. Пошук академічних текстів України: повні тексти дисертацій, атореферати, звіти, монографії. Доступ до наукових робіт для науковців та дослідників',

    '404_subheader' => 'Сторінку не знайдено',
    '404_text' => 'Скоріше за все ця сторінка була переміщена або видалена.<br>Можливо, Ви помилилися при вводі адреси. Превірте її будь ласка ще раз.',
    '404_text_2' => 'Ви можете повернутися на головну сторінку сайту або знайти те, що Вам потрібно за допомогою пошуку.',

    'button_home' => 'На головну',
    'button_search' => 'До пошуку',
    'botton_read_more' => 'Читати повністю',


    //Index
    'index_welcome_header' => 'Вітаємо, науковці!',
    'index_text_1' => '<p class="fs-5">Ласкаво просимо на наш сайт академічних текстів України.</p><p class="fs-5">Тут ви знайдете повні тексти дисертацій, автореферати, анотації, наукові звіти для ваших наукових досліджень. А найголовніше, що все це - <span class="fw-bold">абсолютно безкоштовно!</span></p><p class="fs-5">Каталог дисертацій, авторефератів та наукових звітів постійно оновлюється, а наш потужний пошук забезпечить найточніші результати для ваших пошукових запитів.</p>',
    'index_text_2' => 'Разом ми досягнемо нових висот в науковому світі!',
    'index_last_diser' => 'Останні дисертації',


    //Search
    'search_title' => 'Академічні тексти України: розширений пошук - uacademic.info',
    'search_heading_formalized' => 'Формалізований пошук',
    'search_heading_advanced' => 'Пошук з уточненням',

    'search_label_document_type' => 'Тип документів',
    'search_document_types' => [
        // 'all' => 'Всі',
        'okd' => 'Дисертації',
        // 'ok' => 'Звіти з НДДКР',
    ],
    'search_label_person_name' => 'Прізвище, ім\'я',
    'search_label_theme' => 'Назва / опис документа',
    'search_label_content' => 'Зміст повного тексту',
    'search_label_regno' => 'Реєстраційний номер',
    'search_label_date_from' => 'Дата реєстрації з',
    'search_label_date_to' => 'Дата реєстрації до',
    'search_label_sort' => 'Сортування',
    'search_sort_types' => [
        'registration_date' => 'За датою реєстрації',
        'author' => 'За прізвищем',
        'score' => 'За відповідністю',
    ],
    'search_label_search_text' => 'Текст для пошуку',
    'search_button_search' => 'Шукати',
    'search_link_search' => 'Пошук',
    'search_button_clear' => 'Очистити форму',

    'search_result_header' => 'Результати пошуку',
    'search_result_total' => '{1} Знайдено :value запис|[2,4] Знайдено :value записи||[5,9] Знайдено :value записів|{0} Знайдено :value записів',
    'search_no_result' => 'Нічого не знайдено',
    'search_limited' => 'Кількість результатів обмежена. Уточніть пошукові дані',

    'fields' => [
        'persons.person_names.name_full' => 'Науковці',
        'full_texts.full_text' => 'Повний текст',
        'description.description_text' => 'Назва, реферат/анотація',
    ],

    'start_by_searching' => 'Почніть роботу з пошуку',

];

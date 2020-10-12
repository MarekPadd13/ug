<?php
return Yii::$app->user->can('News_redactor') ? (
array_merge(
    [['label' => 'Новости', 'url' => '#',
        'items' => array_merge([
         ['label' => 'Добавить новость', 'url' => '/news/default/create'],
            ['label' => 'Редактирование новостей', 'url' => '/news/default/index'],
        ])]],
    [['label' => 'Документы и ссылки', 'url' => '#',
        'items' => array_merge([
            ['label' => 'Категории', 'url' => '/doclinks/categories/index'],
            ['label' => 'Добавить ссылки', 'url' => '/doclinks/links/index'],
            ['label' => 'Добавить документы', 'url' => '/doclinks/documents/index'],
        ])]],
            [['label' => 'Рассылка', 'url' => '#',
        'items' => array_merge([
            ['label' => 'Шаблоны', 'url' => '/sending/template'],
                ['label' => 'Модерация рассылки', 'url' => '/sending/send'],
                ['label'=> 'Опросы', 'url'=> '/sending/polls/'],
                ['label'=> 'Варианты ответов на опросы', 'url'=> '/sending/dict-poll-answer/'],
        ])]]
)):[];

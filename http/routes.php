<?php

//> ADMIN
Route::get('/админ', '/admin/index@index'); 
Route::get('админ/профиль', '/admin/index@profile'); 

Route::post('/back/admin/profile/edit', '/admin/index@edit'); 
//< ADMIN


//>Страницы сайта
//Главная
Route::get('/', 'index@home');
Route::get('/кухни', 'index@index2');
Route::get('/преимущества', 'index@advantages');
Route::get('/материалы', 'index@materials');
Route::get('/фурнитура', 'index@blum');
Route::get('/калькулятор', 'index@calc');
Route::get('/отзывы', 'index@comments');
Route::get('/о-компании', 'index@company');
Route::get('/контакты', 'index@form');
Route::get('/акция', 'index@podarok');
Route::get('/подарок', 'index@podarok');
Route::get('/портфолио', 'index@work');

//Загрузка файлов
Route::post('/upload', 'index@upload');

Route::post('/mail', 'mail@mail');
//<Страницы сайта




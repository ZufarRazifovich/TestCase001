<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UrlController;


Route::get('/status',      [NewsController::class, 'status']);         //создание новости

Route::post('/createUrl',      [UrlController::class, 'createUrlPost']);         //создание новости
Route::post('/urls',            [UrlController::class, 'showUrlsPost']);         //создание новости
Route::post('/geturlchecks',    [UrlController::class, 'getChecksPost']);         //создание новости

Route::post('/updateNews',      [NewsController::class, 'postUpdateNews']);         //обновление
Route::post('/deleteNews',      [NewsController::class, 'postDeleteNews']);         //удаление
Route::get('/news',             [NewsController::class, 'getNews']);                //все новости
Route::post('/fullNews',        [NewsController::class, 'postFullNews']);           //новость по id

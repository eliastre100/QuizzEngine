<?php

use Core\Route;
use Core\Router;

Router::base('');

Route::get('/', 'SessionController#new');
Route::get('/login', 'SessionController#new');
Route::post('/login', 'SessionController#create');
Route::get('/logout', 'SessionController#destroy');

Route::get('/register', 'UsersController#new');
Route::post('/register', 'UsersController#create');

Route::get('/student/dashboard', 'StudentDashboardController#index', ['ROLE_USER', 'ROLE_TEACHER']);

Route::get('/student/test/:id', 'TestAttemptsController#new', ['ROLE_USER', 'ROLE_TEACHER']);
Route::post('/student/test/:id', 'TestAttemptsController#create', ['ROLE_USER', 'ROLE_TEACHER']);
Route::get('/student/test/:test_id/attempt/:attempt_id', 'AnswersController#new', ['ROLE_USER', 'ROLE_TEACHER']);
Route::post('/student/test/:test_id/attempt/:attempt_id', 'AnswersController#create', ['ROLE_USER', 'ROLE_TEACHER']);
Route::get('/student/test/:test_id/attempt/:attempt_id/results', 'TestAttemptsController#show', ['ROLE_USER', 'ROLE_TEACHER']);

Route::get('/teacher/dashboard', 'TeacherDashboardController#index', ['ROLE_TEACHER']);

Route::get('/teacher/test/new', 'TestsController#new', ['ROLE_TEACHER']);
Route::post('/teacher/test', 'TestsController#create', ['ROLE_TEACHER']);
Route::get('/teacher/test/:id', 'TestsController#show', ['ROLE_TEACHER']);
Route::get('/teacher/test/:id/edit', 'TestsController#edit', ['ROLE_TEACHER']);
Route::post('/teacher/test/:id', 'TestsController#update', ['ROLE_TEACHER']);
Route::get('/teacher/test/:id/results', 'TestAttemptsController#index', ['ROLE_TEACHER']);
Route::get('/teacher/test/:id/destroy', 'TestsController#destroy', ['ROLE_TEACHER']);

Route::get('/teacher/test/:test_id/attempt/:attempt_id/reopen', 'TestAttemptsController#reopen', ['ROLE_TEACHER']);

Route::get('/teacher/test/:test_id/question/new', 'QuestionsController#new', ['ROLE_TEACHER']);
Route::post('/teacher/test/:test_id/question', 'QuestionsController#create', ['ROLE_TEACHER']);
Route::get('/teacher/test/:test_id/question/:id/destroy', 'QuestionsController#destroy', ['ROLE_TEACHER']);
Route::get('/teacher/test/:test_id/question/:id/edit', 'QuestionsController#edit', ['ROLE_TEACHER']);
Route::post('/teacher/test/:test_id/question/:id', 'QuestionsController#update', ['ROLE_TEACHER']);
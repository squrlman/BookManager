<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('authors',  ['uses' => 'AuthorsController@showAllAuthors']);
    $router->get('authors/{id}', ['uses' => 'AuthorsController@getAuthor']);
    $router->post('authors/create', ['uses' => 'AuthorsController@create']);
    $router->delete('authors/delete/{id}', ['uses' => 'AuthorsController@delete']);
    $router->put('authors/update/{id}', ['uses' => 'AuthorsController@update']);

    $router->post('authors/readCSV',['uses' => 'AuthorsController@uploaded_csv']);

    /* Book routes*/
    $router->get('books',['uses' => 'BooksController@all']);
    $router->get('books/{id}',['uses' => 'BooksController@getbook']);
    $router->post('books/create_bk',['uses' => 'BooksController@create']);
    $router->delete('books/delete_bk/{id}',['uses' => 'BooksController@delete']);
    $router->put('books/update_bk/{id}',['uses' => 'BooksController@update']);

    $router->get('books/search/{isbn}/{sort}',['uses' => 'BooksController@searchBooksISBN']);
    $router->get('books/searchauthor/{name}/{sort}',['uses' => 'BooksController@searchBooksAuthor']);

    $router->post('books/readCSV',['uses' => 'BooksController@uploaded_csv']);

    /* Magazine routes*/

    /*Search queries*/
    $router->get('magazines/search/{isbn}/{sort}',['uses' => 'MagazinesController@searchISBN']);
    $router->get('magazines/searchauthor/{name}/{sort}',['uses' => 'MagazinesController@searchAuthor']);

    $router->get('magazines',['uses' => 'MagazinesController@all']);
    $router->get('magazines/{id}',['uses' => 'MagazinesController@getMagazines']);
    $router->post('magazines/create',['uses' => 'MagazinesController@create']);
    $router->delete('magazines/delete/{id}',['uses' => 'MagazinesController@delete']);
    $router->put('magazines/update/{id}',['uses' => 'MagazinesController@update']);

    /*CSV UPLOAD*/
    $router->post('magazines/readCSV',['uses' => 'MagazinesController@uploaded_csv']);

});

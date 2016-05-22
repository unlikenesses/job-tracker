<?php

Route::group(['middleware' => 'web'], function() {
    
    Route::auth();

    Route::get('/', 'HomeController@index');
    Route::get('about-us', 'HomeController@about_us');

    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {


        Route::get('/', 'AdminController@index');

        Route::post('sort', 'AdminController@sort');

        Route::get('text/{id}', 'TextController@edit');
        Route::patch('text/{id}', 'TextController@update');

        Route::get('jobs', 'JobsController@index');
        Route::get('jobs/open', 'JobsController@open');
        Route::get('jobs/completed', 'JobsController@completed');
        Route::get('jobs/create', 'JobsController@create');
        Route::post('jobs', 'JobsController@store');
        Route::get('jobs/{id}/edit', 'JobsController@edit');
        Route::patch('jobs/{id}', 'JobsController@update');
        Route::get('jobs/{id}/delete', 'JobsController@confirmDelete');
        Route::delete('jobs/{id}', 'JobsController@destroy');

        Route::get('invoices', 'InvoicesController@index');
        Route::get('invoices/overdue', 'InvoicesController@overdue');
        Route::get('invoices/not-due', 'InvoicesController@not_due');
        Route::get('invoices/{id}/export', 'InvoicesController@export');
        Route::get('invoices/create', 'InvoicesController@create');
        Route::post('invoices', 'InvoicesController@store');
        Route::get('invoices/{id}/edit', 'InvoicesController@edit');
        Route::patch('invoices/{id}', 'InvoicesController@update');
        Route::get('invoices/{id}/delete', 'InvoicesController@confirmDelete');
        Route::delete('invoices/{id}', 'InvoicesController@destroy');

        Route::get('clients', 'ClientsController@index');
        Route::get('clients/create', 'ClientsController@create');
        Route::post('clients', 'ClientsController@store');
        Route::get('clients/{id}/edit', 'ClientsController@edit');
        Route::patch('clients/{id}', 'ClientsController@update');
        Route::get('clients/{id}/delete', 'ClientsController@confirmDelete');
        Route::delete('clients/{id}', 'ClientsController@destroy');

        Route::get('projects', 'ProjectsController@index');
        Route::get('projects/create', 'ProjectsController@create');
        Route::post('projects', 'ProjectsController@store');
        Route::get('projects/{id}/edit', 'ProjectsController@edit');
        Route::patch('projects/{id}', 'ProjectsController@update');
        Route::get('projects/{id}/delete', 'ProjectsController@confirmDelete');
        Route::delete('projects/{id}', 'ProjectsController@destroy');

        Route::get('currencies', 'CurrenciesController@index');
        Route::get('currencies/create', 'CurrenciesController@create');
        Route::post('currencies', 'CurrenciesController@store');
        Route::get('currencies/{id}/edit', 'CurrenciesController@edit');
        Route::patch('currencies/{id}', 'CurrenciesController@update');
        Route::get('currencies/{id}/delete', 'CurrenciesController@confirmDelete');
        Route::delete('currencies/{id}', 'CurrenciesController@destroy');

        Route::get('users', 'UsersController@index');
        Route::get('users/create', 'UsersController@create');
        Route::post('users', 'UsersController@store');

        Route::get('profile', 'UsersController@editProfile');
        Route::patch('profile', 'UsersController@updateProfile');

    });
});

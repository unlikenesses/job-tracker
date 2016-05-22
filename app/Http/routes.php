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
        Route::get('jobs/{job}/edit', 'JobsController@edit');
        Route::patch('jobs/{job}', 'JobsController@update');
        Route::get('jobs/{job}/delete', 'JobsController@confirmDelete');
        Route::delete('jobs/{job}', 'JobsController@destroy');

        Route::get('invoices', 'InvoicesController@index');
        Route::get('invoices/overdue', 'InvoicesController@overdue');
        Route::get('invoices/not-due', 'InvoicesController@not_due');
        Route::get('invoices/{invoice}/export', 'InvoicesController@export');
        Route::get('invoices/create', 'InvoicesController@create');
        Route::post('invoices', 'InvoicesController@store');
        Route::get('invoices/{invoice}/edit', 'InvoicesController@edit');
        Route::patch('invoices/{invoice}', 'InvoicesController@update');
        Route::get('invoices/{invoice}/delete', 'InvoicesController@confirmDelete');
        Route::delete('invoices/{invoice}', 'InvoicesController@destroy');

        Route::get('clients', 'ClientsController@index');
        Route::get('clients/create', 'ClientsController@create');
        Route::post('clients', 'ClientsController@store');
        Route::get('clients/{client}/edit', 'ClientsController@edit');
        Route::patch('clients/{client}', 'ClientsController@update');
        Route::get('clients/{client}/delete', 'ClientsController@confirmDelete');
        Route::delete('clients/{client}', 'ClientsController@destroy');

        Route::get('projects', 'ProjectsController@index');
        Route::get('projects/create', 'ProjectsController@create');
        Route::post('projects', 'ProjectsController@store');
        Route::get('projects/{project}/edit', 'ProjectsController@edit');
        Route::patch('projects/{project}', 'ProjectsController@update');
        Route::get('projects/{project}/delete', 'ProjectsController@confirmDelete');
        Route::delete('projects/{project}', 'ProjectsController@destroy');

        Route::get('currencies', 'CurrenciesController@index');
        Route::get('currencies/create', 'CurrenciesController@create');
        Route::post('currencies', 'CurrenciesController@store');
        Route::get('currencies/{currency}/edit', 'CurrenciesController@edit');
        Route::patch('currencies/{currency}', 'CurrenciesController@update');
        Route::get('currencies/{currency}/delete', 'CurrenciesController@confirmDelete');
        Route::delete('currencies/{currency}', 'CurrenciesController@destroy');

        Route::get('users', 'UsersController@index');
        Route::get('users/create', 'UsersController@create');
        Route::post('users', 'UsersController@store');

        Route::get('profile', 'UsersController@editProfile');
        Route::patch('profile', 'UsersController@updateProfile');

    });
});

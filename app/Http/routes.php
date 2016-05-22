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
        Route::get('jobs/{job_id}/edit', 'JobsController@edit');
        Route::patch('jobs/{job_id}', 'JobsController@update');
        Route::get('jobs/{job_id}/delete', 'JobsController@confirmDelete');
        Route::delete('jobs/{job_id}', 'JobsController@destroy');

        Route::get('invoices', 'InvoicesController@index');
        Route::get('invoices/overdue', 'InvoicesController@overdue');
        Route::get('invoices/not-due', 'InvoicesController@not_due');
        Route::get('invoices/{id}/export', 'InvoicesController@export');
        Route::get('invoices/create', 'InvoicesController@create');
        Route::post('invoices', 'InvoicesController@store');
        Route::get('invoices/{invoice_id}/edit', 'InvoicesController@edit');
        Route::patch('invoices/{invoice_id}', 'InvoicesController@update');
        Route::get('invoices/{invoice_id}/delete', 'InvoicesController@confirmDelete');
        Route::delete('invoices/{invoice_id}', 'InvoicesController@destroy');

        Route::get('clients', 'ClientsController@index');
        Route::get('clients/create', 'ClientsController@create');
        Route::post('clients', 'ClientsController@store');
        Route::get('clients/{client_id}/edit', 'ClientsController@edit');
        Route::patch('clients/{client_id}', 'ClientsController@update');
        Route::get('clients/{client_id}/delete', 'ClientsController@confirmDelete');
        Route::delete('clients/{client_id}', 'ClientsController@destroy');

        Route::get('projects', 'ProjectsController@index');
        Route::get('projects/create', 'ProjectsController@create');
        Route::post('projects', 'ProjectsController@store');
        Route::get('projects/{project_id}/edit', 'ProjectsController@edit');
        Route::patch('projects/{project_id}', 'ProjectsController@update');
        Route::get('projects/{project_id}/delete', 'ProjectsController@confirmDelete');
        Route::delete('projects/{project_id}', 'ProjectsController@destroy');

        Route::get('currencies', 'CurrenciesController@index');
        Route::get('currencies/create', 'CurrenciesController@create');
        Route::post('currencies', 'CurrenciesController@store');
        Route::get('currencies/{currency_id}/edit', 'CurrenciesController@edit');
        Route::patch('currencies/{currency_id}', 'CurrenciesController@update');
        Route::get('currencies/{currency_id}/delete', 'CurrenciesController@confirmDelete');
        Route::delete('currencies/{currency_id}', 'CurrenciesController@destroy');

        Route::get('users', 'UsersController@index');
        Route::get('users/create', 'UsersController@create');
        Route::post('users', 'UsersController@store');

        Route::get('profile', 'UsersController@editProfile');
        Route::patch('profile', 'UsersController@updateProfile');

    });
});

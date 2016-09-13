<?php

Route::group(['middleware' => 'web'], function() {

    Route::auth();

    Route::group(['middleware' => 'auth'], function() {

        Route::get('/', 'JobsController@open');

        Route::get('text/{text}', 'TextController@edit');
        Route::patch('text/{text}', 'TextController@update');

        Route::get('jobs', 'JobsController@index');
        Route::get('jobs/open', 'JobsController@open');
        Route::get('jobs/completed', 'JobsController@completed');
        Route::get('jobs/create', 'JobsController@create');
        Route::post('jobs', 'JobsController@store');
        Route::get('jobs/{job}/edit', 'JobsController@edit');
        Route::patch('jobs/{job}', 'JobsController@update');
        Route::get('jobs/{job}/delete', 'JobsController@confirmDelete');
        Route::delete('jobs/{job}', 'JobsController@destroy');
        Route::get('jobs/search', 'JobsController@search');
        Route::get('jobs/filter', 'JobsController@filter');

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
        Route::get('invoices/search', 'InvoicesController@search');
        Route::get('invoices/filter', 'InvoicesController@filter');

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
        Route::post('projects/byClient', 'ProjectsController@getProjectsByClient');

        Route::get('currencies', 'CurrenciesController@index');
        Route::get('currencies/create', 'CurrenciesController@create');
        Route::post('currencies', 'CurrenciesController@store');
        Route::get('currencies/{currency}/edit', 'CurrenciesController@edit');
        Route::patch('currencies/{currency}', 'CurrenciesController@update');
        Route::get('currencies/{currency}/delete', 'CurrenciesController@confirmDelete');
        Route::delete('currencies/{currency}', 'CurrenciesController@destroy');

        Route::get('banks', 'BanksController@index');
        Route::get('banks/create', 'BanksController@create');
        Route::post('banks', 'BanksController@store');
        Route::get('banks/{bank}/edit', 'BanksController@edit');
        Route::patch('banks/{bank}', 'BanksController@update');
        Route::get('banks/{bank}/delete', 'BanksController@confirmDelete');
        Route::delete('banks/{bank}', 'BanksController@destroy');

        Route::get('profile', 'UsersController@editProfile');
        Route::patch('profile', 'UsersController@updateProfile');

    });
});

<?php

namespace App\Providers;

use Request;
use App\Client;
use App\Project;
use App\Currency;
use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeUriSegments();
        $this->composeJobsIndex();
        $this->composeInvoicesIndex();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function composeUriSegments()
    {
        view()->composer('admin.layouts.layout', function($view)
        {
            $view->with('method', Request::segment(2));
            $view->with('argument', Request::segment(3));
        });
    }

    public function composeJobsIndex()
    {
        view()->composer('admin.jobs.index', function($view)
        {
            $helper_arrays = $this->buildHelperArrays();
            $view->with('clients', $helper_arrays['clients']);
            $view->with('projects', $helper_arrays['projects']);
            $view->with('currency_symbols', $helper_arrays['currency_symbols']);
            $view->with('fields', array('client_id', 'project_id', 'name', 'started', 'completed', 'amount'));
        });
    }


    public function composeInvoicesIndex()
    {
        view()->composer('admin.invoices.index', function($view)
        {
            $helper_arrays = $this->buildHelperArrays();
            $view->with('clients', $helper_arrays['clients']);
            $view->with('projects', $helper_arrays['projects']);
            $view->with('currency_symbols', $helper_arrays['currency_symbols']);
            $view->with('fields', array('client_id', 'name', 'invoiced', 'due', 'paid', 'amount'));
        });
    }

    public function buildHelperArrays()
    {
        $clients_full = Client::orderBy('name', 'asc')->get();
        $clients = array();
        foreach ($clients_full as $client)
        {
            $clients[$client->id] = $client->name;
        }
        $projects_full = Project::orderBy('name', 'asc')->get();
        $projects = array();
        foreach ($projects_full as $project)
        {
            $projects[$project->id] = $project->name;
        }
        $currencies_full = Currency::orderBy('name', 'desc')->get();
        $currency_symbols = array();
        foreach ($currencies_full as $currency)
        {
            $currency_symbols[$currency->id] = $currency->symbol;
        }
        return array(
            'clients'          => $clients,
            'projects'         => $projects,
            'currency_symbols' => $currency_symbols
        );
    }
}

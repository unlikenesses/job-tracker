<?php

namespace App\Providers;

use Request;
use App\Job;
use App\Bank;
use App\Client;
use App\Invoice;
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
        $this->composeSidebar();
        $this->composeClientsPages();
        $this->composeProjectsPages();
        $this->composeCurrenciesPages();
        $this->composeBanksPages();
        $this->composeJobsIndex();
        $this->composeJobsForms();
        $this->composeInvoicesIndex();
        $this->composeInvoicesForms();
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

    public function composeSidebar()
    {
        view()->composer('admin.layouts.layout', function($view)
        {
            $view->with('method', Request::segment(1));
            $view->with('argument', Request::segment(2));
            $view->with('allJobs', Job::count());
            $view->with('openJobs', Job::open()->count());
            $view->with('doneNotInvoiced', Job::completed()->notInvoiced()->count());
            $view->with('allInvoices', Invoice::count());
            $view->with('notDueInvoices', Invoice::notDue()->count());
            $view->with('overdueInvoices', Invoice::overdue()->count());
        });
    }

    public function composeClientsPages()
    {
        view()->composer('admin.clients.*', function($view)
        {
            $view->with('fields', ['name', 'address']);
            $view->with('nomenclature', Client::nomenclature());
        });
    }

    public function composeProjectsPages()
    {
        view()->composer('admin.projects.*', function($view)
        {
            $view->with('fields', ['client_id', 'name']);
            $view->with('nomenclature', Project::nomenclature());
        });
        view()->composer(['admin.projects.edit', 'admin.projects.create'], function($view)
        {
            $view->with('clients', Client::orderBy('name', 'asc')->get());
        });
    }

    public function composeCurrenciesPages()
    {
        view()->composer('admin.currencies.*', function($view)
        {
            $view->with('fields', ['name', 'symbol']);
            $view->with('nomenclature', Currency::nomenclature());
        });
    }

    public function composeBanksPages()
    {
        view()->composer('admin.banks.*', function($view)
        {
            $view->with('fields', ['name', 'details']);
            $view->with('nomenclature', Bank::nomenclature());
        });
    }

    public function composeJobsIndex()
    {
        view()->composer('admin.jobs.index', function($view)
        {
            $helper_arrays = $this->buildHelperArrays();
            $view->with('nomenclature', Job::nomenclature());
            $view->with('clients', $helper_arrays['clients']);
            $view->with('projects', $helper_arrays['projects']);
            $view->with('currency_symbols', $helper_arrays['currency_symbols']);
            $view->with('fields', ['client_id', 'project_id', 'name', 'started', 'completed', 'amount']);
        });
    }

    public function composeJobsForms()
    {
        view()->composer('admin.jobs.form', function($view)
        {
            $view->with('fields', ['client_id', 'project_id', 'name', 'started', 'completed', 'amount', 'currency_id']);
            $view->with('nomenclature', Job::nomenclature());
            $view->with('clients', Client::orderBy('name', 'asc')->get());
            $view->with('projects', Project::orderBy('name', 'asc')->get());
            $view->with('currencies', Currency::orderBy('name', 'desc')->get());
        });
    }

    public function composeInvoicesIndex()
    {
        view()->composer(['admin.invoices.index', 'admin.pdf.invoice'], function($view)
        {
            $helper_arrays = $this->buildHelperArrays();
            $view->with('clients', $helper_arrays['clients']);
            $view->with('projects', $helper_arrays['projects']);
            $view->with('nomenclature', Invoice::nomenclature());
            $view->with('currency_symbols', $helper_arrays['currency_symbols']);
            $view->with('fields', ['client_id', 'name', 'invoiced', 'due', 'paid', 'amount']);
        });
    }

    public function composeInvoicesForms()
    {
        view()->composer('admin.invoices.form', function($view)
        {
            $helper_arrays = $this->buildHelperArrays();
            $view->with('projects', $helper_arrays['projects']);
            $view->with('nomenclature', Invoice::nomenclature());
            $view->with('currency_symbols', $helper_arrays['currency_symbols']);
            $view->with('fields', ['client_id', 'name', 'invoiced', 'due', 'paid', 'amount', 'currency_id', 'bank_id']);
            $view->with('banks', Bank::orderBy('name', 'asc')->get());
            $view->with('clients', Client::orderBy('name', 'asc')->get());
            $view->with('jobs', Job::completed()->notInvoiced()->orderBy('completed', 'desc')->get());
            $view->with('currencies', Currency::orderBy('name', 'desc')->get());
        });
    }

    public function buildHelperArrays()
    {
        $clients = $projects = $currency_symbols = [];

        $clients_full = Client::orderBy('name', 'asc')->get();
        foreach ($clients_full as $client) {
            $clients[$client->id] = $client->name;
        }

        $projects_full = Project::orderBy('name', 'asc')->get();
        foreach ($projects_full as $project) {
            $projects[$project->id] = $project->name;
        }

        $currencies_full = Currency::orderBy('name', 'desc')->get();
        foreach ($currencies_full as $currency) {
            $currency_symbols[$currency->id] = $currency->symbol;
        }

        return [
            'clients'          => $clients,
            'projects'         => $projects,
            'currency_symbols' => $currency_symbols
            ];
    }
}

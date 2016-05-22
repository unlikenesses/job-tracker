<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->text('name');
            $table->date('started');
            $table->date('completed')->nullable();
            $table->date('invoiced')->nullable();
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->integer('currency_id')->unsigned();
            $table->float('amount');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }
}

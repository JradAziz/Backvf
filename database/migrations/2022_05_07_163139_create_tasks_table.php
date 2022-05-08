<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->string('Issue', 100)->unique();
            $table->string('Project', 100)->nullable();
            $table->string('Summary', 1000)->nullable();
            $table->string('Type', 100)->nullable();
            $table->string('ResolutionDate', 100)->nullable();
            $table->string('TesterSup', 100)->nullable();
            $table->string('Labels', 1000)->nullable();
            $table->string('Priority', 100)->nullable();
            $table->string('Status', 100)->nullable();
            $table->string('Assignee', 100)->nullable();
            $table->bigInteger('Assigneeid')->nullable();
            $table->foreign('Assigneeid')->references('id')->on('users');
            $table->string('Creator', 100)->nullable();
            $table->string('Reporter', 100)->nullable();
            $table->string('Created', 100)->nullable();
            $table->string('Duedate', 100)->nullable();
            $table->string('Components', 1000)->nullable();
            $table->string('ProblemCategory', 100)->nullable();
            $table->string('Versions', 1000)->nullable();
            $table->string('Resolution', 100)->nullable();
            $table->string('TeamSwbk', 100)->nullable();
            $table->string('TeamSyst', 100)->nullable();
            $table->integer('Award')->nullable();
            $table->string('SlipThroughCategory', 1000)->nullable();
            $table->string('TeamTesterSup')->nullable();
            $table->bigInteger('TeamTesterid')->nullable();
            $table->foreign('TeamTesterid')->references('id')->on('teams');
            $table->string('SlipThroughAnalysis', 1000)->nullable();
            $table->string('SupplierCustomField', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}


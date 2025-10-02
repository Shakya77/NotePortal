<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeAuditableModel extends GeneratorCommand
{
    protected $signature = 'make:auditable-model 
                            {name : The name of the model} 
                            {--m|migration : Create a new migration file for the model}';

    protected $description = 'Create a new model that extends BaseAuditableModel';

    protected $type = 'Model';

    protected function getStub()
    {
        return base_path('stubs/auditable.model.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }

    /**
     * Handle the command execution.
     */
    public function handle()
    {
        parent::handle();

        if ($this->option('migration')) {
            $this->createMigration();
        }
    }

    /**
     * Create the migration for the model.
     */
    protected function createMigration()
    {
        $name = Str::snake(class_basename($this->argument('name')));
        $table = Str::plural($name);

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }
}

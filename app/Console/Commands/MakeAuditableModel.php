<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeAuditableModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:auditable-model {name : The name of the model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model that extends BaseAuditableModel';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/auditable.model.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }
}

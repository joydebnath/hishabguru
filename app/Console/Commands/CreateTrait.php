<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateTrait extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filePath = app_path('Traits' . '/' . $this->argument('name') . '.php');
        $pathInfo = pathinfo($this->argument('name'));
        $dir = pathinfo($filePath);

        if (!File::exists($dir['dirname'])) {
            File::makeDirectory($dir['dirname']);
        }

        if (File::exists($filePath)) {
            $this->error($this->type . ' already exists');
            return false;
        }

        $trait = $this->replaceTrait(File::get($this->getStub()), $pathInfo);

        if (!File::put($filePath, $trait)) {
            $this->error('Unable to create ' . $this->argument('name'));
            return false;
        }
        $this->info($this->argument('name') . ' is created.');
        return true;
    }
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceTrait($stub, $pathInfo)
    {
        $name = $pathInfo['filename'];
        $stub = $this->replaceNamespance($stub,  $pathInfo);
        return str_replace('{{trait}}', $name, $stub);
    }

    protected function replaceNamespance($stub, $pathInfo)
    {
        $namespace = $this->getNamespace($pathInfo['dirname']);
        return str_replace('{{namespace}}', $namespace, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  app_path() . '/Console/Commands/Stubs/make-trait.stub';
    }

    /**
     * Get the default namespace for the trait.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getNamespace($folderStructure)
    {
        $namespace = 'App\Traits';
        if ($folderStructure == '.') {
            return $namespace;
        }
        return $namespace . '\\' . str_replace('/','\\',$folderStructure);
    }
}

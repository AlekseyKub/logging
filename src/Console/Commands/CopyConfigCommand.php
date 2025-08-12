<?php

namespace Severnaya\Logging\Console\Commands;

use Illuminate\Console\Command;

class CopyConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'app:copy-config-command';

    protected $signature = 'logging:copy-config';
   
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copping config file and migration logging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sourceConfig = __DIR__ . '/../config/models.php';
        $destinationConfig = config_path('models.php');
        if (!file_exists($destinationConfig)) {
            copy($sourceConfig, $destinationConfig);
            $this->info('Конфигурационный файл успешно скопирован.');
        } else {
            $this->info('Конфигурационный файл уже существует.');
        }

        $this->call('vendor:publish', [
            '--provider' => 'Severnaya\Logging\YourServiceProvider',
            '--tag' => 'logging-migrations',
            '--force' => true,
        ]);
        $this->info('Миграции успешно опубликованы.');

        $this->call('migrate', [
            '--path' => 'database/migrations',
            '--force' => true,
        ]);
        $this->info('Миграции успешно применены.');
    }
}

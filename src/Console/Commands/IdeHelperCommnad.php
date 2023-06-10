<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class IdeHelperCommnad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:ide-helper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $commands = [
            'ide-helper:generate' => [],
            'ide-helper:models' => [
                '--dir' => [
                    'app/Models',
                    'Modules/*/src/Models',
                ],
                '--no-interaction' => true,
            ],
            'ide-helper:meta' => [],
            'ide-helper:eloquent' => [],
        ];

        foreach ($commands as $command => $params) {
            Artisan::call($command, $params, $this->output);
        }
    }
}

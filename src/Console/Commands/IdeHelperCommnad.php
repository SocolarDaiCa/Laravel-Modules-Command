<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
        config()->set('ide-helper.write_model_magic_where', false);

        $commands = [
            'ide-helper:generate' => [],
            'ide-helper:models' => [
                '--dir' => [
                    'app/Models',
                    'Modules/*/src/Models',
                    'Modules/*/*/src/Models',
                ],
                '--no-interaction' => true,
                // '--nowrite' => true,
                '--write' => true,
                // '--write-mixin' => true,
                '--reset' => true,
            ],
            'ide-helper:meta' => [],
            'ide-helper:eloquent' => [],
        ];

        foreach ($commands as $command => $params) {
            Artisan::call($command, $params, $this->output);
        }
    }
}

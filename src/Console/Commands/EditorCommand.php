<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;
use SocolaDaiCa\LaravelModulesCommand\Editor\Editor;

class EditorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:editor';

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
        app(Editor::class)->modelAddMissingRelations();
    }
}

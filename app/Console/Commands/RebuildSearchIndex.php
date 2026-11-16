<?php

namespace App\Console\Commands;

use App\Services\SearchIndexService;
use Illuminate\Console\Command;

class RebuildSearchIndex extends Command
{
    protected $signature = 'search:rebuild';

    protected $description = 'Rebuild the cached location search index';

    public function handle(SearchIndexService $searchIndex): int
    {
        $this->info('Building search index...');
        $start = microtime(true);

        $index = $searchIndex->rebuild();

        $elapsed = round((microtime(true) - $start) * 1000, 1);
        $this->info("Index built: " . count($index) . " entries in {$elapsed}ms");

        return self::SUCCESS;
    }
}

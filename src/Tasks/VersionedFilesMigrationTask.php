<?php
namespace WebbuildersGroup\FileUpgrader\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use WebbuildersGroup\FileUpgrader\VersionedFilesMigrator;

class VersionedFilesMigrationTask extends BuildTask
{
    const STRATEGY_DELETE = 'delete';

    const STRATEGY_PROTECT = 'protect';

    protected static string $commandName = 'migrate-versionedfiles';

    protected string $title = 'Migrate versionedfiles';

    protected static string $description = 'If you had the symbiote/silverstripe-versionedfiles module installed on your 3.x site, it
        is no longer needed in 4.x as this functionality is provided by default. This task will remove the old _versions
        folders or protect them, depending on the strategy you use. Use ?strategy=delete or ?strategy=protect (Apache
        only). [Default: delete]';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param HTTPRequest $request
     */
    public function execute(InputInterface $input, PolyOutput $output): int
    {
        $strategy = $input->getOption('strategy') ?: self::STRATEGY_DELETE;
        $migrator = VersionedFilesMigrator::create($strategy, ASSETS_PATH, true);
        $migrator->migrate();

        return Command::SUCCESS;
    }
}

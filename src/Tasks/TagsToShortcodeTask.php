<?php
namespace WebbuildersGroup\FileUpgrader\Tasks;

use SilverStripe\Assets\Storage\FileHashingService;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\BuildTask;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

/**
 * SS4 and its File Migration Task changes the way in which files are stored in the assets folder, with files placed
 * in subfolders named with partial hashmap values of the file version. This build task goes through the HTML content
 * fields looking for instances of image links, and corrects the link path to what it should be, with an image shortcode.
 */
class TagsToShortcodeTask extends BuildTask
{
    protected static string $commandName = 'TagsToShortcodeTask';

    protected string $title = 'Rewrite tags to shortcodes';

    protected static string $description = "
        Rewrites tags to shortcodes in any HTMLText field

		Parameters:
		- baseClass: The base class that will be used to look up HTMLText fields. Defaults to SilverStripe\ORM\DataObject
		- includeBaseClass: Whether to include the base class' HTMLText fields or not
    ";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     * @throws \ReflectionException
     */
    public function execute(InputInterface $input, PolyOutput $output): int
    {
        Injector::inst()->get(FileHashingService::class)->enableCache();

        $tagsToShortcodeHelper = new TagsToShortcodeHelper(
            $input->getOption('baseClass'),
            isset($input->getOptions()['includeBaseClass'])
        );
        $tagsToShortcodeHelper->run();

        return Command::SUCCESS;
    }
}

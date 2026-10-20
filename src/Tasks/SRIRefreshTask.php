<?php

namespace Firesphere\CSPHeaders\Tasks;

use Firesphere\CSPHeaders\Models\SRI;
use SilverStripe\Dev\BuildTask;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class Firesphere\CSPHeaders\Tasks\SRIRefreshTask
 *
 * @package Firesphere\CSPHeaders
 */
class SRIRefreshTask extends BuildTask
{
    /**
     * @var string Title of task
     */
    protected string $title = 'Refresh SRI';

    /**
     * @var string Description of task
     */
    protected static string $description = 'Deletes cache of Sub-resource integrities for js/css resources,
        these will regenerate on the next request.';

    /**
     * @var string Name of the command
     */
    protected static string $commandName = 'srirefresh';

    /**
     * Deletes the Sub-resource integrity values on build of the database
     * so they're regenerated next time that file is required.
     */
    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $output->writeln('Removing SRI values...');
        SRI::get()->removeAll();

        return Command::SUCCESS;
    }
}

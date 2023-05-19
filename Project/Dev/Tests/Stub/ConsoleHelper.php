<?php
namespace Project\Dev\Tests\Stub;

use Project\Base\Helper\Console\ConsoleHelper as ProjectConsoleHelper;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleHelper extends ProjectConsoleHelper
{
    /**
     * {@inheritDoc}
     */
    public function writeln($messages, $options = OutputInterface::OUTPUT_NORMAL)
    {
        // do not output
    }
}

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Tools\Console\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

chdir(__DIR__ . '/../migrations');
$helperSet = new HelperSet();
$helperSet->set(new QuestionHelper(), 'question');

$cli = new Application('Doctrine Migrations');
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);


$commands = array(
    new Command\DumpSchemaCommand(),
    new Command\ExecuteCommand(),
    new Command\GenerateCommand(),
    new Command\LatestCommand(),
    new Command\MigrateCommand(),
    new Command\RollupCommand(),
    new Command\StatusCommand(),
    new Command\VersionCommand()
);

// remove the "migrations:" prefix on each command name
foreach ($commands as $command) {
    $command->setName(str_replace('migrations:', '', $command->getName()));
}
$cli->addCommands($commands);
$cli->run();

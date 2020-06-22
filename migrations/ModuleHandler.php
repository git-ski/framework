<?php

namespace Migrations;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class ModuleHandler
{
    public static function postPackageInstall(PackageEvent $event)
    {
        $Package        = $event->getOperation()->getPackage();
        $packageName    = $Package->getPrettyName();
        $migrationFiles = self::getMigrationFiles($event);
        if ($migrationFiles->valid()) {
            foreach ($migrationFiles as [
                'from' => $from, 'to' => $to
            ]) {
                copy($from, $to);
            }
            echo "マイグレーションを見つかりました、コピーしました。", PHP_EOL;
        }
    }

    public static function prePackageUninstall(PackageEvent $event)
    {
        $Package     = $event->getOperation()->getPackage();
        $packageName = $Package->getPrettyName();
        $migrationFiles = self::getMigrationFiles($event);
        if ($migrationFiles->valid()) {
            echo "関連するマイグレーションファイルを見つかりました、マイグレーションも一緒に除去する場合は下記コマンドを実行する。", PHP_EOL;
            foreach ($migrationFiles as [
                'from' => $from, 'to' => $to
            ]) {
                if (preg_match('/Version(?<version>.*)\.php$/', $to, $match)) {
                    $version = $match['version'];
                    echo "    php bin/migrations.php execute {$version} --no-interaction --down && rm {$to}", PHP_EOL;
                }
            }
        }
    }

    private static function getMigrationFiles(PackageEvent $event) : ?iterable
    {
        $Package        = $event->getOperation()->getPackage();
        $vendorDir      = $event->getComposer()->getConfig()->get('vendor-dir');
        $packageName    = $Package->getPrettyName();
        if (strpos($packageName, 'gitski/') !== 0) {
            return ;
        }
        $migrationDir   = $vendorDir . '/' . $packageName . '/migrations';
        $versionsDir    = $vendorDir . '/' . $packageName . '/migrations/versions';
        $dumpsDir       = $vendorDir . '/' . $packageName . '/migrations/dumps';
        $migrationTarget= __DIR__;
        foreach (glob($versionsDir . '/*.php') as $versionFile) {
            yield [
                'from' => $versionFile,
                'to'   => str_replace($migrationDir, $migrationTarget, $versionFile)
            ];
        }
        foreach (glob($dumpsDir . '/*.sql') as $dumpFile) {
            yield [
                'from' => $dumpFile,
                'to'   => str_replace($migrationDir, $migrationTarget, $dumpFile)
            ];
        }
    }
}

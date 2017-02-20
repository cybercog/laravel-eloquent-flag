<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests;

use Cog\Flag\Providers\FlagServiceProvider;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Class TestCase.
 *
 * @package Cog\Flag\Tests
 */
abstract class TestCase extends Orchestra
{
    /**
     * Actions to be performed on PHPUnit start.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->destroyPackageMigrations();
        $this->publishPackageMigrations();
        $this->registerMigrations();
        $this->migrateUnitTestTables();
        $this->registerPackageFactories();
    }

    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FlagServiceProvider::class,
            \Orchestra\Database\ConsoleServiceProvider::class,
        ];
    }

    /**
     * Publish package migrations.
     */
    protected function publishPackageMigrations()
    {
        $this->artisan('vendor:publish', ['--force' => '']);
    }

    /**
     * Delete all published package migrations.
     */
    protected function destroyPackageMigrations()
    {
        File::cleanDirectory('vendor/orchestra/testbench/fixture/database/migrations');
    }

    /**
     * Register test migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom([
            //'--database' => 'sqlite',
            '--realpath' => realpath(__DIR__ . '/database/migrations'),
        ]);
    }

    /**
     * Perform unit test database migrations.
     */
    protected function migrateUnitTestTables()
    {
        $this->artisan('migrate');
    }

    /**
     * Cleanup database after unit test.
     */
    protected function migrateTablesUndo()
    {
        $this->artisan('migrate:reset');
    }

    /**
     * Register package related model factories.
     */
    private function registerPackageFactories()
    {
        $pathToFactories = realpath(__DIR__ . '/database/factories');
        $this->withFactories($pathToFactories);
    }
}

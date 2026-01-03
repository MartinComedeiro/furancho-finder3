<?php

namespace Config;

use CodeIgniter\Config\Paths as BasePaths;

class Paths extends BasePaths
{
    public $applicationDirectory = ROOTPATH . 'app';
    public $configDirectory      = ROOTPATH . 'app/Config';
    public $databaseDirectory    = ROOTPATH . 'app/Database';
    public $migrationsDirectory  = ROOTPATH . 'app/Database/Migrations';
    public $seedsDirectory       = ROOTPATH . 'app/Database/Seeds';
    public $publicDirectory      = ROOTPATH . 'public';
    public $storagePath          = ROOTPATH . 'writable';
    public $testsDirectory       = ROOTPATH . 'tests';
    public $viewDirectory        = ROOTPATH . 'app/Views';
}

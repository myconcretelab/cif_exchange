<?php
namespace Concrete\Package\CifExchange;

use Concrete\Core\Backup\ContentImporter;
use Package

class Controller extends Package {
    protected $pkgHandle = 'cif_exchange';
    protected $appVersionRequired = '5.7.3';
    protected $pkgVersion = '0.1';

    public function getPackageName()
    {
        return t('CIF Importer/Exporter');
    }

    public function getPackageDescription()
    {
        return t('Import and export Page in XML (CIF).');
    }

    public function install()
    {
        $pkg = parent::install();
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/config/install.xml');
    }
}

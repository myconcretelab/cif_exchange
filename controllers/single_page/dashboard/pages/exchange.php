<?php
namespace Concrete\Package\CifExchange\Controller\SinglePage\Dashboard\Pages;

use Core;
use File;
use Page;
use Concrete\Core\File\Importer as FileImporter;
use Concrete\Core\Backup\ContentImporter;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\Backup\ContentExporter;
use Loader;
use SimpleXMLElement;


if (!ini_get('safe_mode')) {
    @set_time_limit(0);
    ini_set('max_execution_time', 0);
}

class Exchange extends DashboardPageController {

    public function import()
    {
        if ($this->token->validate("import")) {
          if (isset($this->post['cif'])) :
            $ci = new ContentImporter();
            $ci->importContentString($this->post['cif']);
            $this->set('message', t('Done.'));
          else :
            $valn = Core::make("helper/validation/numbers");
            $fi = new FileImporter();

            $fID = $this->post('fID');
            if (!$valn->integer($fID)) {
                $this->error->add($fi->getErrorMessage(FileImporter::E_FILE_INVALID));
            } else {
                $f = File::getByID($fID);
                if (!is_object($f)) {
                    $this->error->add($fi->getErrorMessage(FileImporter::E_FILE_INVALID));
                }
            }

            if (!$this->error->has()) {
                $fsr = $f->getFileResource();
                if (!$fsr->isFile()) {
                    $this->error->add($fi->getErrorMessage(FileImporter::E_FILE_INVALID));
                } else {
                    $ci = new ContentImporter();
                    $ci->importContentString($fsr->read());
                    $this->set('message', t('Done.'));
                }
            }
          endif;
        } else {
            $this->error->add($this->token->getErrorMessage());
        }
    }
    public function export()
    {
        if ($this->token->validate("export")) {

            $page = Page::getByID($this->post('cID'));

            if (!is_object($page)) {
              $this->error->add(t('Imossible to retrive Page'));
            } elseif (!$this->error->has()) {
              // var_dump($page);exit;
              $root = new SimpleXMLElement("<concrete5-cif></concrete5-cif>");
              $root->addAttribute('version', '1.0');

              // Add the Page
              $node = $root->addChild("pages");

              $page->export($node);

              // Transform into a xml string
              $xml = $root->asXML();
              // remove crappy characters
              $xml = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $xml);
          		$th = Loader::helper('text');
          		$xml = $th->formatXML($xml);

          		$this->set('outputContent', $xml);

            }
        } else {
            $this->error->add($this->token->getErrorMessage());
        }
    }
}

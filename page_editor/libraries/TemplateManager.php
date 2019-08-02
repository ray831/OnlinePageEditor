<?php

require_once('FileSystemHelper.php');

class TemplateManager {

    const TEMPLATE_DIR = "../template";

    private $_tpname;

    private $_tpdir;

    function __construct($tpname)
    {
        $this->setTemplateName($tpname);
    }


    private function _setTemplateDir()
    {
        $this->_tpdir = self::TEMPLATE_DIR."/".
                        $this->_tpname;
    }

    public function setTemplateName($tpname)
    {
        $this->_tpname = $tpname;

        $this->_setTemplateDir();
    }


    public function load($fname)
    {
        if( empty($fname) )
            throw new Exception("file name is empty");

        $dst = $this->_tpdir."/".
               $fname;

        if( !isFileExist($dst) ) {
            $dst = @glob($dst."*", GLOB_NOSORT)[0];
        }

        return file_get_contents($dst);
    }

    public function loadAll()
    {
        $files = glob($this->_tpdir."/*", GLOB_NOSORT);

        $contents = array();

        foreach( $files as $file ){
            $contents = array_merge( $contents, array(
                pathinfo($file, PATHINFO_FILENAME)
                =>
                file_get_contents($file)
                )
            );
        }
        return $contents;
    }

    static public function getAllTemplateName()
    {
        return getFileNamesInDirectory(self::TEMPLATE_DIR, SEARCH_DIR);
    }
}
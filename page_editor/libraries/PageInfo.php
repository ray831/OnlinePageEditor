<?php

require_once('FileSystemHelper.php');

if ( !isset( $pg_details ) ) {
	include_once( dirname(__DIR__).'/config.php' );
}



class PageInfo {

    const TMP_DIR = "../temp";

    const PUBLIC_DIR = "../".PAGE_ROOT;

    protected $_pg_details;

    protected $_pgname;

    protected $_version;

    protected $_tmpPgDir;

    protected $_tmpDstDir;

    protected $_dst;

    function __construct($pgname, $version = "")
    {
        
        $this->_pgname  = $pgname;
        $this->_version = !empty($version) 
                        ? $version 
                        : "auto";


        $this->_pg_details = $GLOBALS['pg_details'];
        
        $this->_setTempDir();

    }

    protected function _setTempDir()
    {
        $this->_tmpPgDir = self::TMP_DIR."/".
                           $this->_pgname;

        $this->_tmpDstDir = $this->_tmpPgDir."/".
                            $this->_version;
    }

    protected function _setTempFilePath($type)
	{
		switch ($type)
		{
		case 'htm':
            $this->_dst = $this->_tmpDstDir."/".
                          $this->_pgname.
                          ".php";
			break;

        case 'js':
            $this->_dst = $this->_tmpDstDir."/".
                         "js/".
                         $this->_pgname.
                         ".js";
            break;

        case 'ss':
            $this->_dst = $this->_tmpDstDir."/".
                         "ajax/".
                         $this->_pgname.
                         "_ajax.php";
            break;
            
		default:
			break;
		}
	}

    protected function _setPublicFilePath($type)
	{
		switch ($type)
		{
		case 'htm':
            $this->_dst = self::PUBLIC_DIR."/".
                         $this->_pgname.
                         ".php";
			break;

        case 'js':
            $this->_dst = self::PUBLIC_DIR."/".
                         "js/".
                         $this->_pgname.
                         ".js";
            break;

        case 'ss':
            $this->_dst = self::PUBLIC_DIR."/".
                         "ajax/".
                         $this->_pgname.
                         "_ajax.php";
            break;
            
		default:
			break;
		}
	}

    public function setPageName($pgn)
    {
        $this->_pgname = $pgn;
        $this->_setTempDir();
    }

    public function switchVersion($ver)
    {
        $this->_version = $ver;
        $this->_setTempDir();
    }

    public function countTempDir()
    {
        return countDirectoryFiles($this->_tmpPgDir);
    }

    public function getAllVersion()
    {
        return getFileNamesInDirectory($this->_tmpPgDir);
    }

    public function isPageExistInPublic()
    {
        $this->_setPublicFilePath('htm');
        
        return isFileExist($this->_dst);
    }

    public function isPageExistInTemp()
    {
        return isFileExist($this->_tmpPgDir);
    }


    static public function getAllPagesInTemp()
    {
        return getFileNamesInDirectory(self::TMP_DIR, SEARCH_DIR);
    }

    static public function getAllPagesInPublic($ext = 'php')
    {
        return getFileNamesInDirectory(self::PUBLIC_DIR, SEARCH_FILE, $ext);
    }
}

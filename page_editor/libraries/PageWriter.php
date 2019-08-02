<?php

require_once('PageInfo.php');


class PageWriter extends PageInfo {
	
	function __construct($pgname, $version = "", $bMkdir = false)
	{
		parent::__construct($pgname, $version);

		if( $bMkdir && !realpath($this->_tmpPgDir) )
            mkdir($this->_tmpPgDir, 0777, true);
	}
	
	

    private function _saveTemp($content, $type)
	{
		$this->_setTempFilePath($type);
        
		if( !isFileExist(dirname($this->_dst)) )
			mkdir(dirname($this->_dst), 0777, true);

        return file_put_contents($this->_dst, $content, LOCK_EX);
	}
	
	
	private function _savePublic($content, $type)
	{
		$this->_setPublicFilePath($type);

		if( $type === 'htm' ) {
			$blank = file_get_contents($this->_pg_details["base"]);
			$content = str_replace($this->_pg_details["repmark"], 
									$content,
									$blank);
		}
        
        return file_put_contents($this->_dst, $content, LOCK_EX);
	}

	public function save($content, $type, $saveTo)
	{
        if ( $saveTo === 'temp' ) {
            return $this->_saveTemp($content, $type);
		}
		else if ( $saveTo === 'public' ) {
			return $this->_savePublic($content, $type);
		}

        throw new Exception("Undefined SaveTo Path");
	}
	
	
	public function saveAll($contents, $saveTo)
	{
		$ret = array();
		
        if ( $saveTo === 'temp' ) {
            foreach( $contents as $type => $content ){
                array_push(
                    $ret, 
                    array( $type, $this->_saveTemp($content, $type) )
                );
            }
		}
		else if ( $saveTo === 'public' ) {
			foreach( $contents as $type => $content ){
                array_push(
                    $ret, 
                    array( $type, $this->_savePublic($content, $type) )
                );
            }
		}

        return $ret;
	}
	
	public function backUpPublicPage()
	{
		$bakdir = '../backup/'.$this->_pgname;

		if( !isFileExist($bakdir) )
			mkdir($bakdir, 0777, true);

		$types = array('htm', 'js', 'ss');
		foreach( $types as $type ) {
			$this->_setPublicFilePath($type);
			$dst = $bakdir.'/'.basename($this->_dst);

			copy($this->_dst, $dst);
		}
	}
	
	
}




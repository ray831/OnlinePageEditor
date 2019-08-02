<?php

require_once('PageInfo.php');

class PageReader extends PageInfo {

    function __construct($pgname, $version = "")
    {
        parent::__construct($pgname, $version);
    }

    private function _loadTemp($type)
	{
		$this->_setTempFilePath($type);

        return @file_get_contents($this->_dst);
	}
	
	
	private function _loadPublic($type)
	{
		$this->_setPublicFilePath($type);

        $content = @file_get_contents($this->_dst);

		if( $type === 'htm' ) {
			list($header, $footer) = explode($this->_pg_details["repmark"], 
											 file_get_contents($this->_pg_details["base"]));
			$content = str_ireplace($header, "", $content);
			$content = str_ireplace($footer, "", $content);
		}
        
        return $content;
	}

	public function load($type, $loadFrom)
	{
        if ( $loadFrom === 'temp' ) {
            return $this->_loadTemp($type);
		}
		else if ( $loadFrom === 'public' ) {
			return $this->_loadPublic($type);
		}

        throw new Exception("Undefined LoadFrom Path");
	}
	
	
	public function loadAll($types, $loadFrom)
	{
		$ret = array();
		
        if ( $loadFrom === 'temp' ) {
            foreach( $types as $type ) {
                $ret[$type] = $this->_loadTemp($type);
            }
		}
		else if ( $loadFrom === 'public' ) {
			foreach( $types as $type ) {
                $ret[$type] = $this->_loadPublic($type);
            }
		}

        return $ret;
	}

	
}



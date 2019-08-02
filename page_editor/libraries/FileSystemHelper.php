<?php

define('SEARCH_DIR', 0, true);
define('SEARCH_FILE', 1, true);


function getFileNamesInDirectory($path, $flag = SEARCH_DIR, $ext = "")
{
	
	$fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);
	
	$arr = array();
	
	
	foreach( $fi as $fileinfo ){

        if ( $flag === SEARCH_FILE ) {
            if( $fileinfo->isFile() ) {
                if( !empty($ext) ) 
                    if( strcasecmp($fileinfo->getExtension(), $ext) !== 0 )
                        continue;
                
                array_push($arr, $fileinfo->getBasename('.'.$ext));
            }
		}
		else if ( $flag === SEARCH_DIR ) {
			if( $fileinfo->isDir() )
                array_push($arr, $fileinfo->getFilename());
		}
        else {
            break;
        }
        
	}
	
	
	return $arr;
	
}


function countDirectoryFiles($path)
{
	
	$fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);
	
	return iterator_count($fi);
	
}


function isFileExist($path)
{
	
	if( !file_exists($path) ) return false;
	
	clearstatcache();
	
	return true;
	
}


function file_get_binary($filename)
{
    $fp = fopen($filename, 'rb');
    $binary = fread($fp);
    fclose($fp);

    return $binary;
}

function file_put_binary($filename, $buffer)
{
    $fp = fopen($filename, 'wb');
    $ret = fwrite($fp, $buffer);
    fclose($fp);

    return $ret;
}


function array_convert_encoding($arr, $from, $to)
{
    $pair = array($from, $to);
    array_walk(
        $arr,
        function(&$str, $key, $pair){
            $str = iconv($pair[0], $pair[1], $str);
        },
        $pair
    );

    return $arr;
}
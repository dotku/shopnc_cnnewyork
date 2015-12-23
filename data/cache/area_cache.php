<?php
/**
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */
defined('InShopNC') or exit('Access Invalid!');
final class area_Cache {
	
	public static function getCache($type, $param = "") {
		Language::read("core_lang_index");
		$lang = Language::getlangcontent();
		$type = strtoupper($type[0]) . strtolower(substr($type, 1));
		$function = "get" . $type . "Cache";
		try {
			do {
				if (method_exists(area_Cache, $function)) {
					break;
				} else {
					$error = $lang['please_check_your_cache_type'];
					throw new Exception($error);
				}
			} while (0);
		}
		catch(Exception $e) {
			showmessage($e->getMessage() , "", "exception");
		}
		$result = self::$function($param);
		return $result;
	}
	
	private static function getAreaCache($param) {
		Language::read("core_lang_index");
		$lang = Language::getlangcontent();
		$deep = $param['deep'];
		$cache_file = BASE_DATA_PATH . DS . "cache" . DS . "area" . DS . "area_" . $deep . ".php";
		if (file_exists($cache_file) && time() - SESSION_EXPIRE <= filemtime($cache_file) && empty($param['new'])) {
			require ($cache_file);
			return $data;
		}
		$param = array();
		$param['table'] = "area";
		$param['where'] = "area_deep = '" . $deep . "'";
		$param['order'] = "area_sort asc";
		$result = Db::select($param);
		$tmp.= "<?php \r\n";
		$tmp.= "defined('InShopNC') or exit('Access Invalid!'); \r\n";
		$tmp.= "\$data = array(\r\n";
		if (is_array($result)) {
			foreach ($result as $k => $v) {
				$tmp.= "\tarray(\r\n";
				$tmp.= "\t\t'area_id'=>'" . $v['area_id'] . "',\r\n";
				$tmp.= "\t\t'area_name'=>'" . htmlspecialchars($v['area_name']) . "',\r\n";
				$tmp.= "\t\t'area_region'=>'" . htmlspecialchars($v['area_region']) . "',\r\n";
				$tmp.= "\t\t'area_parent_id'=>'" . $v['area_parent_id'] . "',\r\n";
				$tmp.= "\t\t'area_sort'=>'" . $v['area_sort'] . "',\r\n";
				$tmp.= "\t\t'area_deep'=>'" . $v['area_deep'] . "',\r\n";
				$tmp.= "\t),\r\n";
			}
		}
		$tmp.= ");";
		try {
			$fp = @fopen($cache_file, "wb+");
			if (fwrite($fp, $tmp) === FALSE) {
				$error = $lang['please_check_your_system_chmod_area'];
				throw new Exception();
			}
			@fclose($fp);
			require ($cache_file);
			return $data;
		}
		catch(Exception $e) {
			showmessage($e->getMessage() , "", "exception");
		}
	}
	
    public static function makeallcache($type) {
        Language::read("core_lang_index");
        $lang = Language::getlangcontent();
        $time = time();
        switch ($type) {
            case "area":
                $file_list = readfilelist(BASE_DATA_PATH . DS . "cache" . DS . "area");
                if (is_array($file_list)) {
                    foreach ($file_list as $v) {
                        @unlink(BASE_DATA_PATH . DS . "cache" . DS . "area" . DS . $v);
                    }
                }
                $maxdeep = 1;
            default:
                $param = array();
                $param['table'] = "area";
                $param['where'] = "area_deep = '" . $maxdeep . "'";
                $param['order'] = "area_sort asc";
                $result = Db::select($param);
                if (!empty($result)) {
                    $cache_file_area = BASE_DATA_PATH . DS . "cache" . DS . "area" . DS . "area_" . $maxdeep . ".php";
                    $tmp.= "<?php \r\n";
                    $tmp.= "defined('InShopNC') or exit('Access Invalid!'); \r\n";
                    $tmp.= "\$data = array(\r\n";
                    if (is_array($result)) {
                        foreach ($result as $k => $v) {
                            $tmp.= "\tarray(\r\n";
                            $tmp.= "\t\t'area_id'=>'" . $v['area_id'] . "',\r\n";
                            $tmp.= "\t\t'area_name'=>'" . htmlspecialchars($v['area_name']) . "',\r\n";
                            $tmp.= "\t\t'area_region'=>'" . htmlspecialchars($v['area_region']) . "',\r\n";
                            $tmp.= "\t\t'area_parent_id'=>'" . $v['area_parent_id'] . "',\r\n";
                            $tmp.= "\t\t'area_sort'=>'" . $v['area_sort'] . "',\r\n";
                            $tmp.= "\t\t'area_deep'=>'" . $v['area_deep'] . "',\r\n";
                            $tmp.= "\t),\r\n";
                        }
                    }
                    $tmp.= ");";
                    try {
                        $fp = @fopen($cache_file_area, "wb+");
                        if (fwrite($fp, $tmp) === FALSE) {
                            $error = $lang['please_check_your_system_chmod_area'];
                            throw new Exception();
                        }
                        unset($tmp);
                        @fclose($fp);
                    }
                    catch(Exception $e) {
                        showmessage($e->getMessage() , "", "exception");
                    }
                }
                ++$maxdeep;
        }
    }

	function del_DirAndFile($dirName){
		if(is_dir($dirName)){
			if ( $handle = opendir( "$dirName" ) ) {  
				while ( false !== ( $item = readdir( $handle ) ) ) {  
					if ( $item != "." && $item != ".." ) {  
						if ( is_dir( "$dirName/$item" ) ) {  
							del_DirAndFile( "$dirName/$item" );  
						} else {  
							unlink( "$dirName/$item" );
						}  
					}  
				}  
				closedir( $handle );  
				rmdir( $dirName );
			}
		}
	}
	
	public static function deleteCacheFile()
	{	
		$dirName = BASE_DATA_PATH . DS . "cache" . DS . "area";
		if(is_dir($dirName)){
			if ( $handle = opendir( "$dirName" ) ) {  
				while ( false !== ( $item = readdir( $handle ) ) ) {  
					if ( $item != "." && $item != ".." ) {  
						if ( is_dir( "$dirName/$item" ) ) {  
							del_DirAndFile( "$dirName/$item" );  
						} else {  
							unlink( "$dirName/$item" );
						}  
					}  
				}  
				closedir( $handle );  
			}
		}
	}  
	
	//自动更新“\data\resource\js\area_array.js”
	public static function updateAreaArrayJs()
	{
		$cache_file = BASE_DATA_PATH . DS . "resource" . DS . "js" . DS . "area_array.js";
		$param = array();
		$param['table'] = "area";
		$param['field'] = "area_parent_id";
		$param['order'] = "area_parent_id ASC";
		$param['group'] = "area_parent_id";
		$result = Db::select($param);
		
		$tmp.= "nc_a = new Array();\n";
		if (is_array($result)) {
			foreach ($result as $k => $v) {
				$tmp.="nc_a[".$v['area_parent_id']."]=[";
				$tmp_sub = "";
				//子地区
				$param_sub = array();
				$param_sub['table'] = "area";
				$param_sub['where'] = "area_parent_id = '" . $v['area_parent_id'] . "'";
				$param_sub['order'] = "area_sort ASC,area_id ASC";
				$result_sub = Db::select($param_sub);
				if (is_array($result_sub)) {
					foreach ($result_sub as $k_sub => $v_sub) {
						if($tmp_sub == ""){
							$tmp_sub = "['".$v_sub['area_id']."','".$v_sub['area_name']."']";
						}else{
							$tmp_sub .= ",['".$v_sub['area_id']."','".$v_sub['area_name']."']";
						}
					}
				}
				$tmp.=$tmp_sub;
				$tmp.="];\n";
			}
		}
		try {
			$fp = @fopen($cache_file, "wb+");
			if (fwrite($fp, $tmp) === FALSE) {
				$error = $lang['please_check_your_system_chmod_area'];
				throw new Exception();
			}
			@fclose($fp);
			//require ($cache_file);
			return $data;
		}
		catch(Exception $e) {
			showmessage($e->getMessage() , "", "exception");
		}
		
	}

	//自动更新“\data\area\area.php”
	public static function updateAreaPhp()
	{
		$cache_file = BASE_DATA_PATH . DS . "area" . DS . "area.php";
		
		$param = array();
		$param['table'] = "area";
		$param['order'] = "area_deep asc ,area_sort ASC,area_id ASC";
		$result = Db::select($param);
		$tmp.= "<?php \r\n";
		$tmp.= "defined('InShopNC') or exit('Access Invalid!'); \r\n";
		$tmp.= "\$area_array = array(\r\n";
		
		if (is_array($result)) {
			foreach ($result as $k => $v) {
				$tmp.= "\t".$v['area_id']." => array ( 'area_name' => '".$v['area_name']."', 'area_parent_id' => '".$v['area_parent_id']."', ),";
			}
		}
		$tmp.= ");";
		try {
			$fp = @fopen($cache_file, "wb+");
			if (fwrite($fp, $tmp) === FALSE) {
				$error = $lang['please_check_your_system_chmod_area'];
				throw new Exception();
			}
			@fclose($fp);
			//require ($cache_file);
			return $data;
		}
		catch(Exception $e) {
			showmessage($e->getMessage() , "", "exception");
		}
		
	}
}
?>
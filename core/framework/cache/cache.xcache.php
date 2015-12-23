<?php
/**
 * xcache 缓存  v3-b12
 *
 */
defined('Soshop') or exit('Access Invalid!');
class CacheXcache extends Cache{

	private $prefix;
	private $type;

	public function __construct(){
        if ( !function_exists('xcache_info') ) {
            throw_exception('Xcache failed to load');
        }
        $this->prefix= $this->config['prefix'] ? $this->config['prefix'] : substr(md5($_SERVER['HTTP_HOST']), 0, 6).'_';
	}

    public function get($key, $type='') {
		$this->type = $type;
		$name = $this->_key($key);
        if ($result = xcache_isset($name)) {
            return $result;
        }else{
        	return false;
        }
    }

 	public function set($key, $value, $type='', $ttl = SESSION_EXPIRE){
		$this->type = $type;
        if(xcache_set($this->_key($key), $value, $ttl)) {
            return true;
        }
        return false;
	}

	public function rm($key, $type=''){
		$this->type = $type;
		return xcache_unset($this->_key($key));
	}

   	private function _key($str) {
		return $this->prefix.$this->type.$str;
	}
	
	public function clear() {
		return xcache_clear_cache(XC_TYPE_VAR, 0);
	}

	public function inc($key, $step = 1) {
		$this->type = $type;
		return xcache_inc($this->_key($key), $step);
	}

	public function dec($key, $step = 1) {
		$this->type = $type;
		return xcache_dec($this->_key($key), $step);
	}
}
?>
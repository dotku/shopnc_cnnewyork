<?php
/**
 * apc 缓存  v3-b12
 * 
 */
defined('Soshop') or exit('Access Invalid!');

class CacheApc extends Cache{

	private $prefix;
	private $type;

	public function __construct(){
        if ( !function_exists('apc_cache_info') ) {
            throw_exception('Apc failed to load');
        }
        $this->prefix= $this->config['prefix'] ? $this->config['prefix'] : substr(md5($_SERVER['HTTP_HOST']), 0, 6).'_';
	}

    public function get($key, $type='') {
		$this->type = $type;
		$name = $this->_key($key);
        return apc_fetch($name);
    }

 	public function set($key, $value, $type='', $ttl = SESSION_EXPIRE){
		$this->type = $type;
        if(apc_store($this->_key($key), $value, $ttl)) {
            return true;
        }
        return false;
	}

	public function rm($key, $type=''){
		$this->type = $type;
		return apc_delete($this->_key($key));
	}

    public function clear() {
        return apc_clear_cache('user');
    }

   	private function _key($str) {
		return $this->prefix.$this->type.$str;
	}

	public function inc($key, $step = 1) {
		$this->type = $type;
		return apc_inc($this->_key($key), $step) !== false ? apc_fetch($this->_key($key)) : false;
	}

	public function dec($key, $step = 1) {
		$this->type = $type;
		return apc_dec($this->_key($key), $step) !== false ? apc_fetch($this->_key($key)) : false;
	}
}
?>
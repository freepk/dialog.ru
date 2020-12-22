<?php
	define('_TPL_BLK_', 0);
		define('_TPL_BLK_PROTO_', 0);
		define('_TPL_BLK_PARSE_', 1);
		define('_TPL_BLK_REFER_', 2);
	define('_TPL_VAR_', 1);
		define('_TPL_VAR_KEYS_', 0);
		define('_TPL_VAR_VALS_', 1);
		define('_TPL_VAR_FUNC_', 2);
	define('_TPL_TXT_', 2);
	define('_TPL_AUTORESET_', true);
	class Template {
		private $_body;
		function __construct(){
			$this->_body = array(
				_TPL_BLK_ => array(),
				_TPL_VAR_ => array(),
				_TPL_TXT_ => array()
			);
		}
		private function read_file($file){
			$text = file_get_contents($file);
			$text = str_replace(
				array('<', '>', '&', '{', '}'),
				array('@@', '##', '$$', '<', '>'),
				$text
			);
			return $text;
		}
		private function read_cach($file){
		}
		private function init_tpl($sxe){
			foreach($sxe->blk as $blk)
				$this->init_blk($blk);
		}
		private function &init_blk($sxe){
			$id = strval($sxe['id']);
			if(!isset($this->_body[_TPL_BLK_][$id])){
				$this->_body[_TPL_BLK_][$id] = array(
					_TPL_BLK_PROTO_ => array(),
					_TPL_BLK_PARSE_ => array(),
					_TPL_BLK_REFER_ => array()
				);
			}
			foreach($sxe as $name => $node){
				$ref =& $this->call_init($name, $node);
				switch($name){
					case 'ref':
					case 'blk':
						$this->_body[_TPL_BLK_][$id][_TPL_BLK_PROTO_][] =& $ref[_TPL_BLK_PARSE_];
						$this->_body[_TPL_BLK_][$id][_TPL_BLK_REFER_][] =& $ref[_TPL_BLK_PARSE_];
					break;
					case 'txt':
						$this->_body[_TPL_BLK_][$id][_TPL_BLK_PROTO_][] =& $ref;
					break;
					case 'var':
						$key = 
						$this->_body[_TPL_BLK_][$id][_TPL_BLK_PROTO_][] =& $ref;
					break;
				}
			}
			return $this->_body[_TPL_BLK_][$id];
		}
		private function &init_ref($sxe){
			$id = strval($sxe['id']);
			if(!isset($this->_body[_TPL_BLK_][$id])){
				$this->_body[_TPL_BLK_][$id] = array(
					_TPL_BLK_PROTO_ => array(),
					_TPL_BLK_PARSE_ => array(),
					_TPL_BLK_REFER_ => array()
				);
			}
			return $this->_body[_TPL_BLK_][$id];
		}
		private function &init_txt($sxe){
			$txt = str_replace(array('@@', '##', '$$'), array('<', '>', '&'), strval($sxe));
			$txt = iconv('UTF-8', 'CP1251', $txt);
			if(!$pos = array_search($txt, $this->_body[_TPL_TXT_])){
				$pos = array_push($this->_body[_TPL_TXT_], $txt) - 1;
			}
			return $this->_body[_TPL_TXT_][$pos];
		}
		private function &init_var($sxe){
			$id = strval($sxe['id']);
			$keys = explode('.', $id);
			if(!isset($this->_body[_TPL_VAR_][$keys[0]])){
				$this->_body[_TPL_VAR_][$keys[0]] = array(
					_TPL_VAR_KEYS_ => array(),
					_TPL_VAR_VALS_ => array(),
					_TPL_VAR_FUNC_ => null
				);
			}
			if(!in_array($keys, $this->_body[_TPL_VAR_][$keys[0]][_TPL_VAR_KEYS_])){
				$this->_body[_TPL_VAR_][$keys[0]][_TPL_VAR_KEYS_][$id] = array_slice($keys, 1);
				$this->_body[_TPL_VAR_][$keys[0]][_TPL_VAR_VALS_][$id] = '';
				$cbBody = '';
				foreach($this->_body[_TPL_VAR_][$keys[0]][_TPL_VAR_KEYS_] as $dst => $src){
					$cbBody .= '$dst["'.$dst.'"]';
					$cbBody .= ' = ';
					$cbBody .= '$src';
					if(count($src) > 0){
						$cbBody .= '["'.implode('"]["', $src).'"]';
					}
					$cbBody .= ';';
				}
				$this->_body[_TPL_VAR_][$keys[0]][_TPL_VAR_FUNC_] = create_function('$src, &$dst', $cbBody);
			}
			return $this->_body[_TPL_VAR_][$keys[0]][_TPL_VAR_VALS_][$id];
		}
		private function &call_init($name, $sxe){
			$init_method = 'init_'.$name;
			if(method_exists($this, $init_method))
				return $this->$init_method($sxe);
		}
		public function Load($file, $delay = 0){
			$txt = $this->read_file($file);
			$sxe = simplexml_load_string($txt);
			$this->init_tpl($sxe);
		}
		public function Parse($name){
			foreach($this->_body[_TPL_BLK_][$name][_TPL_BLK_PROTO_] as $proto)
				$this->_body[_TPL_BLK_][$name][_TPL_BLK_PARSE_][] = $proto;
			if(_TPL_AUTORESET_){
				foreach($this->_body[_TPL_BLK_][$name][_TPL_BLK_REFER_] as &$refer)
				{
					$refer = array();
				}
			}
		}
		public function Assign($name, $value){
			$this->_body[_TPL_VAR_][$name][_TPL_VAR_FUNC_](
				$value,
				$this->_body[_TPL_VAR_][$name][_TPL_VAR_VALS_]
			);
		}
		public function Out($name){
			$it = new RecursiveIteratorIterator(new RecursiveArrayIterator(
					$this->_body[_TPL_BLK_][$name][_TPL_BLK_PARSE_]
				)
			);
			foreach($it as $txt){
			   echo $txt;
			}
		}
	}
?>
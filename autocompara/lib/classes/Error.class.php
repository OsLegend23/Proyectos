<?php

class Error extends Exception
{
	function __construct($code, $msg){
		$this->_code = $code;
		$this->_msg = $msg;
	}

	public function get_error(){
		return $this->_code.' '.$this->_msg;
	}

	public function get_code(){
		return $this->_code;
	}

	public function get_message($httpErrorCodeMsg){
		return $this->_msg;
	}

	public function __toString(){
		return $this->get_error();
	}
}

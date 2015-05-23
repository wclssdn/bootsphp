<?php

namespace Web\Plugin\Base;

use \Resource\Base\HtmlController;

class Controller extends HtmlController {

	protected $jsonCallback;

	protected function setJsonCallback($callback){
		$this->jsonCallback = $callback;
	}

	protected function jsonSuccess($message = '', array $data = array()){
		$this->jsonOutput(0, $message, $data);
	}

	protected function jsonError($code, $message = '', array $data = array()){
		$this->jsonOutput($code, $message, $data);
	}

	protected function jsonOutput($code, $message, array $data = array()){
		if ($this->jsonCallback){
			echo $this->jsonCallback . '(' . json_encode(array(
				'code' => $code, 
				'message' => $message, 
				'data' => $data)) . ');';
		}else{
			echo json_encode(array(
				'code' => $code, 
				'message' => $message, 
				'data' => $data));
		}
		exit(0);
	}
}
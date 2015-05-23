<?php

namespace Web\Service\Base;

use Resource\Base\ServiceController;

class Controller extends ServiceController{

	public function ___404___Action() {
		$this->error('404 not found', self::CODE_ERROR_BAD_REQUEST);
	}
}
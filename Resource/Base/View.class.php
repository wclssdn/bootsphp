<?php

namespace Resource\Base;

use BootsPHP\Exception\FileNotExistsException;

class View {

	protected $templateFile;

	protected $templatePath;

	protected $templateSubPath;

	private $templateData = array();

	private $tempTemplateData = array();

	public function setTemplatePath($templatePath){
		$this->templatePath = $this->getPath($templatePath);
	}

	public function getTemplatePath(){
		return $this->templatePath;
	}

	public function setTemplateSubPath($templateSubPath){
		$this->templateSubPath = $this->getPath($templateSubPath);
		$this->templateSubPath == DIRECTORY_SEPARATOR && $this->templateSubPath = '';
	}

	public function getTemplateSubPath(){
		return $this->templateSubPath;
	}

	public function setTemplateFile($templateFile){
		$this->templateFile = $templateFile;
	}

	public function getTemplateFile(){
		return $this->templateFile;
	}

	public function setTemplateData(array $templateData){
		$this->templateData = $templateData;
	}

	public function getTemplateData(){
		return $this->templateData;
	}

	/**
	 *
	 * @param unknown $data
	 */
	public function setTempTemplateData($data){
		$this->tempTemplateData = $data;
	}

	/**
	 * 显示
	 * @param array $templateData 不会写入到对象中, 但是同样存在污染变量的风险
	 * @param string $templateFile 不会影响对象原来的值
	 * @param string $templateSubPath 指定模板文件所在的子目录
	 * @throws FileNotExistsException
	 */
	public function display($templateFile = '', $templateSubPath = ''){
		$templateData = $this->templateData;
		$this->tempTemplateData && $templateData = array_merge($this->templateData, $this->tempTemplateData);
		$this->tempTemplateData = array();
		$templateFile || $templateFile = $this->templateFile;
		$templateSubPath && $templateSubPath = $this->getPath($templateSubPath);
		$filename = $this->templatePath . ($templateSubPath ? $templateSubPath : $this->templateSubPath) . $templateFile;
		if (!is_file($filename)){
			throw new FileNotExistsException("File {$filename} is not found!");
		}
		call_user_func(function ($filename, $vars){
			$vars && extract($vars);
			include $filename;
		}, $filename, $templateData);
	}

	public function fetch($templateFile = ''){
		ob_start();
		$this->display($templateFile);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	private function getPath($path){
		return rtrim(str_replace('/', DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
	}
}
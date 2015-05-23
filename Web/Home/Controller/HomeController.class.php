<?php

namespace Web\Home\Controller;

use \Web\Home\Base\Controller;
use BootsPHP\Exception\QuitException;
use Resource\Model\ArticleModel;
use BootsPHP\Log;
class HomeController extends Controller {
	
	public function __construct(){
		parent::__construct();
		$this->view->setTemplatePath(PATH_ROOT . 'Web/Home/View/Home');
	}

	public function indexAction(){
		$page = max(1, $this->request->getParam('page', 'int'));
		$size = 10;
		Log::init('test app', __DIR__);
		Log::extraLog('uid:123');
		//只记录ERROR级别的日志, 不输出到header(默认不输出log到header)
		Log::setLogWriteLevel(Log::LOG_LEVEL_ERROR); //only log LOG_LEVEL_ERROR
		Log::debug('this is a test. And wont write in file.');
		Log::warning('another test. also not in file.');
		Log::error('a error!');
		//记录warning和error级的日志, 不输出header
		Log::setLogWriteLevel(Log::LOG_LEVEL_ERROR | Log::LOG_LEVEL_WARNING); //log LOG_LEVEL_ERROR and LOG_LEVEL_WARNING
		Log::debug('this is a test. orz...');
		Log::warning('another test and some data', array(1,2,3));
		Log::error('a error!');
		//记录非debug级的日志, 输出debug级的日志到header
		Log::setLogWriteLevel(~Log::LOG_LEVEL_DEBUG); //except log LOG_LEVEL_DEBUG
		Log::openSendHeader(); //no online use. suggest for develop use.
		Log::setLogSendHeaderLevel(Log::LOG_LEVEL_DEBUG); //only send LOG_LEVEL_DEBUG log to header
		Log::debug('this is a test. And wont write in file. but in header~');
		Log::notice('this a notice...');
		Log::warning('another test and some data. will write to file.', array(1,2,3));
		Log::error('a error!');

		$articleModel = new ArticleModel();
		try{
// 			$id = $articleModel->addArticle('测试标题', '内容正文');
// 			var_dump("新增文章ID:{$id}");
// 			$article = $articleModel->getArticle($id);
// 			var_dump('内容:', $article);
// 			$result = $articleModel->editArticle($id, '修改后的标题', '修改后的正文');
// 			var_dump("修改文章:" . var_export($result, true));
// 			$articleList = $articleModel->getArticleList($page, $size);
// 			var_dump('文章列表:', $articleList);
// 			$result = $articleModel->delArticle($id);
// 			var_dump('删除文章:' . var_export($result, true));
// 			$articleList = $articleModel->getArticleList($page, $size);
// 			var_dump('文章列表:', $articleList);
		}catch (\Exception $e){
			$this->busy($e->getMessage());
		}
		$this->assign('title', 'BootsPHP');
		$this->show();
	}

	public function ___404___Action(){
		$this->assign('title', '该页面无法找到');
		$this->show(array(), '404.tpl.php', $this->request->getWebRootFilePath() . 'View/Public');
	}

	private function busy($message){
		$this->assign('title', '系统繁忙');
		$this->show(array('message' => $message), 'busy.tpl.php', $this->request->getWebRootFilePath() . 'View/Public');
		throw new QuitException();
	}
}

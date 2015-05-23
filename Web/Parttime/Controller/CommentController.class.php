<?php

namespace Web\Parttime\Controller;

use Web\Parttime\Base\Controller;
use Resource\Model\ParttimeCommentModel;
use BootsPHP\Response;
use Resource\Model\PosterModel;
use Resource\Model\TwitterModel;
use BootsPHP\Util\Arr;
use Resource\Model\ShopModel;

class CommentController extends Controller{

	public function __construct() {
		parent::__construct();
		$this->view->setTemplateSubPath('Comment');
		if ($this->request->getAction() != 'loadTaskTwitter') {
			$this->checkLogin();
		}
	}

	/**
	 * 评论任务首页
	 */
	public function indexAction() {
		$commentModel = new ParttimeCommentModel();
		$this->assign('title', '评论任务 美丽说兼职平台');
		$this->show();
	}

	/**
	 * 获取一个待评论的推
	 */
	public function getTwitterAction() {
		$parttimeCommentModel = new ParttimeCommentModel();
		$twitterInfo = $parttimeCommentModel->getUnCommentTwitter($this->user['user_id']);
		if ($twitterInfo){
			$shopModel = new ShopModel();
			$shopTwitterInfo = $shopModel->getTwitterInfo($twitterInfo['twitter_id']);
			$this->success('获取成功', array('twitter_id' => $twitterInfo['twitter_id'], 'shop' => isset($shopTwitterInfo[$twitterInfo['twitter_id']]) ? true : false));
		}
		$this->error('获取推失败, 可能已经没有待评论的推了');
	}

	/**
	 * 加载需要评论的推
	 */
	public function loadTaskTwitterAction() {
		$parttimeCommentModel = new ParttimeCommentModel();
		$posterModel = new PosterModel();
		$twitterModel = new TwitterModel();
		$twitterList = $parttimeCommentModel->getTwitterListByStatus(array(
			ParttimeCommentModel::TASK_STATUS_NORMAL,
			ParttimeCommentModel::TASK_STATUS_PAUSE));
		if ($twitterList){
			$update = array();
			$limit = 30;
			do{
				$tids = array_slice($twitterList, 0, $limit, true);
				$twitterList = array_slice($twitterList, $limit, null, true);
				$twitterState = $twitterModel->getTwitterStatus(array_keys($tids));
				foreach ($twitterState as $v){
					if (!$v){
						continue;
					}
					if ($v['discuss_num'] >= $tids[$v['twitter_id']]['goal']){
						$update[$v['twitter_id']] = ParttimeCommentModel::TASK_STATUS_COMPLETED;
					}
				}
			}while ($twitterList);
			if ($update){
				if ($parttimeCommentModel->updateTask(array_keys($update), array_values($update))){
					echo 'update task success ', implode(',', array_keys($update)), PHP_EOL;
				}else{
					echo 'update task failed ', json_encode($update), PHP_EOL;
				}
			}
		}
		$posterList = $parttimeCommentModel->getPosterList(1, 10);
		$posterIds = Arr::subValues($posterList, 'poster_id');
		if (!$posterIds){
			echo 'no poster id', PHP_EOL;
			exit();
		}
		$task = array();
		foreach ($posterIds as $posterId){
			$twitterList = $posterModel->getPosterTwitterList($posterId, 1, 320);
			$twitterState = $twitterModel->getTwitterStatus($twitterList);
			foreach ($twitterState as $v){
				if (!$v){
					continue;
				}
				$goal = rand(5, 20);
				if ($v['discuss_num'] < $goal){
					$task[$v['twitter_id']] = $goal;
				}
			}
		}
		if ($task){
			if (!$parttimeCommentModel->addTask(array_keys($task), array_values($task))){
				echo 'add task failed ', json_encode($task), PHP_EOL;
			}
		}
		echo 'done', PHP_EOL;
	}

	/**
	 * 提交评论
	 */
	public function commentAction() {
		if (!$this->request->isPost()){
			$this->error('非法请求', Response::STATUS_METHOD_NOT_ALLOWED);
		}
		$twitterId = $this->request->getParam('twitter_id');
		$content = $this->request->getParam('content');
		if (mb_strlen($content, 'utf8') < 8){
			$this->error('评论字数不能小于8个');
		}
		$parttimeCommentModel = new ParttimeCommentModel();
		$robotUid = $parttimeCommentModel->getUnCommentRobot($twitterId);
		if (!$robotUid){
			$this->error('此推已经无法再评论, 请换下一个推(刷新页面重新开始工作)');
		}
		$twitterModel = new TwitterModel();
		$commentId = $twitterModel->comment($twitterId, $robotUid, $content);
		if (!$commentId){
			$this->error('评论提交失败, 请重试');
		}
		if ($parttimeCommentModel->comment($twitterId, $this->user['user_id'], $robotUid, $commentId, $content)){
			$this->success();
		}
		$this->error('系统繁忙, 请重试');
	}

	/**
	 * 获取审核统计
	 */
	public function getStatisticsAction() {
		$parttimeCommentModel = new ParttimeCommentModel();
		$today = date('Y-m-d');
		$todayCount = $parttimeCommentModel->getUserCommentCount($this->user['user_id'], $today);
		if ($todayCount === false) {
			$this->error('系统繁忙');
		}
		$statistics = array('today' => $todayCount,'goal' => 500);
		$this->success('', $statistics);
	}
}
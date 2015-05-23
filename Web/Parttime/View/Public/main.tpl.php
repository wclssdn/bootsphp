<?php use BootsPHP\Util\TemplateHelper as H;?>
<div class="span10 main">
	<div class="current">
		<ul class="breadcrumb">
			<li><span class="text">当前位置：</span></li>
			<?php if ($controller):?>
			<li><a href="<?php H::S($controller['url']);?>" class="link"><?php H::S($controller['title']);?></a><span class="divider">/</span></li>
			<?php endif;?>
			<?php if (isset($action)):?>
			<li class="active"><?php H::S($action['title']);?></li>
			<?php endif;?>
			<li class="pull-right">
				<?php if (isset($btns['add']) && $btns['add']):?><a href="<?php H::S($btns['add'])?>" class="btn">新增</a><?php endif;?>
				<?php if ($exportAble && isset($btns['export']) && $btns['export']):?><a href="<?php H::S($btns['export'])?>" class="btn">导出</a><?php endif;?>
				<?php if ($printAble && isset($btns['print']) && $btns['print']):?><a href="<?php H::S($btns['print'])?>" id="btn-print" class="btn">打印</a><?php endif;?>
			</li>
		</ul>
	</div>
	<div class="data">
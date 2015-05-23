
<div class="span2 left">
	<div class="top-btns">
		<a href="/" class="btn btn-info">系统首页</a><?php if ($user):?> <a href="/User/logout" class="btn btn-warning">退出系统</a><?php endif;?>
	</div>
	<div>
		<ul class="menu nav nav-list">
			<?php if (array_key_exists('AttendanceCheck|index', $permissions)):?>
			<li class="p<?php if ($controller == 'AttendanceCheck'):?> active<?php endif;?>"><a href="/AttendanceCheck">考勤管理<span class="summary">概要</span></a></li>
			<?php endif;?>
			<?php if (array_key_exists('AttendanceCheck|record', $permissions)):?><li class="sub <?php if ($controller == 'AttendanceCheck' && $action == 'record'):?>subactive<?php endif;?>"><a href="/AttendanceCheck/record">考勤录入</a></li><?php endif;?>
			<?php if (array_key_exists('AttendanceCheck|statistics', $permissions)):?><li class="sub <?php if ($controller == 'AttendanceCheck' && $action == 'statistics'):?>subactive<?php endif;?>"><a href="/AttendanceCheck/statistics">查询统计</a></li><?php endif;?>
		
			<li class="p<?php if ($controller == 'SealRecord'):?> active<?php endif;?>"><a href="/SealRecord">公章报备<span class="summary">概要</span></a></li>
			<?php if (array_key_exists('SealRecord|myList', $permissions)):?><li class="sub <?php if ($controller == 'SealRecord' && $action == 'myList'):?>subactive<?php endif;?>"><a href="/SealRecord/myList">我的报备</a></li><?php endif;?>
			<?php if (array_key_exists('SealRecord|add', $permissions)):?><li class="sub <?php if ($controller == 'SealRecord' && $action == 'add'):?>subactive<?php endif;?>"><a href="/SealRecord/add">新增报备</a></li><?php endif;?>
			<?php if (array_key_exists('SealRecord|list', $permissions)):?><li class="sub <?php if ($controller == 'SealRecord' && $action == 'list'):?>subactive<?php endif;?>"><a href="/SealRecord/list">审批报备</a></li><?php endif;?>
			<?php if (array_key_exists('SealRecord|statistics', $permissions)):?><li class="sub <?php if ($controller == 'SealRecord' && $action == 'statistics'):?>subactive<?php endif;?>"><a href="/SealRecord/statistics">查询统计</a></li><?php endif;?>
			<?php if (array_key_exists('SealRecord|month', $permissions)):?><li class="sub <?php if ($controller == 'SealRecord' && $action == 'month'):?>subactive<?php endif;?>"><a href="/SealRecord/month">本月统计</a></li><?php endif;?>
			
			<li class="p<?php if ($controller == 'CarRecord'):?> active<?php endif;?>"><a href="/CarRecord">公车报备<span class="summary">概要</span></a></li>
			<?php if (array_key_exists('CarRecord|myList', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'myList'):?>subactive<?php endif;?>"><a href="/CarRecord/myList">我的报备</a></li><?php endif;?>
			<?php if (array_key_exists('CarRecord|add', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'add'):?>subactive<?php endif;?>"><a href="/CarRecord/add">新增报备</a></li><?php endif;?>
			<?php if (array_key_exists('CarRecord|list', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'list'):?>subactive<?php endif;?>"><a href="/CarRecord/list">审批报备</a></li><?php endif;?>
			<?php if (array_key_exists('CarRecord|statistics', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'statistics'):?>subactive<?php endif;?>"><a href="/CarRecord/statistics">查询统计</a></li><?php endif;?>
			<?php if (array_key_exists('CarRecord|month', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'month'):?>subactive<?php endif;?>"><a href="/CarRecord/month">本月统计</a></li><?php endif;?>
			<?php if (array_key_exists('CarRecord|car', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'car'):?>subactive<?php endif;?>"><a href="/CarRecord/car">车辆管理</a></li><?php endif;?>
			<?php if (array_key_exists('CarRecord|carType', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'carType'):?>subactive<?php endif;?>"><a href="/CarRecord/carType">车辆性质管理</a></li><?php endif;?>
			<?php if (array_key_exists('CarRecord|driver', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'driver'):?>subactive<?php endif;?>"><a href="/CarRecord/driver">司机管理</a></li><?php endif;?>
			<?php if (array_key_exists('CarRecord|reason', $permissions)):?><li class="sub <?php if ($controller == 'CarRecord' && $action == 'reason'):?>subactive<?php endif;?>"><a href="/CarRecord/reason">出车事由管理</a></li><?php endif;?>
			
			<li class="p<?php if ($controller == 'TripRecord'):?> active<?php endif;?>"><a href="/TripRecord">出京报备<span class="summary">概要</span></a></li>
			<?php if (array_key_exists('TripRecord|myList', $permissions)):?><li class="sub <?php if ($controller == 'TripRecord' && $action == 'myList'):?>subactive<?php endif;?>"><a href="/TripRecord/myList">我的报备</a></li><?php endif;?>
			<?php if (array_key_exists('TripRecord|add', $permissions)):?><li class="sub <?php if ($controller == 'TripRecord' && $action == 'add'):?>subactive<?php endif;?>"><a href="/TripRecord/add">新增报备</a></li><?php endif;?>
			<?php if (array_key_exists('TripRecord|list', $permissions)):?><li class="sub <?php if ($controller == 'TripRecord' && $action == 'list'):?>subactive<?php endif;?>"><a href="/TripRecord/list">审批报备</a></li><?php endif;?>
			<?php if (array_key_exists('TripRecord|statistics', $permissions)):?><li class="sub <?php if ($controller == 'TripRecord' && $action == 'statistics'):?>subactive<?php endif;?>"><a href="/TripRecord/statistics">查询统计</a></li><?php endif;?>
			<?php if (array_key_exists('TripRecord|month', $permissions)):?><li class="sub <?php if ($controller == 'TripRecord' && $action == 'month'):?>subactive<?php endif;?>"><a href="/TripRecord/month">本月统计</a></li><?php endif;?>
			
			<li class="p<?php if ($controller == 'PraiseRecord'):?> active<?php endif;?>"><a href="/PraiseRecord" style="padding:3px 0 3px 15px;min-width:123px">表扬信(锦旗)登记<span class="summary">概要</span></a></li>
			<?php if (array_key_exists('PraiseRecord|myList', $permissions)):?><li class="sub <?php if ($controller == 'PraiseRecord' && $action == 'myList'):?>subactive<?php endif;?>"><a href="/PraiseRecord/myList">我的报备</a></li><?php endif;?>
			<?php if (array_key_exists('PraiseRecord|add', $permissions)):?><li class="sub <?php if ($controller == 'PraiseRecord' && $action == 'add'):?>subactive<?php endif;?>"><a href="/PraiseRecord/add">新增报备</a></li><?php endif;?>
			<?php if (array_key_exists('PraiseRecord|list', $permissions)):?><li class="sub <?php if ($controller == 'PraiseRecord' && $action == 'list'):?>subactive<?php endif;?>"><a href="/PraiseRecord/list">审批报备</a></li><?php endif;?>
			<?php if (array_key_exists('PraiseRecord|statistics', $permissions)):?><li class="sub <?php if ($controller == 'PraiseRecord' && $action == 'statistics'):?>subactive<?php endif;?>"><a href="/PraiseRecord/statistics">查询统计</a></li><?php endif;?>
			<?php if (array_key_exists('PraiseRecord|month', $permissions)):?><li class="sub <?php if ($controller == 'PraiseRecord' && $action == 'month'):?>subactive<?php endif;?>"><a href="/PraiseRecord/month">本月统计</a></li><?php endif;?>
			
			<li class="p<?php if ($controller == 'HouseholdSealRecord'):?> active<?php endif;?>"><a href="/HouseholdSealRecord">户籍章报备<span class="summary">概要</span></a></li>
			<?php if (array_key_exists('HouseholdSealRecord|myList', $permissions)):?><li class="sub <?php if ($controller == 'HouseholdSealRecord' && $action == 'myList'):?>subactive<?php endif;?>"><a href="/HouseholdSealRecord/myList">我的报备</a></li><?php endif;?>
			<?php if (array_key_exists('HouseholdSealRecord|add', $permissions)):?><li class="sub <?php if ($controller == 'HouseholdSealRecord' && $action == 'add'):?>subactive<?php endif;?>"><a href="/HouseholdSealRecord/add">新增报备</a></li><?php endif;?>
			<?php if (array_key_exists('HouseholdSealRecord|list', $permissions)):?><li class="sub <?php if ($controller == 'HouseholdSealRecord' && $action == 'list'):?>subactive<?php endif;?>"><a href="/HouseholdSealRecord/list">审批报备</a></li><?php endif;?>
			<?php if (array_key_exists('HouseholdSealRecord|statistics', $permissions)):?><li class="sub <?php if ($controller == 'HouseholdSealRecord' && $action == 'statistics'):?>subactive<?php endif;?>"><a href="/HouseholdSealRecord/statistics">查询统计</a></li><?php endif;?>
			<?php if (array_key_exists('HouseholdSealRecord|month', $permissions)):?><li class="sub <?php if ($controller == 'HouseholdSealRecord' && $action == 'month'):?>subactive<?php endif;?>"><a href="/HouseholdSealRecord/month">本月统计</a></li><?php endif;?>
			
			<?php if (array_key_exists('User|list', $permissions)):?><li class="p<?php if ($controller == 'User' && !in_array($action, array('login', 'logout'))):?> active<?php endif;?>"><a href="/User">人员管理</a></li><?php endif;?>
			<?php if (array_key_exists('User|entry', $permissions)):?><li class="sub <?php if ($controller == 'User' && $action == 'entry'):?>subactive<?php endif;?>"><a href="/User/entry">录入人员</a></li><?php endif;?>
			<?php if (array_key_exists('User|list', $permissions)):?><li class="sub <?php if ($controller == 'User' && $action == 'list'):?>subactive<?php endif;?>"><a href="/User/list">人员列表</a></li><?php endif;?>
			<?php if (array_key_exists('Role|list', $permissions)):?><li class="p<?php if ($controller == 'Role'):?> active<?php endif;?>"><a href="/Role/list">权限管理</a></li><?php endif;?>
			<?php if (array_key_exists('Role|list', $permissions)):?><li class="sub <?php if ($controller == 'Role' && $action == 'list'):?>subactive<?php endif;?>"><a href="/Role/list">角色管理</a></li><?php endif;?>
		</ul>
	</div>
</div>
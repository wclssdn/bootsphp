<?php

namespace Resource\Dao;

use Resource\Base\Dao;

class AdminUserDao extends Dao{

	protected $databaseConfigKey = DATABASE_KEY_OP;
	
	protected $database = 'dolphin_stat';

	protected $tableName = 't_dolphin_admin_user';
}
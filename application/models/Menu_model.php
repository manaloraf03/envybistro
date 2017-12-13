<?php
	class Menu_model extends CORE_Model
	{
		protected $table="refmenu";
		protected $pk_id="menu_id";
		function __construct()
		{
			parent::__construct();
		}
	}
?>
<?php
class Task_list_model extends MY_Model 
{
    public $_table = 'pct_hr_employee_task_list';
    public $belongs_to = array( 'category' => array( 'model' => 'hr/task_list_category','primary_key' => 'category_id' ));
	public $has_many = array( 'users' => array( 'model' => 'hr/pct_hr_employee_task_list_complete','primary_key' => 'task_id' ));
}

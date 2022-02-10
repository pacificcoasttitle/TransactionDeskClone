<?php
class Users_model extends MY_Model 
{
    public $_table = 'pct_hr_users';
    public $has_many = array( 'tasks' => array( 'model' => 'hr/pct_hr_employee_task_list_complete','primary_key' => 'employee_id' ));

}

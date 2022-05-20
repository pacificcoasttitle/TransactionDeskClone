<?php
class Underwriter_user_model extends MY_Model 
{
    public $_table = 'pct_underwriter_users';
	public $belongs_to = array( 'underwriter_tier_obj' => array( 'model' => 'admin/order/underwriter_tier_model','primary_key' => 'underwriter_tier_id' ));
}

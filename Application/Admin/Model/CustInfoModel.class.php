<?php 
namespace admin\Model;
use \Think\Model;
class CustInfoModel extends Model{

	// 处理查询数据
	public function my_select(){
		$list = $this->select();

		foreach($list as $k=>$v){
			$list[$k]['cust_sex'] 	 = ($v['cust_sex'] == 1)?'男':'女';
			$list[$k]['create_date'] = date('Y/m/d H:i:s', $v['create_date']);
			$list[$k]['birthday']    = date('Y/m/d H:i:s', $v['birthday']);
			// $list[$k]['join_year']   = date('Y/m/d H:i:s', $v['join_year']); 
		}

		return $list;
	}
}

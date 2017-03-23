<?php
	// 检查必要参数
	function check_empty($arr){
		foreach($arr as $v){
	        if(!isset($_POST[$v]) || empty($_POST[$v])){
	            returnJson('Error', 100001, '必要参数'.$v.'不能为空');
	            exit;
	        }
	    } 
	    return false; 
	}

	// 检查参数
	function test($param){
		if($param){
			echo "Success!!";exit;
		}
		echo "Error!!"; exit;
	}

	// 检查数据库操作是否成功
	function check_exec($result, $type='add'){
		switch($type){
			case  'add': 
				$error_str  = '创建数据库对象错误';
				$succ_msg   = '添加成功';
				$error_code = 200001;
				break;
			case  'delete':	
				$error_str  = "删除数据库对象错误";
				$succ_msg   = '删除成功';
				$error_code = 200002;
				break;
			case 'save': 
				$error_str  = "更新数据库对象错误";	
				$succ_msg   = '更新成功';
				$error_code = 200003;
				break;
		}

		if($result){
			returnJson('Success', 200, $succ_msg);
		}else{
			returnJson('Error', $error_code, $error_str);
		}	
		exit;
	}

	// 检查token
	function check_token($cust_tel){
		$res = redis_get('token_'.$cust_tel);
		if(!$res){
			returnJson($cust_tel, 100003, 'token错误');
		}
		return true;
	}

	/**
	 * [get_cust_info 通过post.cust_tel参数获取用户信息]
	 * @param  boolean $is_info [默认false， 只获取用户编号,  传参数获查询字段]
	 * @return [type]           [mixed]
	 */
	function get_cust_info($is_info=false){
		// 电话不能为空
		if(!$_POST['cust_tel']){
			returnJson('Error', 100001, '电话不能为空');
		}else{
			// 检查token
			check_token(I('cust_tel'));
		}
		if($is_info){
			// 返回详情
			return D('CustInfo')->field($is_info)->where(['cust_tel'=>I('cust_tel')])->find();
		}else{
			// 用户编号
			$ret = D('CustInfo')->getFieldByCustTel(I('cust_tel'), 'id');
			if(!$ret){
				returnJson('Error', 100002, '号码错误');
			}
			return $ret;
		}
	}

	// 检查查询结果
	function check_sel_res($res){
		if(!$res){
			returnJson('Success', 200, '暂无数据');
		}
		return true;
	}

	// 检查新增结果
	function check_add_res($res){
		if(!$res){
			returnJson('Error', 200001, '新增数据失败');
		}
		return false;
	}

	function check_save_res($res){
		if(!$res){
			returnJson('Error', 200003, '修改失败');
		}
		return false;
	}

	function check_del_res($res){
		if(!$res){
			returnJson('Error', 200004, '删除失败');
		}
		return false;
	}
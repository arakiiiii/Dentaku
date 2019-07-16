<?php

namespace App\Http\Model;

class TestDAO
{
    public function __construct()
    {
    }

    public function selectTest($inputs)
    {
    	$where = array();
    	$whereString = " WHERE delete_flag = 0 ";
    	if (isset($inputs["userId"]) && $inputs["userId"] != "") {
    		$where[] = $inputs["userId"];
    		$whereString .= " and m_user_sid = ? ";
    	}
    	if (isset($inputs["key"]) && $inputs["key"] != "") {
    		$where[] = $inputs["key"];
    		$whereString .= " and `key` = ? ";
    	}

    	$results = \DB::select("SELECT * FROM m_setting " . $whereString . " ORDER BY sid", $where);

    	return $results;
    }
}

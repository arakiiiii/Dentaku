<?php

namespace App\Http\Logic;
use Illuminate\Http\Request;

class BaseLogic
{
    public function __construct()
    {
    }

    protected function getRequestParameter(Request $request) {
    	$returnArray = array();
    	foreach ($request->all() as $key => $value) {
    		$returnArray[$key] = $value;
    	}
    	return $returnArray;
    }
}

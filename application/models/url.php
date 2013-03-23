<?php

class Url extends Eloquent{
	public static $timestamps = false;
	public static $rules = array(
			'url' => 'required|url'
		);

	public static function validate($url){
		$v = Validator::make($url, static::$rules);

		return $v;
	}
}

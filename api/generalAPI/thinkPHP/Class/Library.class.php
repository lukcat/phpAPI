<?php
/*
 * 公共方法集合类   这个类  自己可以扩充
 */
class Library{
	//随机生成 5 个字母的字符串
	public static function getRndstr($length=5){
		$str='abcdefghijklmnopqrstuvwxyz';
		for($i=0;$i<$length;$i++){
			$rndcode=rand(0,25);
			$rndstr.=$str[$rndcode];
		}
		return $rndstr;
	}	
	//随机生成 6 位数字短信码
	public static function getSmsCode($length=6){
			return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
	}
	/*
	 *  短信获取验证码    这里需要根据您的对接接口参数进行更改
	 */
	public static function sendSmsCode($mobile){
		$sms_code = self::getSmsCode();   //获取随机码
		$uid = '';		//短信api账号
		$pwd = '';		//密码
		$content = iconv('UTF-8','GBK','感谢注册，您的验证码为：'.$sms_code.'【签名】');		
		//即时发送
		$url = "http://短信接口域名?uid=".$uid."&pwd=".$pwd."&mobile=".$mobile."&content=".$content;
		$data = array();
		$data['sms_code'] = $sms_code;
		$data['sms_result'] = file_get_contents($url);
		return $data;
	}		
	/*
	 * 数据去重复并重新排序
	 */
	public static function arrayUnique($array){
		$out = array();
		foreach ($array as $key=>$value) {
			if (!in_array($value, $out))
			{
				$out[$key] = $value;
			}
		}
		sort($out);    //重新排序
		return $out;
	}	
}
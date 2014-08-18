<?php
/**
 * 用户信息修复定时同步文件
 *
 * @Author 田龙哲
 * @E-Mail  	tianlongzhe@shiqutech.com
 * @Date    	2013-04-12
 * @Update  	2013-04-12
 * @version 	1.0
 * @WebSite  	http://app.social-touch.com
 * @copyright  © 2013 Social Touch Co.,Ltd. All rights reserved
 */
class SynchronousUserInfoCommand extends CConsoleCommand
{
	/**
	 * 开始
	 * @see CConsoleCommand::run()
	 */
	public function run($argv) {
		echo 'starting',"\n";
		// 同步数据
		self::synchronousUserInfo();
		echo 'end!';
	}
	
	/**
	 * 同步错误用户信息
	 */
	private function synchronousUserInfo() {
		// 获取用户列表
		$userList = self::getUserList();
		if (is_array($userList) && count($userList) > 0) {
			foreach ($userList AS $key => $value) {
				// 获取用户token信息
				$tokenInfo = Token::model()->getTokenInfo($value['sina_uid']);
				if (!empty($tokenInfo['oauth_token'])) {
					// 更新用户信息
					User::model()->updateUser($value['sina_uid'], $tokenInfo['oauth_token']);
				}
			}
		}
	}
	
	/**
	 * 获取用户列表
	 * 
	 * @return Array <multitype:, multitype:NULL >
	 */
	private function getUserList() {
		return User::model()->getErrorUserList();
	}
}
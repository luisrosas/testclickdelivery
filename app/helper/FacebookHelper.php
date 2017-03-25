<?php

class FacebookHelper
{

	private $fb;
	private $helper;

	public function __construct()
	{
		if (!session_id()) {
			session_start();
		}
		$this->fb = new Facebook\Facebook([
			'app_id' => Config::get('facebook.app_id'),
			'app_secret' => Config::get('facebook.app_secret'),
			'default_graph_version' => 'v2.8',
		]);

		$this->helper = $this->fb->getRedirectLoginHelper();
	}

	public function getUrl($callback)
	{
		return $this->helper->getLoginUrl($callback, Config::get('facebook.app_scope'));
	}
/*
	public function getUrlLogin()
	{
		return $this->helper->getLoginUrl(url('login/fb/callback'), Config::get('facebook.app_scope'));
	}

	public function getUrlRegister()
	{
		return $this->helper->getLoginUrl(url('register/fb/callback'), Config::get('facebook.app_scope'));
	}
*/
	public function getDataUser()
	{
		$response = null;
		try {
			$response = $this->fb->get('/me?fields=id,name,email', $this->helper->getAccessToken());
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		}

		return ($response != null ? $response->getGraphUser() : null);
	}
}
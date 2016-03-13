<?php

class Github
{
	/**
	 * @var string
	 */
	protected $accessToken;

	/**
	 * @var string
	 */
	protected $baseUrl = 'https://api.github.com';

	/**
	 * @param string $accessToken
	 * @return \app\Github
	 */
	public function setAccessToken($accessToken) {
		$this->accessToken = $accessToken;
		return $this;
	}

	public function getLatestRelease() {
		$owner = 'wowtransfer';
		$repo = 'wowtransfer-php-client';
		$url = $this->baseUrl . "/repos/$owner/$repo/releases/latest";
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL              => $url,
			CURLOPT_RETURNTRANSFER   => 1,
			CURLOPT_SSL_VERIFYHOST   => 0,
			CURLOPT_SSL_VERIFYPEER   => 0,
			CURLOPT_USERAGENT        => 'wowtransfer-php-client',
		]);
		$response = curl_exec($ch);
		curl_close($ch);

		return json_decode($response);
	}
}

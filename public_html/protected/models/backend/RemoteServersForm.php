<?php

class RemoteServersForm extends PhpFileForm
{
	/**
	 * @var int[]
	 */
	protected $realmsExcludeIds = [];

	public function load()
	{
		$filePath = $this->getConfigFilePath();
		if (file_exists($filePath)) {
			$this->realmsExcludeIds = require $filePath;
		}
	}

	public function save()
	{
		$filePath = $this->getConfigFilePath();

		$result = 0;
		$h = fopen($filePath, 'w');

		if ($h) {
			$result = fwrite($h, '<?php return ');
			$result |= fwrite($h, var_export($this->realmsExcludeIds, true));
			$result |= fwrite($h, ';');
			fclose($h);
		}
		return $result;
	}

	/**
	 * @return string
	 */
	protected function getConfigFilePath()
	{
		$filePath =  'config' . DIRECTORY_SEPARATOR . 'remote-servers-local.php';
		return Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . $filePath;
	}

	/**
	 * @return string
	 */
	protected function getDefaultConfigFilePath()
	{
		$filePath =  'config' . DIRECTORY_SEPARATOR . 'remote-servers.php';
		return Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . $filePath;
	}

	/**
	 * @param int[] $ids
	 * @return \RemoteServersForm
	 */
	public function setRealmsIds($ids)
	{
		$this->realmsExcludeIds = $ids;
		return $this;
	}

	/**
	 * @return int[]
	 */
	public function getRealmsIds()
	{
		return $this->realmsExcludeIds;
	}
}
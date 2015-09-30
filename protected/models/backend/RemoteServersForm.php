<?php

class RemoteServersForm extends PhpFileForm
{
	/**
	 * @var int[]
	 */
	protected $realmsExcludeIds = [];

	public function load() {
		$filePath = $this->getConfigFilePath();
		if (file_exists($filePath)) {
			$this->realmsExcludeIds = require $filePath;
		}
	}

	public function save() {
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
		return Yii::getPathOfAlias('application') . '/config/remote-servers-local.php';
	}

	/**
	 * @param int[] $ids
	 * @return \RemoteServersForm
	 */
	public function setRealmsIds($ids) {
		$this->realmsExcludeIds = $ids;
		return $this;
	}

	/**
	 * @return int[]
	 */
	public function getRealmsIds() {
		return $this->realmsExcludeIds;
	}
}
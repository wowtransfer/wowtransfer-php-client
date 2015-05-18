<?php

/**
 * Stores options in the files
 */
class PhpFileForm extends CFormModel {

	/**
	 * @var array
	 */
	protected $workAttributes = [];

	/**
	 * @var array 
	 */
	protected $params;

	/**
	 * @var boolean
	 */
	protected $safeStore;

	/**
	 * @var string
	 */
	protected $filePath;

	/**
	 * @param string $scenario
	 */
	public function __construct($scenario = '') {
		parent::__construct($scenario);
	}

	/**
	 * @return boolean
	 */
	public function getSafeStore() {
		return $this->safeStore;
	}

	/**
	 * @param boolean $safeStore
	 * @return \PhpFileForm
	 */
	public function setSafeStore($safeStore) {
		$this->safeStore = $safeStore;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFilePath() {
		return $this->filePath;
	}

	/**
	 * @param string $filePath
	 * @return \PhpFileForm
	 */
	public function setFilePath($filePath) {
		$this->filePath = $filePath;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getWorkAttributes($names = null) {
		return $this->workAttributes;
	}

	/**
	 * @param array $attributes
	 * @return \PhpFileForm
	 */
	public function setWorkAttributes($attributes) {
		$this->workAttributes = $attributes;
		return $this;
	}

	/**
	 * @return boolean
	 * @throws Exception
	 */
	public function save() {
		if ($this->safeStore) { // TODO:
			// try write

			// ...

			// rollback
		}

		$params = [];
		foreach ($this->workAttributes as $attr) {
			$params[$attr] = $this->$attr;
		}

		$content = '<?php return ' . var_export($params, true) . ';';
		$h = fopen($this->filePath, 'w');
		if ($h) {
			fwrite($h, $content);
			fclose($h);
		}
		else {
			$error = "Couldn't open file " . $this->filePath;
		}

		if (isset($error)) {
			throw new Exception($error);
		}

		return true;
	}

	/**
	 * @param array $params
	 * @return \PhpFileForm
	 */
	public function loadFromArray($params) {
		foreach ($params as $name => $value) {
			if (property_exists($this, $name)) {
				$this->$name = $value;
			}
		}
		return $this;
	}

}

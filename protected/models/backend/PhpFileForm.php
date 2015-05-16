<?php

/**
 * Stores options in the files
 */
class PhpFileForm {

	/**
	 * @var CActiveForm
	 */
	protected $form;

	/**
	 * @var array
	 */
	protected $attributes;

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
	 * 
	 * @param CActiveForm $form
	 */
	public function __construct($form) {
		$this->form = $form;
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
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * @param array $attributes
	 * @return \PhpFileForm
	 */
	public function setAttributes($attributes) {
		$this->attributes = $attributes;
		return $this;
	}

	public function save() {
		$filePath = '';
		$content = '';
		
		if ($this->safeStore) {
			// try write

			// ...

			// rollback
		}

		$params = [];
		foreach ($this->attributes as $attr) {
			$params[$attr] = $this->form->$attr;
		}

		$content = '<?php return ' . var_export($params, true);
		$h = fopen($filePath, 'w');
		if ($h) {
			fwrite($h, $content);
			fclose($h);
		}
		else {
			$error = "Couldn't open file " . $filePath;
		}

		if (isset($error)) {
			throw new Exception($error);
		}
	}

	public function load() {
		
	}

}

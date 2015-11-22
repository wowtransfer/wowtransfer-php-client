<?php

namespace Installer;

use Installer\App;

class View
{
	/**
	 * @var array
	 */
	private $_errors = [];

	/**
	 * @var array
	 */
	private $_checkItems = [];

	/**
	 * @var array
	 */
	private $_hiddenFields = [];

	/**
	 * @var string
	 */
	protected $pageName;

	/**
	 * @var string
	 */
	protected $pageLayout;

	/**
	 * @var string
	 */
	protected $pageTitle;

	/**
	 * @var array
	 */
	protected $vars;

	/**
	 * @param string $name
	 * @return \Installer\View
	 */
	public function setPageName($name) {
		$this->pageName = $name;
		return $this;
	}

	/**
	 * @param string $name
	 * @return \Installer\View
	 */
	public function setPageLayout($name) {
		$this->pageLayout = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPageTitle() {
		return $this->pageTitle;
	}

	/**
	 * @param string $pageTitle
	 * @return \Installer\View
	 */
	public function setPageTitle($pageTitle) {
		$this->pageTitle = $pageTitle;
		return $this;
	}

	/**
	 * @throws \Exception
	 */
	public function render() {
		$pageFilePath = __DIR__ . '/templates/pages/' . $this->pageName . '.php';
		if (!is_file($pageFilePath)) {
			throw new \Exception('Страница не найдена: ' . $this->pageName, 404);
		}

		global $content;
		global $view;

		if (is_array($this->vars) && count($this->vars)) {
			extract($this->vars, EXTR_PREFIX_SAME, 'data');
		}

		ob_start();
		$view = $this;
		require $pageFilePath;
		$content = ob_get_clean();

		$layoutFilePath = __DIR__ . '/templates/layouts/' . $this->pageLayout . '.php';
		if (!$layoutFilePath) {
			throw new \Exception('Макет "' . $this->pageLayout . '" не найден', 404);
		}

		ob_start();
		require $layoutFilePath;
		$content = ob_get_clean();

		require __DIR__ . '/templates/index.php';

		unset($content);
		unset($view);
	}

	/**
	 * @param array $vars
	 * @return \Installer\View
	 */
	public function addVars($vars) {
		$this->vars = $vars;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLayoutContent() {
		
	}

	/**
	 * @return string isInstalledField's value by $name
	 */
	public function getFieldValue($name)
	{
		return isset($this->_hiddenFields[$name]) ? $this->_hiddenFields[$name] : '';
	}

	/**
	 * Call before render of context
	 */
	public function readSubmitedFields()
	{
		session_start();
		foreach ($_SESSION as $name => $value) {
			if (!isset($_POST[$name])) {
				$_POST[$name] = $value;
			}
		}
		session_write_close();

		$this->_hiddenFields = $_POST;
	}

	/**
	 * Call before redirect
	 */
	public function writeSubmitedFields()
	{
		session_start();
		$_SESSION = isset($_POST) ? $_POST : [];
		session_write_close();
	}

	/**
	 * Call on first installer page
	 */
	public function clearSubmitedFields()
	{
		session_start();
		session_unset();
		session_write_close();
	}

	/**
	 * @param string $error
	 */
	public function addError($error)
	{
		$this->_errors[] = $error;
	}

	/**
	 * @return boolean
	 */
	public function hasErrors()
	{
		return !empty($this->_errors);
	}

	/**
	 * Display errors
	 */
	public function errorSummary()
	{
		if (empty($this->_errors)) {
			return;
		}

		echo '<div class="alert alert-danger">';
		echo '<p>' . App::t('Correct the next errors') . ':</p>';
		echo '<ul>';
		foreach ($this->_errors as $error) {
			echo '<li>' . $error . '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}

	/**
	 * Add item to checktable
	 */
	public function addCheckItem($name, $item)
	{
		$this->_checkItems[$name] = $item;
	}

	/**
	 * @return null
	 */
	public function printCheckTable()
	{
?>
		<table class="table">
		<thead>
			<tr>
				<th><?= App::t('Value') ?></th>
				<th><?= App::t('Result') ?></th>
				<th><?= App::t('Comment') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($this->_checkItems as $name => $item): ?>
			<tr>
				<td><?= $item['value']; ?></td>
				<td>
<?php

					$resultClass = 'danger';
					$resultTitle = 'Ошибка';
					if (!empty($item['result'])) {
						$resultClass = 'success';
						$resultTitle = 'OK';
					}
?>
					<span class="label label-<?= $resultClass; ?>"><?= $resultTitle; ?></span>
				</td>
				<td><?= isset($item['comment']) ? $item['comment'] : ''; ?></td>
			</tr>
			<?php endforeach ?>

		</tbody>
		</table>
<?php

	}

	/**
	 * @param array $fields Array like ['key' => 'value']
	 */
	public function setHiddenFields($fields)
	{
		$this->_hiddenFields = $fields;
	}

	/**
	 * @param string $name
	 * @param string $value
	 */
	public function addHiddenField($name, $value)
	{
		$this->_hiddenFields[$name] = $value;
	}

	/**
	 * @param array $excludeHiddenFields Like ['key' => 'value', ...]
	 */
	public function printHiddenFields($excludeHiddenFields = null)
	{
		if (!empty($excludeHiddenFields)) {
			foreach ($this->_hiddenFields as $name => $value) {
				if (!in_array($name, $excludeHiddenFields)) {
					echo '<input type="hidden" name="' . $name . '" value="' . $value. '">';
				}
			}
		}
	}
}

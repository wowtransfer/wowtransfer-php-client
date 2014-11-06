<?php

class InstallerTemplate
{
	private $_errors = array();
	private $_checkItems = array();
	private $_hiddenFields = array();

	public function getFieldValue($name)
	{
		return isset($this->_hiddenFields[$name]) ? $this->_hiddenFields[$name] : '';
	}

	public function readSubmitedFields()
	{
		session_start();
		foreach ($_SESSION as $name => $value)
		{
			if (!isset($_POST[$name]))
				$_POST[$name] = $value;	
		}
		session_write_close();

		$this->_hiddenFields = $_POST;
	}

	public function writeSubmitedFields()
	{
		session_start();
		$_SESSION = isset($_POST) ? $_POST : array();
		session_write_close();
	}

	public function clearSubmitedFields()
	{
		session_start();
		session_unset();
		session_write_close();
	}

/*	public function getSubmitedFields()
	{
		return array(
		// core
			'core' => request_var('core', ''),
		// database
		
		// user
		
		// struct
		
		// procedures
		
		// privileges
		
		// finish
		
		);
	}*/

	/**
	 *
	 */
	public function addError($error)
	{
		$this->_errors[] = $error;
	}

	public function hasErrors()
	{
		return !empty($this->_errors);
	}

	public function errorSummary()
	{
		if (empty($this->_errors))
			return;

		echo '<p>Необходимо исправить следующие ошибки:</p>';
		echo '<div class="alert alert-danger">';
		echo '<ul>';
		foreach ($this->_errors as $error)
			echo '<li>' . $error . '</li>';
		echo '</ul>';
		echo '</div>';
	}

	/**
	 *
	 */
	public function addCheckItem($name, $item)
	{
		$this->_checkItems[$name] = $item;
	}

	public function printCheckTable()
	{
?>
		<table class="table">
		<thead>
			<tr>
				<th>Значение</th>
				<th>Результат</th>
				<th>Комментарий</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($this->_checkItems as $name => $item): ?>
			<tr>
				<td><?php echo $item['value']; ?></td>
				<td>
<?php
					$resultClass = 'warning';
					$resultTitle = 'Предупреждение';
					if (!empty($item['result']))
					{
						$resultClass = 'success';
						$resultTitle = 'OK';
					}
?>
					<span class="label label-<?php echo $resultClass; ?>"><?php echo $resultTitle; ?></span>
				</td>
				<td><?php echo isset($item['comment']) ? $item['comment'] : ''; ?></td>
			</tr>
			<?php endforeach; ?>
			
		</tbody>
		</table>
<?php
	}

	/**
	 *
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
		$_hiddenFields[$name] = $value;
	}

	public function printHiddenFields($excludeHiddenFields)
	{
		foreach ($this->_hiddenFields as $name => $value)
		{
			if (!in_array($name, $excludeHiddenFields))
				echo '<input type="hidden" name="' . $name . '" value="' . $value. '">';
		}
	}
}
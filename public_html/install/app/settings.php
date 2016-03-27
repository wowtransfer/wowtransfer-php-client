<?php

namespace Installer;


class Settings
{
    /**
     * [W]owtransfer [P]hp [C]lient installer
     */
    const SESSION_NAME = 'wpc_installer';

    /**
     * @var array
     */
    private $fields;

    public function __construct()
    {
        $this->read();
    }

    public function read()
    {
        $this->fields = isset($_SESSION[self::SESSION_NAME]) ? $_SESSION[self::SESSION_NAME] : [];
    }

    public function save()
    {
        if (!isset($_SESSION[self::SESSION_NAME])) {
            $_SESSION[self::SESSION_NAME] = [];
        }
        foreach ($_POST as $name => $value) {
            $_SESSION[self::SESSION_NAME][$name] = trim($value);
        }
        $this->fields = $_SESSION[self::SESSION_NAME];
    }

    /**
     * @param string $name
	 * @return string
	 */
	public function getFieldValue($name)
	{
		return isset($this->fields[$name]) ? trim($this->fields[$name]) : '';
	}

	/**
	 * Call on first installer page
	 */
	public function clear()
	{
		session_unset();
		session_write_close();
	}

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}
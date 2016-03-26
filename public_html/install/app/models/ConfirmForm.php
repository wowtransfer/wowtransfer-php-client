<?php

namespace Installer\Models;

use Installer\App;
use Installer\DatabaseManager;

class ConfirmForm
{
    /**
     * @var \Installer\View
     */
    protected $view; // TODO: remove

    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $nextActionName;

    /**
     * @var string
     */
    protected $nextActionDescription;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function run($action)
    {
        if (empty($action)) {
            return false;
        }
        $this->action = $action;

        try {
            $actionMethod = strtolower($action) . 'Action';
            if (!method_exists($this, $actionMethod)) {
                throw new \Exception('Action not found: ' . $action);
            }

            $this->$actionMethod();
        } catch (\Exception $ex) {
            $this->view->addError($ex->getMessage());
        }

        $this->send();
    }

    private function send()
    {
        $result = [];

        if ($this->view->hasErrors()) {
            $errors = $this->view->getErrors();
            $result['errorMessage'] = reset($errors);
            $result['errorPageUrl'] = '?page=' . $this->action;
        }
        $result['nextActionName'] = $this->nextActionName;
        $result['nextActionDescription'] = $this->nextActionDescription;
        if ($this->nextActionName === 'finish') {
            $result['finish'] = true;
            $result['finishUrl'] = '?page=finish';
        }

        echo json_encode($result);
        exit;
    }

    private function runInstallationAction()
    {
        $this->nextActionName = 'db';
        $this->nextActionDescription = 'Настройка базы';
    }

    private function dbAction()
    {
        $db = new DatabaseManager($this->view);
        $db->checkConnection();

        $this->nextActionName = 'user';
        $this->nextActionDescription = 'Настройка пользователя';
    }

    private function userAction()
    {
        $settings = App::$app->getSettings();
        $db = new DatabaseManager($this->view);
        $user = $settings->getFieldValue('db_user');
        $host = $settings->getFieldValue('db_host');
        $password = $settings->getFieldValue('db_password');
        $mode = $settings->getFieldValue('db_transfer_user_mode');
        if ($mode === 'create') {
            $db->createUser($user, $password, $host);
        }

        $this->nextActionName = 'struct';
        $this->nextActionDescription = 'Создание структуры';
    }

    private function structAction()
    {
        $db = new DatabaseManager($this->view);
        $db->createStructure();

        $this->nextActionName = 'privileges';
        $this->nextActionDescription = 'Настройка прав';
    }

    private function privilegesAction()
    {
        $db = new DatabaseManager($this->view);
        $db->applyPrivileges();

        $this->nextActionName = 'config';
        $this->nextActionDescription = 'Настройка конфигурации';
    }

    private function configAction()
    {
        App::$app->writeAppConfig();

        $this->nextActionName = 'finish';
        $this->nextActionDescription = 'Конец';
    }
}

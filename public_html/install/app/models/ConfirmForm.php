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
    protected $nextAction;

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
            sleep(1); // TODO: debug
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
        else {
            $result['success'] = true;
        }
        $result['nextAction'] = $this->nextAction;
        $result['finish'] = $this->nextAction === 'finish';

        echo json_encode($result);
        exit;
    }

    private function runInstallationAction()
    {
        $this->nextAction = 'db';
    }

    private function dbAction()
    {
        $db = new DatabaseManager($this->view);
        $db->checkConnection();

        $this->nextAction = 'user';
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

        $this->nextAction = 'struct';
    }

    private function structAction()
    {
        $db = new DatabaseManager($this->view);
        $db->createStructure();

        $this->nextAction = 'privileges';
    }

    private function privilegesAction()
    {
        $db = new DatabaseManager($this->view);
        $db->applyPrivileges();

        $this->nextAction = 'config';
    }

    private function configAction()
    {
        App::$app->writeAppConfig();

        $this->nextAction = 'finish';
    }
}

<?php

/**
 * This is the model class for table "chd_transfer".
 *
 * The followings are the available columns in table 'chd_transfer':
 * @property string $id
 * @property string $account_id
 * @property string $server
 * @property string $realmlist
 * @property string $realm
 * @property string $username_old
 * @property string $username_new
 * @property string $char_guid
 * @property string $create_char_date
 * @property string $create_transfer_date
 * @property integer $status
 * @property string $account
 * @property string $pass
 * @property integer $file_lua_crypt
 * @property string $file_lua
 * @property string $options
 * @property string $comment
 */
class ChdTransfer extends CActiveRecord
{
	// virtual attributes
	// TODO: rename `$options` to optionsStr?
	// TODO: rename `$transferOptions` to optionsArr?
	public $transferOptions = [];
	public $fileLua;
	public $pass2;

	const STATUS_PROCESS = 'process';
	const STATUS_CHECK   = 'check';
	const STATUS_CANCEL  = 'cancel';
	const STATUS_APPLY   = 'apply';
	const STATUS_GAME    = 'game';
	const STATUS_CART    = 'cart';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['transferTable'];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['account_id, char_guid, file_lua_crypt', 'numerical', 'integerOnly'=>true],
			['account_id', 'compare', 'allowEmpty'=>false, 'compareValue'=>0, 'operator'=>'>', 'strict'=>true],
			['server', 'length', 'max'=>100],
			['status', 'in', 'range' => array_keys(self::getStatuses())],

			['realmlist', 'match', 'pattern' => '/^[a-zA-Z0-9\-\.]+$/S'],
			['realm', 'match', 'pattern' => '/^[a-zA-Z0-9\-\. ]+$/S'],
			['account', 'match', 'pattern' => '/^[a-z0-9_\-]+$/S'],
			['comment', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],

			['account', 'length', 'max'=>32],
			['file_lua', 'length', 'allowEmpty'=>false],
			['realmlist, realm, pass', 'length', 'max'=>40],
			['username_old, username_new', 'length', 'max'=>12],
			['options, comment', 'length', 'max'=>255],
			['create_char_date, pass2', 'safe'],

			['server, realmlist, realm, account, pass, username_old, transferOptions', 'required'],
			['transferOptions', 'type', 'type' => 'array', 'allowEmpty' => false],

			['pass2', 'required', 'on' => 'create, update'],
			['fileLua', 'file', 'types' => 'lua', 'allowEmpty' => true, 'maxFiles' => 1, 'maxSize' => 1024 * 600, 'on' => 'create'],
			['pass', 'compare', 'compareAttribute' => 'pass2', 'operator' => '=', 'on'=>'create, update'],

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, account_id, server, realmlist, realm, username_old, username_new, char_guid, create_char_date, create_transfer_date, status, account, pass, file_lua_crypt, file_lua, options, comment', 'safe', 'on'=>'search'],
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'account_id' => Yii::t('app', 'Account ID'),
			'server' => Yii::t('app', 'Site'),
			'realmlist' => Yii::t('app', 'Realmlist'),
			'realm' => Yii::t('app', 'Realm'),
			'account' => Yii::t('app', 'Account'),
			'pass' => Yii::t('app', 'Password'),
			'pass2' => Yii::t('app', 'Password confirmation'),
			'username_old' => Yii::t('app', 'Player name'),
			'username_new' => Yii::t('app', 'Player name'),
			'char_guid' => Yii::t('app', 'Player GUID'),
			'create_char_date' => Yii::t('app', 'Player creating date'), //'Дата создания персонажа',
			'create_transfer_date' => Yii::t('app', 'Request creating date'),
			'status' => Yii::t('app', 'Status'),
			'file_lua_crypt' => Yii::t('app', 'Encrypt of dump'),
			'file_lua' => Yii::t('app', 'Lua dump content'),
			'options' => Yii::t('app', 'Transfer options'),
			'comment' => Yii::t('app', 'Comment'),
			// virtual
			'transferOptions' => Yii::t('app', 'Transfer options'),
			'fileLua' => Yii::t('app', 'Lua dump'),
		];
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('account_id',$this->account_id,true);
		$criteria->compare('server',$this->server,true);
		$criteria->compare('realmlist',$this->realmlist,true);
		$criteria->compare('realm',$this->realm,true);
		$criteria->compare('username_old',$this->username_old,true);
		$criteria->compare('username_new',$this->username_new,true);
		$criteria->compare('char_guid',$this->char_guid,true);
		$criteria->compare('create_char_date',$this->create_char_date,true);
		$criteria->compare('create_transfer_date',$this->create_transfer_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('file_lua_crypt',$this->file_lua_crypt);
		$criteria->compare('file_lua',$this->file_lua,true);
		$criteria->compare('options',$this->options,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}

	/**
	 * @return array
	 */
	public static function getStatuses()
	{
		$statuses = [
			self::STATUS_PROCESS => Yii::t('app', 'In process'),
			self::STATUS_CHECK => Yii::t('app', 'Checking'),
			self::STATUS_CANCEL => Yii::t('app', 'Canceled'),
			self::STATUS_APPLY => Yii::t('app', 'Accepted'),
			self::STATUS_GAME => Yii::t('app', 'In game'),
			self::STATUS_CART => Yii::t('app', 'In basket'),
		];

		return $statuses;
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public static function getStatusTitle($name) {
		$statuses = self::getStatuses();
		if (isset($statuses[$name])) {
			return $statuses[$name];
		}
		return 'undefined';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ChdTransfer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeValidate()
	{
		if (!parent::beforeValidate()) {
			return false;
		}
		if (!Yii::app()->request->isAjaxRequest) {
			if (!($this->fileLua instanceof CUploadedFile) && $this->scenario !== 'update') {
				$this->addError('fileLua', Yii::t('yii', '{attribute} cannot be blank.', [
					'{attribute}' => $this->getAttributeLabel('fileLua')
				]));
			}
		}
		if (Yii::app()->params['onlyCheckedServers']) {
			$service = new WowtransferUI();
			if (!in_array($this->server, $service->getWowServersSites())) {
				$this->addError('server', Yii::t('app', 'Select the site from list'));
				return false;
			}
		}

		if ($this->isNewRecord) {
			$this->account_id = Yii::app()->user->id;
			$this->status = self::STATUS_PROCESS;

			/* TODO: add limit parameter to application's configuration
			if (isLimit)
			{
				$this->addError('Transfer count was limited by ___');
				return false;
			}
			*/

			/* TODO: add hash field for fileLua
			if (checkDuplicate)
			{
				$this->addError('Transfer was alredy loaded');
				return false;
			}
			*/

			//$this->create_transfer_date = date('Y-m-d h:i:s'); // fills by MySQL
			if (is_object($this->fileLua) && $this->fileLua instanceof CUploadedFile)
				$this->file_lua = $this->luaDumpToDb(file_get_contents($this->fileLua->tempName));
			// check *.lua files by hash
			// ...
		}

		if (is_array($this->transferOptions)) {
			$this->options = implode(';', $this->transferOptions);
		}

		return true;
	}

	/**
	 * Compress lua dump content
	 *
	 * @return string Compressed string
	 */
	public function luaDumpToDb($luaDumpContent)
	{
		return gzcompress($luaDumpContent);
	}

	/**
	 * Decompress lua dump content
	 *
	 * @return string Lua-dump content
	 */
	public function luaDumpFromDb()
	{
		return gzuncompress($this->file_lua);
	}

	/**
	 * @return array Key - option's name, Value - option's title
	 */
	public function getTransferOptionsToUser()
	{
		$trasnferOptions = [];
		$options = \ToptionsConfigForm::getTransferOptions();

		foreach ($options as $name => $option) {
			$trasnferOptions[$name] = $option['label'];
		}

		return $trasnferOptions;
	}

	public function getTransferOptionsFromDb()
	{
		if (empty($this->options)) {
			return [];
		}

		return explode(';', $this->options);
	}

	/**
	 * @return boolean
	 */
	public function deleteChar()
	{
		if (!$this->char_guid) {
			throw new CHttpException(404, Yii::t('app', 'Character has not created'));
		}

		$connection = Yii::app()->db;
		$command = $connection->createCommand('CALL chd_char_del(:id, :table_name)');
		$command->bindValue(':id', $this->id);
		$command->bindValue(':table_name', $this->tableName());
		$command->execute();

		$command = $connection->createCommand('SELECT @CHD_RES');
		$result = $command->queryScalar() > 0;

		return $result;
	}

	public function delete()
	{
		if ($this->char_guid > 0) {
			$this->addError('error', Yii::t('app', 'Try to delete the request failed, then a character has created.'));
			return false;
		}

		return parent::delete();
	}
}

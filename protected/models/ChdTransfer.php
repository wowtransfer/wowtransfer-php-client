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
	public $transferOptions = array();
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
		return array(
			array('account_id, char_guid, file_lua_crypt', 'numerical', 'integerOnly'=>true),
			//array('account_id, char_guid', 'length', 'max'=>10),
			array('account_id', 'compare', 'allowEmpty'=>false, 'compareValue'=>0, 'operator'=>'>', 'strict'=>true),
			array('server', 'length', 'max'=>100),
			array('status', 'in', 'range' => array_keys(self::getStatuses())),

			array('server', 'match', 'pattern' => '/^[a-zA-Z0-9\-\.]+$/S'),
			['realmlist', 'match', 'pattern' => '/^[a-zA-Z0-9\-\.]+$/S'],
			['realm', 'match', 'pattern' => '/^[a-zA-Z0-9\-\. ]+$/S'],
			array('account', 'match', 'pattern' => '/^[a-z0-9_\-]+$/S'),
			array('comment', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),

			array('account', 'length', 'max'=>32),
			array('file_lua', 'length', 'allowEmpty'=>false),
			array('realmlist, realm, pass', 'length', 'max'=>40),
			array('username_old, username_new', 'length', 'max'=>12),
			array('options, comment', 'length', 'max'=>255),
			array('create_char_date, pass2', 'safe'),

			array('server, realmlist, realm, account, pass, username_old, transferOptions', 'required'),
			array('transferOptions', 'type', 'type' => 'array', 'allowEmpty' => false),

			array('pass2', 'required', 'on' => 'create, update'),
			array('fileLua', 'file', 'types' => 'lua', 'allowEmpty' => true, 'maxFiles' => 1, 'maxSize' => 1024 * 600, 'on' => 'create'),
			array('pass', 'compare', 'compareAttribute' => 'pass2', 'operator' => '=', 'on'=>'create, update'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, server, realmlist, realm, username_old, username_new, char_guid, create_char_date, create_transfer_date, status, account, pass, file_lua_crypt, file_lua, options, comment', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_id' => Yii::t('app', 'Account ID'),
			'server' => Yii::t('app', 'Name'),
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
		);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @var array
	 */
	protected static $statuses = array(
		self::STATUS_PROCESS => 'В процессе',
		self::STATUS_CHECK => 'Проверяется',
		self::STATUS_CANCEL => 'Отклонено',
		self::STATUS_APPLY => 'Принято',
		self::STATUS_GAME => 'Игра',
		self::STATUS_CART => 'В корзине',
	);

	/**
	 * @return array
	 */
	public static function getStatuses()
	{
		return self::$statuses;
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public static function getStatusTitle($name) {
		if (isset(self::$statuses[$name])) {
			return self::$statuses[$name];
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
			if (!($this->fileLua instanceof CUploadedFile)) {
				$this->addError('fileLua', Yii::t('yii', '{attribute} cannot be blank.', [
					'{attribute}' => $this->getAttributeLabel('fileLua')
				]));
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
		$trasnferOptions = array();
		$options = \ToptionsConfigForm::getTransferOptions();

		foreach ($options as $name => $option) {
			$trasnferOptions[$name] = $option['label'];
		}

		return $trasnferOptions;
	}

	public function getTransferOptionsFromDb()
	{
		if (empty($this->options)) {
			return array();
		}

		return explode(';', $this->options);
	}

	/**
	 * @return boolean
	 */
	public function deleteChar()
	{
		if (!$this->char_guid)
			throw new CHttpException(404, 'Character not created');

		$connection = Yii::app()->db;

		$command = $connection->createCommand('CALL chd_char_del(:id, :table_name)');
		$command->bindValue(':id', $this->id);
		$command->bindValue(':table_name', $this->tableName());
		$command->execute();

		$command = $connection->createCommand('SELECT @CHD_RES');
		$result = $command->queryScalar() > 0;

		if ($result)
			Yii::app()->user->setFlash('success', 'Character GUID = ' . $this->char_guid . ' was deleted success');

		return $result;
	}

	public function delete()
	{
		if ($this->char_guid > 0)
		{
			$this->addError('error', 'Невозможно удалить заявку, когда по ней создан персонаж.');
			return false;
		}

		return parent::delete();
	}
}

<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\models\BaseModel;
use yii\web\IdentityInterface;
use common\ebl\Constants as C;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $mobile_no
 * @property string $email
 * @property string $name
 * @property string $code
 * @property string $user_type
 * @property string $reference_id
 * @property string $designation_id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends BaseModel implements IdentityInterface {

    public static $loggedInUser;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    public function scenarios() {
        return[
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'user_type', 'reference_id', 'username', 'password', 'auth_key', 'password_hash', 'password_reset_token', 'status', 'last_access_time', 'added_on', 'updated_on', 'added_by', 'updated_by', 'verification_token', 'mobile_no', 'designation_id', 'email'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'user_type', 'reference_id', 'username', 'password', 'auth_key', 'password_hash', 'password_reset_token', 'status', 'last_access_time', 'added_on', 'updated_on', 'added_by', 'updated_by', 'verification_token', 'mobile_no', 'designation_id', 'email'],
            self::SCENARIO_UPDATE => ['id', 'name', 'user_type', 'reference_id', 'username', 'password', 'auth_key', 'password_hash', 'password_reset_token', 'status', 'last_access_time', 'added_on', 'updated_on', 'added_by', 'updated_by', 'verification_token', 'mobile_no', 'designation_id', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'user_type', 'username', 'password'], 'required'],
            [['user_type', 'reference_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['last_access_time', 'added_on', 'updated_on', 'mobile_no', 'designation_id', 'auth_key', 'password_hash'], 'safe'],
            [['name', 'username', 'password', 'password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = [
            'id',
            'name',
            'user_type',
            'reference_id',
            'username',
            'password',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'status',
            'last_access_time',
            'added_on',
            'updated_on',
            'added_by',
            'updated_by',
            'verification_token',
            'mobile_no',
            'designation_id'
        ];

        return array_merge(parent::fields(), $fields);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_type' => 'User Type',
            'reference_id' => 'Reference',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'last_access_time' => 'Last Access Time',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
            'verification_token' => 'Verification Token',
            'mobile_no' => "Mobile No",
            'designation_id' => "Designation"
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => \common\ebl\Constants::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => \common\ebl\Constants::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => \common\ebl\Constants::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token,
                    'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function getDesignation() {
        return $this->hasOne(Designation::class, ['id' => 'designation_id']);
    }

    public static function getMso() {
        $mso = Operator::findOne(['type' => C::OPERATOR_TYPE_MSO]);
        if ($mso instanceof Operator) {
            return $mso->id;
        }
        return NULL;
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function afterValidate() {
        if (in_array($this->scenario, [self::SCENARIO_CREATE, self::SCENARIO_UPDATE])) {
            $this->auth_key = !empty($this->auth_key) ? $this->auth_key : Yii::$app->security->generateRandomString();
            $this->password_hash = !empty($this->password_hash) ? $this->password_hash : Yii::$app->getSecurity()->generatePasswordHash($this->username . $this->password);
        }

        return parent::afterValidate();
    }

    public function afterSave($insert, $changedAttributes) {

        if ($insert) {
            $desig = Designation::find()->andWhere(['id' => [$this->designation_id]])->indexBy('id')->one();
            if ($desig instanceof Designation) {
                echo "insise designation.........";
                \common\ebl\AuthUser::assignDesignation($this->id, $desig->name);
            }
        }

        if (in_array("designation_id", array_keys($changedAttributes))) {
            if (!empty($changedAttributes['designation_id'])) {
                $desig = Designation::find()
                                ->andWhere(['id' => [$this->designation_id, $changedAttributes['designation_id']]])
                                ->indexBy('id')->all();

                if (!empty($desig)) {
                    $current = $desig[$this->designation_id];
                    $prev = $desig[$changedAttributes['designation_id']];
                    \common\ebl\AuthUser::assignDesignation($this->id, $current->name, $prev->name);
                }
            }
        }
    }

    public static function currentUser() {
        if (!Yii::$app->user->isGuest) {
            if (!empty(Yii::$app->user)) {
                self::$loggedInUser =(array) Yii::$app->user;
                return self::$loggedInUser;
            } else if (Yii::$app->user == 'ims-console') {
                return C::CONSOLE_ID;
            }
        }
    }

    public static function loggedInUserId() {
        $d = self::currentUser();
        return !empty($d['id']) ? $d['id'] : "";
    }

    public static function loggedInUserName() {
        $d = self::currentUser();
        return !empty($d['name']) ? $d['name'] : "";
    }

    public static function loggedInUserLoginId() {
        $d = self::currentUser();
        return !empty($d['username']) ? $d['username'] : "";
    }

    public static function loggedInUserType() {
        $d = \Yii::$app->user->getIdentity();
        return !empty($d['user_type']) ? $d['user_type'] : "";
    }

    public static function loggedInUserReferenceId() {
        $d = \Yii::$app->user->getIdentity();
        return !empty($d['reference_id']) ? $d['reference_id'] : "";
    }

    /**
     * @inheritdoc
     * @return LocationQuery the active query used by this AR class.
     */
    public static function find() {
        return new UserQuery(get_called_class());
    }

    public function getOperator() {
        return $this->hasOne(Operator::class, ['id' => 'reference_id']);
    }

    public function getAssignOperator() {
        return $this->hasMany(UserAssignment::class, ['user_id' => 'id'])->andWhere(['type' => C::ASSIGNMENT_TYPE_OPERATOR]);
    }

    public function getAssignedList() {
        $ids = !empty($this->assignOperator) ? \yii\helpers\ArrayHelper::getColumn($this->assignOperator, "assigned_id") : [$this->reference_id];
        if (!empty($ids)) {
            $opt = Operator::find()->where(['OR', ["id" => $ids], ['distributor_id' => $ids], ['ro_id' => $ids], ['mso_id' => $ids]])->active()->indexBy('id')->asArray()->all();
            if (!empty($opt)) {
                return array_keys($opt);
            }
        }
        return [$this->reference_id];
    }

}

<?php

namespace common\forms;

use common\models\Operator;
use common\models\Location;
use common\models\User;
use common\ebl\Constants as C;
use common\models\UploadDocuments;

class OperatorForm extends \yii\base\Model {

    public $id;
    public $name, $contact_person, $mobile_no, $telephone_no, $email, $status, $ro_id;
    public $address, $type, $distributor_id, $city_id, $gst_no, $pan_no, $tan_no, $billing_by;
    public $username, $company_logo, $password;
    public $billied_by, $is_online, $code, $designation_id;

    public function scenarios() {
        return [
            Operator::SCENARIO_CREATE => ['id', "name", "contact_person", "mobile_no", "telephone_no", "email", "address", "type", "distributor_id", "city_id", "gst_no", "pan_no", "tan_no", "billing_by", "username", "company_logo", "status", "password", "is_online", "billied_by", "code", "designation_id", "ro_id"],
            Operator::SCENARIO_CONSOLE => ['id', "name", "contact_person", "mobile_no", "telephone_no", "email", "address", "type", "distributor_id", "city_id", "gst_no", "pan_no", "tan_no", "billing_by", "username", "company_logo", "status", "is_online", "billied_by", "code", "designation_id", "ro_id"],
            Operator::SCENARIO_UPDATE => ['id', "name", "contact_person", "mobile_no", "telephone_no", "email", "address", "type", "distributor_id", "city_id", "gst_no", "pan_no", "tan_no", "billing_by", "company_logo", "status", "is_online", "billied_by", "code", "designation_id", "ro_id"],
        ];
    }

    public function rules() {
        return [
            [['name', 'contact_person', 'mobile_no', 'address', 'type', 'billing_by', "designation_id"], 'required'],
            [['username'], 'required', 'on' => Operator::SCENARIO_CREATE],
            [['type', 'distributor_id', 'status', 'city_id', 'billing_by', "is_online", "ro_id"], 'integer'],
            [['name', 'contact_person', 'mobile_no', 'telephone_no', 'email', 'address', 'gst_no', 'pan_no', 'tan_no', 'username', 'password'], 'string', 'max' => 255],
            [['username'], 'unique', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['username' => 'username'],],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::class, 'targetAttribute' => ['city_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::class, 'targetAttribute' => ['state_id' => 'id']],
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => ['username' => 'username']],
            [['company_logo'], 'file', 'extensions' => 'jpg, gif, png'],
            [["code"], 'safe'],
            [['ro_id'], "required", "when" => function () {
                    return $this->type > C::OPERATOR_TYPE_RO;
                }],
            [['distributor_id'], "required", "when" => function () {
                    return $this->type > C::OPERATOR_TYPE_DISTRIBUTOR;
                }],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'contact_person' => 'Contact Person',
            'mobile_no' => 'Mobile No',
            'telephone_no' => 'Telephone No',
            'email' => 'Email',
            'address' => 'Address',
            'type' => 'Type',
            'mso_id' => 'MSO',
            'distributor_id' => 'Distributor',
            'ro_id' => 'RO',
            'status' => 'Status',
            'state_id' => 'State',
            'city_id' => 'City',
            'gst_no' => 'Gst No',
            'pan_no' => 'Pan No',
            'tan_no' => 'Tan No',
            'billing_by' => 'Billing By',
            'username' => 'Username',
            'meta_data' => 'Meta Data',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
            'is_verified' => 'Is Verfied'
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            if ($this->id) {
                return $this->update();
            } else {
                return $this->create();
            }
        }
        return false;
    }

    public function create() {
        $model = new Operator(['scenario' => Operator::SCENARIO_CREATE]);
        $model->load($this->attributes, '');
        if ($model->validate() && $model->save()) {
            $this->id = $model->id;
            $this->saveLogo();
            $this->createLogin();
            return TRUE;
        } else {
            $this->addErrors($model->errors);
        }
        return false;
    }

    public function update() {
        $model = Operator::findOne($this->id);
        if ($model instanceof Operator) {
            $model->load($this->attributes, '');
            if ($model->validate() && $model->save()) {
                $this->id = $model->id;
                $this->saveLogo();
                $this->updateLogins();
                return TRUE;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return false;
    }

    private function updateLogins() {
        $user = User::findOne(['username' => $this->username]);
        if ($user instanceof User) {
            $user->scenario = User::SCENARIO_UPDATE;
            $user->name = $this->name;
            $user->mobile_no = $this->mobile_no;
            $user->email = $this->email;
            $user->designation_id = $this->designation_id;
            if ($user->validate()) {
                $user->save();
            }
        }
    }

    private function createLogin() {
        $user = new User(['scenario' => User::SCENARIO_CREATE]);
        $user->username = $this->username;
        $user->name = $this->name;
        $user->mobile_no = $this->mobile_no;
        $user->email = $this->email;
        $user->designation_id = C::DESIG_OPERATOR;
        $user->user_type = ($this->type == C::OPERATOR_TYPE_DISTRIBUTOR) ? C::USERTYPE_DISTRIBUTOR :
                ($this->type == C::OPERATOR_TYPE_RO ? C::USERTYPE_RO : C::USERTYPE_OPERATOR);
        $user->reference_id = $this->id;
        $user->password = md5($this->password);
        $user->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->status = $this->status;
        $user->designation_id = $this->designation_id;
        if ($user->validate() && $user->save()) {
            return $user;
        } else {
            $this->addErrors($user->errors);
        }
    }

    public function saveLogo() {
        // if (!empty($this->company_logo)) {
        $file = \yii\web\UploadedFile::getInstance($this, 'company_logo');
        if (!empty($file)) {
            $hasedFile = file_get_contents($file->tempName);
            $logo = !empty($hasedFile) ? base64_encode($hasedFile) : null;
            $companyLogo = ['name' => $file->name, 'ext' => $file->extension, 'content' => $logo];

            $ud = UploadDocuments::findOne([
                        'model_id' => $this->id,
                        'model_name' => Operator::className(),
                        'type' => UploadDocuments::OPT_LOGO
            ]);
            if (!$ud instanceof UploadDocuments) {
                $ud = new UploadDocuments(['scenario' => UploadDocuments::SCENARIO_CREATE]);
            } else {
                $ud->scenario = UploadDocuments::SCENARIO_UPDATE;
            }
            $ud->name = $companyLogo['name'];
            $ud->type = UploadDocuments::OPT_LOGO;
            $ud->model_name = Operator::tableName();
            $ud->model_id = $this->id;
            $ud->document = $companyLogo;
            $ud->status = C::STATUS_ACTIVE;
            if ($ud->validate()) {
                $ud->save();
            }
        }
    }

}

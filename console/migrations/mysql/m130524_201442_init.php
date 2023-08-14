<?php

class m130524_201442_init extends common\ebl\migration\Migration {

    public function up() {

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'mobile_no' => $this->string(),
            'email' => $this->string(),
            'user_type' => $this->smallInteger()->notNull(),
            'reference_id' => $this->integer(),
            'designation_id' => $this->integer(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'verification_token' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(\common\ebl\Constants::STATUS_ACTIVE),
            'last_access_time' => $this->dateTime()->null(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $query = "insert into user(id,name,mobile_no,user_type,email,reference_id,designation_id,username,password,status,auth_key,password_hash)";
        $query .= "values(" . common\ebl\Constants::CONSOLE_ID . ",'console','8923893289'," . common\ebl\Constants::USERTYPE_CONSOLE . ",'console@cabeltree.com',0," . common\ebl\Constants::DESIGNATION_SADMIN . ",'console',md5('console'),1,'". Yii::$app->security->generateRandomString()."','".Yii::$app->getSecurity()->generatePasswordHash("console")."')";
        Yii::$app->db->createCommand($query)->execute();

        Yii::$app->runAction('migrate', ['--migrationPath' => '@yii/rbac/migrations/']);
    }

    public function down() {
        $this->dropTable('user');
    }

}

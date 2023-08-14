<?php

namespace common\forms;

use common\models\UserAssignment;
use common\ebl\Constants as C;

class AssignmentForm extends \yii\base\Model {

    public $user_id;
    public $assign_ids;
    public $type;
    public $msg;

    public function rules() {
        return [
            [['user_id', 'assign_ids', 'type'], 'required'],
            [['user_id', 'type'], 'integer'],
            ['assign_ids', 'each', 'rule' => ['integer']]
        ];
    }

    public function attributeLabels() {
        return [
            "user_id" => "User",
            "assign_ids" => "Assign ",
            "type" => "Type",
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $del_id = [];
            $cnt = 0;
            
            $total = count($this->assign_ids);
            foreach ($this->assign_ids as $id) {
                $model = UserAssignment::findOne(['assigned_id' => $id, 'type' => $this->type, 'user_id' => $this->user_id]);
                if (!$model instanceof UserAssignment) {
                    $model = new UserAssignment();
                    $model->user_id = $this->user_id;
                    $model->type = $this->type;
                    $model->assigned_id = $id;
                    if ($model->validate() && $model->save()) {
                        $del_id[] = $model->id;
                        $cnt++;
                    }
                } else {
                    $cnt++;
                    $del_id[] = $model->id;
                }
            }

            if (!empty($del_id)) {
                $query = new \yii\db\Query();
                $query->andWhere(['type' => $this->type, 'user_id' => $this->user_id]);
                $query->andWhere(['not in', 'id', $del_id]);
                UserAssignment::deleteAll($query->where);
            }
            $this->msg = "Total {$cnt}/{$total} assigned successfully.";
            return true;
        }
        return false;
    }

}

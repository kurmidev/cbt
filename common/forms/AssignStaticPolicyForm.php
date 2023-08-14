<?php

namespace common\forms;

use common\models\StaticipPolicy;
use common\models\OperatorStaticipAssoc;
use common\models\Operator;

class AssignStaticPolicyForm extends \yii\base\Model {

    public $rate_ids;
    public $operator_ids;
    public $type;

    public function scenarios() {
        return [
            "assign-policy" => ["rate_ids", "operator_ids"]
        ];
    }

    public function rules() {
        return [
            [["rate_ids", "operator_ids"], 'required'],
            [["rate_ids", "operator_ids"], 'each', 'rule' => ['integer']]
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $assoc_ids = !empty($this->rate_ids) ? array_keys($this->rate_ids) : [];
            $rates_ids = !empty($this->rate_ids) ? array_values($this->rate_ids) : [];

            $operators = Operator::find()->where(['id' => $this->operator_ids])->select(['id', 'mso_id', 'distributor_id'])
                            ->indexBy('id')->asArray()->all();
            if (!empty($operators)) {
                $operator_ids = ArrayHelper::merge(
                                array_keys($operators), array_unique(ArrayHelper::getColumn($operators, 'distributor_id')), array_unique(ArrayHelper::getColumn($operators, 'mso_id'))
                );

                $operatorAssoc = OperatorAssoc::find()
                        ->where(['assoc_id' => $assoc_ids, 'type' => $this->type, 'operator_id' => $operator_ids])
                        ->all();
                if (!empty($operatorAssoc)) {
                    $operatorAssoc = ArrayHelper::index($operatorAssoc, 'assoc_id', 'operator_id');
                }
                $model = null;
                foreach ($operator_ids as $operator_id) {
                    $delids = [];
                    foreach ($this->rate_ids as $assoc_id => $rate_id) {
                        if (empty($operatorAssoc[$operator_id][$assoc_id])) {
                            $model = new OperatorAssoc(['scenario' => OperatorAssoc::SCENARIO_CREATE]);
                            $model->operator_id = $operator_id;
                            $model->type = C::RATE_TYPE_BOUQUET;
                            $model->assoc_id = $assoc_id;
                            if ($model->validate() && $model->save()) {
                                $delids[] = $model->id;
                                $this->assignRates($model, $rate_id);
                            }
                        } else if (!empty($operatorAssoc[$operator_id][$assoc_id])) {
                            $d = $operatorAssoc[$operator_id][$assoc_id];
                            $delids[] = $d->id;
                            $this->assignRates($d, $rate_id);
                        }
                    }

                    $query = new \yii\db\Query();
                    $query->andWhere(['not', ['id' => $delids]]);
                    $query->andWhere(['operator_id' => $operator_id, 'type' => C::RATE_TYPE_BOUQUET]);
                    OperatorAssoc::deleteAll($query->where);
                }
            }
            return TRUE;
        }
        return false;
    }

    public function assignRates(OperatorAssoc $assoc, $rate_id) {
        $pr = RateMaster::findOne(['id' => $rate_id, 'type' => C::RATE_TYPE_BOUQUET, 'assoc_id' => $assoc->assoc_id]);
        if (($assoc instanceof OperatorAssoc) && ($pr instanceof RateMaster)) {
            $model = OperatorRates::findOne(['operator_id' => $assoc->operator_id, 'assoc_id' => $assoc->assoc_id, 'type' => C::RATE_TYPE_BOUQUET, 'rate_id' => $rate_id]);
            if ($model instanceof OperatorRates) {
                $model->scenario = OperatorRates::SCENARIO_UPDATE;
            } else {
                $model = new OperatorRates(['scenario' => OperatorRates::SCENARIO_CREATE]);
                $model->operator_id = $assoc->operator_id;
                $model->assoc_id = $assoc->assoc_id;
                $model->type = C::RATE_TYPE_BOUQUET;
                $model->rate_id = $rate_id;
            }

            $model->amount = $pr->amount;
            $model->tax = $pr->tax;
            $model->mrp = $pr->mrp;
            $model->mrp_tax = $pr->mrp_tax;
            if ($model->validate()) {
                $model->save();
            }
        }
    }

}

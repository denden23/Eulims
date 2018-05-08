<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Request;

/**
 * RequestSearch represents the model behind the search form about `common\models\lab\Request`.
 */
class RequestSearch extends Request
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'request_datetime', 'rstl_id', 'lab_id', 'customer_id', 'payment_type_id', 'modeofrelease_id', 'discount_id', 'purpose_id', 'or_id', 'created_at', 'posted', 'status_id'], 'integer'],
            [['request_ref_num', 'report_due', 'conforme', 'receivedBy'], 'safe'],
            [['discount', 'total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Request::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'request_id' => $this->request_id,
            'request_datetime' => $this->request_datetime,
            'rstl_id' => $this->rstl_id,
            'lab_id' => $this->lab_id,
            'customer_id' => $this->customer_id,
            'payment_type_id' => $this->payment_type_id,
            'modeofrelease_id' => $this->modeofrelease_id,
            'discount' => $this->discount,
            'discount_id' => $this->discount_id,
            'purpose_id' => $this->purpose_id,
            'or_id' => $this->or_id,
            'total' => $this->total,
            'report_due' => $this->report_due,
            'created_at' => $this->created_at,
            'posted' => $this->posted,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'request_ref_num', $this->request_ref_num])
            ->andFilterWhere(['like', 'conforme', $this->conforme])
            ->andFilterWhere(['like', 'receivedBy', $this->receivedBy]);

        return $dataProvider;
    }
}
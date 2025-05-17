<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User; // Assuming your User model is named User

class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'], // Integer fields
            [['username', 'status', 'email', 'otp', 'usertype', 'fee_paid'], 'safe'], // String-based fields
            [['email_verified', 'created_at', 'updated_at'], 'safe'], // Date-based fields
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // Bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param array|null $userIds Optional array of user IDs to filter
     *
     * @return ActiveDataProvider
     */
    public function search($params, $userIds = null)
    {
        // Create a query for the User model
        $query = User::find();

        // Apply user ID filter if provided
        if ($userIds !== null) {
            $query->andWhere(['id' => $userIds]);
        }

        // Set up the data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100, // Set the number of records per page
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC], // Default sorting by ID descending
            ],
        ]);

        // Load parameters and validate
        $this->load($params);

        if (!$this->validate()) {
            // If validation fails, return no results
            $query->where('0=1');
            return $dataProvider;
        }

        // Default sorting
        $query->orderBy(['id' => SORT_DESC]);

        // Grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'usertype' => $this->usertype, // Exact match for usertype
            'email_verified' => $this->email_verified, // Exact match for boolean/date
        ]);

        // Partial match filters with LIKE
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'otp', $this->otp])
            ->andFilterWhere(['like', 'fee_paid', $this->fee_paid]);

        // Date range filters (optional: adjust as needed)
        $query->andFilterWhere(['>=', 'created_at', $this->created_at])
            ->andFilterWhere(['>=', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}

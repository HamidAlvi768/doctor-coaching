<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quiz;
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class QuizSearch extends Quiz
{
    // Add virtual attributes
    public $sessionName;
    public $isAttempted; // New attribute to filter by attempted status

    public function rules()
    {
        return [
            [['id', 'session_id'], 'integer'],
            [['title', 'description', 'start_at', 'end_at', 'created_at', 'updated_at', 'sessionName', 'isAttempted'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Quiz::find()->with(['session']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        // Add a custom attribute to dataProvider for 'isAttempted'
        $dataProvider->setSort([
            'attributes' => array_merge($dataProvider->sort->attributes, [
                'isAttempted' => [
                    'asc' => ['(SELECT COUNT(*) FROM student_response WHERE student_response.quiz_id = quiz.id)' => SORT_ASC],
                    'desc' => ['(SELECT COUNT(*) FROM student_response WHERE student_response.quiz_id = quiz.id)' => SORT_DESC],
                    'default' => SORT_DESC,
                ],
            ]),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Join with the session table
        $query->joinWith('session');

        // Grid filtering conditions
        $query->andFilterWhere([
            'quiz.id' => $this->id,
            'quiz.session_id' => $this->session_id,
            'quiz.start_at' => $this->start_at,
            'quiz.end_at' => $this->end_at,
            'quiz.created_at' => $this->created_at,
            'quiz.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'quiz.title', $this->title])
              ->andFilterWhere(['like', 'quiz.description', $this->description])
              ->andFilterWhere(['like', 'session.name', $this->sessionName]);

        // Filter by isAttempted (if provided)
        if ($this->isAttempted !== null) {
            $subQuery = StudentResponse::find()
                ->select('quiz_id')
                ->groupBy('quiz_id');
            if ($this->isAttempted === '1') {
                $query->andWhere(['quiz.id' => $subQuery]); // Quizzes with responses
            } elseif ($this->isAttempted === '0') {
                $query->andWhere(['not in', 'quiz.id', $subQuery]); // Quizzes without responses
            }
        }

        return $dataProvider;
    }

    // Helper method to check if a quiz is attempted
    public static function isQuizAttempted($quizId)
    {
        return StudentResponse::find()
            ->where(['quiz_id' => $quizId])
            ->exists();
    }
}
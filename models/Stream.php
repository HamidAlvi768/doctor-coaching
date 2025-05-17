<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stream".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $stream_url
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $active
 * @property string $meeting_id
 * @property string $meeting_passcode
 * @property string $stream_type
 */
class Stream extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stream';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'stream_url', 'stream_type'], 'required'],
            [['description', 'stream_url'], 'string'],
            [['start_time', 'end_time'], 'safe'],
            [['active'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['meeting_id', 'meeting_passcode'], 'string', 'max' => 50],
            [['stream_type'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'stream_url' => 'Stream Url',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'active' => 'Active',
            'meeting_id' => 'Meeting ID',
            'meeting_passcode' => 'Meeting Passcode',
            'stream_type' => 'Stream Type',
        ];
    }
}

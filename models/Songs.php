<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Songs".
 *
 * @property int $id
 * @property string $name
 * @property string $artist
 * @property string|null $genre
 * @property int|null $year
 * @property string $created_at
 * @property string $updated_at
 * @property resource|null $image
 */
class Songs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Songs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'artist'], 'required'],
            [['year'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'file', 'extensions' => 'jpg, png, jpeg', 'mimeTypes' => 'image/jpeg, image/png'],
            [['name', 'artist', 'genre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'artist' => 'Artist',
            'genre' => 'Genre',
            'year' => 'Year',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'image' => 'Image',
        ];
    }
}

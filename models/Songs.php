<?php

namespace app\models;

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
            [['image'], 'file', 'extensions' => 'jpg, jpeg, png', 'mimeTypes' => 'image/jpeg, image/png'], // добавляем правила для загрузки изображений
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

    // Этот метод сохраняет изображение в базу данных
    public function uploadImage()
    {
        if ($this->image && $this->validate()) {
            // Сохраняем изображение в виде бинарных данных
            $this->image = file_get_contents($this->image->tempName);
            return true;
        }
        return false;
    }
}
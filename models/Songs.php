<?php
namespace app\models;

use app\controllers\Tag;
use yii\helpers\ArrayHelper;
use app\models\SongTag;

// Подключаем правильный ArrayHelper


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
 * @property int|null $category_id
 *
 * @property Category $category
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
            [['name', 'artist', 'content', 'description', 'genre', 'year'], 'required'],
            [['content', 'description'], 'string'],
            [['year'], 'integer'],
            [['name', 'artist', 'genre'], 'string', 'max' => 255],
            [['image'], 'safe'],
            [['category_id'], 'integer'], // Правило для category_id
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
            'category_id' => 'Category', // Лейбл для category_id
        ];
    }

    /**
     * Связь с таблицей Category
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('songs_tag', ['song_id' => 'id']);
    }

    public function saveTags($tags)
    {
        if (is_array($tags))
        {
            $this->clearCurrentTags();

            foreach($tags as $tag_id)
            {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function clearCurrentTags()
    {
        SongTag::deleteAll(['song_id'=>$this->id]);
    }
    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }

    public function getArtist()
    {
        return $this->hasOne(User::class, ['id' => 'artist']);
    }


}

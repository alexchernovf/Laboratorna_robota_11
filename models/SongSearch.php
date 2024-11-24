<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Songs;

/**
 * SongSearch represents the model behind the search form of `app\models\Songs`.
 */
class SongSearch extends Songs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'year'], 'integer'],
            [['name', 'artist', 'genre', 'created_at', 'updated_at', 'image'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Songs::find();

        // добавьте условия, которые всегда должны применяться
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // если валидация не проходит, возвращаем пустой результат
            $query->where('0=1');
            return $dataProvider;
        }

        // фильтрация по полям
        $query->andFilterWhere([
            'id' => $this->id,
            'year' => $this->year,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'artist', $this->artist])
            ->andFilterWhere(['like', 'genre', $this->genre]);

        return $dataProvider;
    }

}

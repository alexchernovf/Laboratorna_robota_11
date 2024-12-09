<?php
namespace app\controllers;

use app\models\Songs;
use Yii;
use yii\web\Controller;
use app\models\CommentForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\Article; // Import the Article model
use app\models\Category;
use yii\data\Pagination; // Import the Pagination class
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    




    public function actionIndex()
    {
        $data=Article::getAll();

        $popular=Article::getPopular();
        $recent=Article::getRecent();
        $categories = Category::getAll();

        return $this->render('index',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent,
            'categories'=>$categories]);
            
    }

    public function actionView($id)
    {
        $article=Article::findOne($id);
        $popular=Article::getPopular();
        $recent=Article::getRecent();
        $categories = Category::getAll();
        $comments = $article->getArticleComments();
        $commentForm = new CommentForm();

        $article->viewedCounter();

        $tags = ArrayHelper::map($article->tags, 'id', 'title');
        return $this->render('single',[

            'article'=>$article,
            'tags'=>$tags,
            'popular'=>$popular,
            'recent'=>$recent,
            'categories'=>$categories,
            'comments'=>$comments,
            'commentForm'=>$commentForm
        ]);
        
    }

    public function actionCategory($id)
    {
        $data=Category::getArticlesByCategory($id);
        $popular=Article::getPopular();
        $recent=Article::getRecent();
        $categories = Category::getAll();
        return $this->render('category',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent,
            'categories'=>$categories
        ]);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }


    public function actionTag($id)
    {
        $tag = Tag::findOne($id);
        if (!$tag) {
            throw new NotFoundHttpException('Tag not found.');
        }
    
        // Get all articles associated with the tag
        $query = $tag->getArticles();
    
        // Set up pagination
        $pagination = new \yii\data\Pagination(['totalCount' => $query->count(), 'pageSize' => 5]);
    
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
    
        // Initialize variables for the sidebar
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
    
        return $this->render('tag', [
            'tag' => $tag,
            'articles' => $articles,
            'pagination' => $pagination,
            'popular' => $popular, // Pass to the view
            'recent' => $recent,
            'categories' => $categories,
        ]);
    }
    

    /**
     * display about page
     */
    public function actionComment($id)
    {
        $model = new CommentForm();
        
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->saveComment($id))
            {
                Yii::$app->getSession()->setFlash('comment', 'Your comment will be added soon!');
                return $this->redirect(['site/view','id'=>$id]);
            }
        }
    }


}
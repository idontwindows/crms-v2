<?php

namespace backend\controllers;

use common\models\Drivers;
use common\models\DriversSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * DriversController implements the CRUD actions for Drivers model.
 */
class DriversController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Drivers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DriversSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Drivers model.
     * @param int $drivers_id Drivers ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Drivers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Drivers();

        if ($this->request->isPost) {
            $model->drivers_name = $_POST['Drivers']['drivers_name'];
            $model->region_id = Yii::$app->user->identity->region_id;
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->drivers_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Drivers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $drivers_id Drivers ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'drivers_id' => $model->drivers_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Drivers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $drivers_id Drivers ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Drivers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $drivers_id Drivers ID
     * @return Drivers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Drivers::findOne(['drivers_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php
namespace backend\modules\admin\models\form;

use backend\modules\admin\components\UserStatus;
use backend\modules\admin\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\Region;
/**
 * Signup form
 */
class Signup extends Model
{
    public $username;
    public $email;
    public $password;
    public $retypePassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $class = Yii::$app->getUser()->identityClass ? : 'backend\modules\admin\models\User';
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $class, 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['retypePassword', 'required'],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $region = Region::findOne(Yii::$app->user->identity->region_id);
        if ($this->validate()) {
            $class = Yii::$app->getUser()->identityClass ? : 'backend\modules\admin\models\User';
            $user = new $class();
            $user->username = $this->username;
            $user->email = $this->email;
            if(null !== Yii::$app->user->identity->region_id) $user->regions = '[{"region_id": "'.$region->region_id.'","region_name": "'.$region->region_name.'"}]';
            if(null !== Yii::$app->user->identity->region_id) $user->region_id = Yii::$app->user->identity->region_id;
            $user->status = ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', UserStatus::ACTIVE);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}

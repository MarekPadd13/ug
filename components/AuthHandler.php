<?php
namespace app\components;

use common\models\Auth;
use common\models\User;
use common\models\Auth_assignment;

use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

// $st= new Auth_assignment();
//           $st->item_name = 'edtester';
//           $st->user_id= $user->id;


/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;
    private $_user;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {

        $attributes = $this->client->getUserAttributes();
        $email =  ArrayHelper::getValue($attributes, $this->client->getId()=='yandex' ? 'default_email' : 'email');
        $id = ArrayHelper::getValue($attributes, $this->client->getId()=='odnoklassniki' ? 'uid' : 'id');
        $first_name  =   ArrayHelper::getValue($attributes, 'first_name');
        $last_name  =ArrayHelper::getValue($attributes, 'last_name');
        $sub = ArrayHelper::getValue($attributes, 'sub');
        $names  =ArrayHelper::getValue($attributes,  $this->client->getId()=='yandex' ? 'real_name' : 'name');
        $nickname = ArrayHelper::getValue($attributes, $this->client->getId()=='google' ? 'email' : 'login');
        $name = explode(" ", $names );
        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $this->client->getId()=='google' ? $sub : $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                /* @var User $user */
                $user = $auth->user_id;
                $this->updateUserInfo($user);
                Yii::$app->user->login($this->getUser($user),  3600 * 24 * 30);
            } else { // signup
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    \Yii::$app->session->setFlash('error', "Пользователь с такой же почтой email уже зарегистрирован в системе. Если не помните пароль, пожалуйста, воспользуйтесь формой восстановления пароля.");
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'first_name' => $this->client->getId()=='vkontakte' ?  $first_name : $name[0],
                        'last_name'  => $this->client->getId()=='vkontakte' ?  $last_name :  $name[1],
                        'username' =>  $nickname ? $nickname : $id,
                        'github' =>$this->client->getId()=='google' ? $sub : $id,
                        'email' => isset($email) ? $email : $id.'@'.$this->client->getId().'.com',
                        'password' => $password,
                        'rememberMeDuration' => true,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();

                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string)$this->client->getId()=='google' ? $sub : $id,
                        ]);
                        $st= new Auth_assignment(
                            ['item_name' => 'edtester',
                                'user_id' => $user->id]);
                        $st->save();
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    $this->updateUserInfo($user);
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo($user_id)
    {
        $attributes = $this->client->getUserAttributes();
        $user= User::findOne($user_id);
        $github = ArrayHelper::getValue($attributes, 'id');
        if ($user->github === null && $github) {
            $user->github = $github;
            $user->save(false);
        }
    }

    protected function getUser($user_id)
    {   $user= User::findOne($user_id);

        if ($this->_user === null) {
            $this->_user = User::findByUsername($user->username);
        }

        return $this->_user;
    }

}
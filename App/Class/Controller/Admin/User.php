<?php

namespace OriginalAppName\Controller\Admin;

use OriginalAppName;
use OriginalAppName\Model;
use OriginalAppName\Json;
use OriginalAppName\Session;
use OriginalAppName\Admin;
use OriginalAppName\View;
use OriginalAppName\Service;
use OriginalAppName\Response;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Controller\Front
{


    public function forgotPassword($key)
    {

        // resources
        $sessionForgotPassword = new Admin\Session\User\ForgotPassword;
        $sessionFeedback = new Session\Feedback;
        $modelUser = new Model\User;

        // dependency
        if (! isset($key)) {
            $sessionFeedback->setMessage('your key has expired', 'negative');
            $this->redirect('admin');
        }

        // refresh expire
        if ($sessionForgotPassword->isExpire()) {
            $sessionForgotPassword->delete();
            $sessionFeedback->setMessage('your key has expired, please try again', 'negative');
            $this->redirect('admin');
        }

        // validation
        if (! $sessionForgotPassword->get('key')) {
            $sessionForgotPassword->delete();
            $sessionFeedback->setMessage('your key has expired', 'negative');
            $this->redirect('admin');
        }

        // key must equal stored one
        if ($key != $sessionForgotPassword->get('key')) {
            $sessionForgotPassword->delete();
            $sessionFeedback->setMessage('your key is incorrect', 'negative');
            $this->redirect('admin');
        }

        // find user by email
        $modelUser->readId([$sessionForgotPassword->get('userId')]);
        if (! $modelUser->getData()) {
            return $sessionFeedback->setMessage('no account with that email address', 'negative');
        }
        $entityUser = current($modelUser->getData());
        $this
            ->view
            ->appendAsset('css', 'admin/common')
            ->appendAsset('css', 'admin/login')
            ->setDataKey('feedback', $sessionFeedback->pull())
            ->setDataKey('userEmail', $entityUser->getEmail());
        return new Response($this->view->getTemplate('admin/forgot-password'));
    }


    public function forgotPasswordSubmit($key)
    {
        
        // resource\|
        $sessionForgotPassword = new Admin\Session\User\ForgotPassword;
        $sessionFeedback = new Session\Feedback;
        $modelUser = new Model\User;

        // validation
        if (! isset($_POST['password']) || ! isset($_POST['password_confirm'])) {
            $sessionFeedback->setMessage('you need to define a new password and confirmation', 'negative');
            $this->redirect('admin/user/forgot-password/key', ['key' => $key]);
        }

        // new passwords must be equal
        if ($_POST['password'] != $_POST['password_confirm']) {
            $sessionFeedback->setMessage('both password and confirm password must match', 'negative');
            $this->redirect('admin/user/forgot-password/key', ['key' => $key]);
        }

        // save
        $modelUser->readId([$sessionForgotPassword->get('userId')]);
        $entityUser = $modelUser->getDataFirst();
        $entityUser->consumeArray($_REQUEST);
        $modelUser->update([$entityUser]);
        if ($modelUser->getRowCount()) {
            $sessionFeedback->setMessage('password saved', 'positive');
            $sessionForgotPassword->delete();
            $this->redirect('admin');
        }

        // failure
        $sessionFeedback->setMessage('unable to save password', 'negative');
        $this->redirect('admin/user/forgot-password/key', ['key' => $key]);
    }
}

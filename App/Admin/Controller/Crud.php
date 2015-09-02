<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Entity;
use OriginalAppName\Model;
use OriginalAppName\Session;
use OriginalAppName\Admin\Session as AdminSession;
use OriginalAppName\View;
use OriginalAppName\Service;
use OriginalAppName\Response;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class Crud
{


    public function all()
    {
    }


    public function create($request)
    {
        return $this->single($request);
    }


    public function single($request)
    {

        // resource
        $modelUser = new Model\User;
        $sessionFeedback = new Session\Feedback;
        $entityUser = new Entity\User;

        // read single
        if (isset($id)) {
            $modelUser->readId([$id]);
            $entityUser = $modelUser->getDataFirst();
        }

        // save
        if ($_POST) {
            // consume post
            $entityUser
                ->setEmail($_POST['user']['email'])
                ->setNameFirst($_POST['user']['nameFirst'])
                ->setNameLast($_POST['user']['nameLast'])
                ->setLevel($_POST['user']['level']);

            // optional
            if (! $entityUser->getTimeRegistered()) {
                $entityUser->setTimeRegistered(time());
            }
            if ($_POST['user']['password']) {
                $entityUser->setPassword($_POST['user']['password']);
            }

            // update / create
            if ($entityUser->getId()) {
                $modelUser->update([$entityUser]);
            } else {
                $modelUser->create([$entityUser]);
                $entityUser->setId(current($modelUser->getLastInsertIds()));
            }

            // feeedback / route
            $sessionFeedback->setMessage('user ' . $entityUser->getId() . ' saved', 'positive');
            $this->redirect('adminUserSingle', ['id' => $entityUser->getId()]);
        }

        // render
        $this
            ->view
            ->setDataKey('user', $entityUser);
        return new Response($this->view->getTemplate('admin/user/single'));
    }


    public function delete($id)
    {

        // delete
        if (isset($_GET['delete'])) {
            $modelUser->delete(['id' => $_GET['delete']]);
            $sessionFeedback->setMessage('user ' . $_GET['delete'] . ' deleted');
            $this->redirect('adminUserAll');
        }
    }
}

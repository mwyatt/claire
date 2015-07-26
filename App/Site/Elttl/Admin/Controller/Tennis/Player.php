<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

use OriginalAppName\Response;
use OriginalAppName\Registry;
use OriginalAppName\Session;
use OriginalAppName\Site\Elttl\Model;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Player extends \OriginalAppName\Site\Elttl\Admin\Controller\Tennis\Crud
{


    public function all()
    {
        $this
            ->model
            ->readColumn('yearId', $this->yearId)
            ->orderByProperty('nameLast');
        $this
            ->view
            ->setDataKey($this->namePlural, $this->model->getData());
        return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/all"));
    }


    public function single($id = 0)
    {
        $entity = $this->model
            ->readYearColumn(null, 'id', $id)
            ->getDataFirst();
        $modelTeam = new Model\Tennis\Team;
        $modelTeam
            ->readColumn('yearId', $this->yearId)
            ->orderByProperty('name');

        // render
        $this
            ->view
            ->setDataKey('teams', $modelTeam->getData())
            ->setDataKey($this->nameSingular, $entity ? $entity : new $this->nsEntity);
        return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/single"));
    }


    public function update($id)
    {
        $sessionFeedback = new Session\Feedback;

        // load 1
        $entity = $this->model
            ->readYearColumn(null, 'id', $id)
            ->getDataFirst();

        // does not exist
        if (! $entity) {
            $this->redirect("admin/tennis/{$this->nameSingular}/all");
        }

        // consume post
        $entity->nameFirst = $_POST['entity']['nameFirst'];
        $entity->nameLast = $_POST['entity']['nameLast'];
        $entity->slug = $_POST['entity']['slug'];
        $entity->rank = $_POST['entity']['rank'];
        $entity->phoneLandline = $_POST['entity']['phoneLandline'];
        $entity->phoneMobile = $_POST['entity']['phoneMobile'];
        $entity->ettaLicenseNumber = $_POST['entity']['ettaLicenseNumber'];
        $entity->teamId = $_POST['entity']['teamId'];

        // save
        $this->model->updateYear(null, [$entity]);

        // feedback / route
        $ucName = ucfirst($this->nameSingular);
        $sessionFeedback->setMessage("$ucName $id saved", 'positive');
        $this->redirect("admin/tennis/{$this->nameSingular}/single", ['id' => $entity->getId()]);
    }
}

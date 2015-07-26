<?php
namespace OriginalAppName\Site\Elttl\Admin\Controller\System;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Tennis extends \OriginalAppName\Controller\Admin
{


    /**
     * @return object Response
     */
    public function all()
    {
        if (! empty($_GET['newSeason'])) {
            $this->newSeason();
        }
        if (! empty($_GET['generateFixtures'])) {
            $this->generateFixtures();
        }
        if (! empty($_GET['generateTableSlugs'])) {
            $this->generateTableSlugs();
        }

        // $this
        // 	->view
        // 	->setDataKey('versionsUnpatched', $versionsUnpatched);
        return new \OriginalAppName\Response($this->view->getTemplate('admin/system/tennis/all'));
    }


    public function generateTableSlugs()
    {
        $registry = \OriginalAppName\Registry::getInstance();
        $feedback = new \OriginalAppName\Session\Feedback;
        $class = '\\OriginalAppName\\Site\\Elttl\\Model\\Tennis\\' . $_GET['tableName'];
        $model = new $class;
        $model->read();
        foreach ($model->getData() as $entity) {
            // needs to be unfilled
            if ($entity->slug) {
                continue;
            }

            // other
            if (empty($entity->nameFirst) && !empty($entity->name)) {
                $entity->slug = \OriginalAppName\Helper::slugify($entity->name);
            
            // player
            } else {
                $entity->slug = \OriginalAppName\Helper::slugify($entity->nameFirst . '-' . $entity->nameLast);
            }

            // update by yearId + id
            $model->updateYear($entity->yearId, [$entity]);
        }
        $feedback->setMessage('updated all table slugs', 'positive');
        $this->redirect('admin/system/tennis');
    }


    /**
     * copies across all that is required, then moves yearId option forwards
     * @return null set feedback and redirect
     */
    public function newSeason()
    {

        // get current year and next one
        $registry = \OriginalAppName\Registry::getInstance();
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        $modelYear->readColumn('id', $registry->get('database/options/yearId'));
        $entityYear = $modelYear->getDataFirst();
        $yearIdNew = $entityYear->id + 1;

        // duplicate
        $things = ['division', 'team', 'player', 'venue'];
        foreach ($things as $thing) {
            $class = "\\OriginalAppName\\Site\\Elttl\\Model\\Tennis\\" . ucfirst($thing);
            $model = new $class;
            $model->readColumn('yearId', $entityYear->id);
            $entities = $model->getData();
            foreach ($entities as $entity) {
                $entity->yearId = $yearIdNew;
            }
            $model->duplicate($entities);
        }

        // create year
        $entityYear->name++;
        $modelYear->create([$entityYear]);
        $feedback = new \OriginalAppName\Session\Feedback;

        // update option
        $modelOption = new Model\Option;
        $modelOption->readColumn('name', 'year_id');
        $entity = $modelOption->getDataFirst();
        $entity->value = $yearIdNew;
        $modelOption->update($entity, ['id' => $entity->id]);
        $feedback->setMessage("new season {$entityYear->name} created, divisions, teams, players and venues copied over", 'positive');
        $this->redirect('admin/system/tennis');
    }


    /**
     * todo
     * @return [type] [description]
     */
    public function newSeasonRevert()
    {
        // get current year and next one
        $registry = \OriginalAppName\Registry::getInstance();
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        $modelYear->readColumn('id', $registry->get('database/options/yearId'));
        $entityYear = $modelYear->getDataFirst();
        $yearIdNew = $entityYear->id - 1;

        // duplicate
        $things = ['division', 'team', 'player', 'venue'];
        foreach ($things as $thing) {
            $class = "\\OriginalAppName\\Site\\Elttl\\Model\\Tennis\\" . ucfirst($thing);
            $model = new $class;
            $model->readColumn('yearId', $entityYear->id);
            $entities = $model->getData();
            $model->delete($model->getDataProperty('id'));
        }

        // create year
        $entityYear->name++;
        $modelYear->create([$entityYear]);
        $feedback = new \OriginalAppName\Session\Feedback;

        // update option
        $modelOption = new \OriginalAppName\Model\Option;
        $modelOption->readColumn('name', 'year_id');
        $entity = $modelOption->getDataFirst();
        $entity->value = $yearIdNew;
        $modelOption->update($entity, ['id' => $entity->id]);
        $feedback->setMessage("new season {$entityYear->name} created, divisions, teams, players and venues copied over", 'positive');
        $this->redirect('admin/system/tennis');
    }


    /**
     * generate fixtures for this year!
     */
    public function generateFixtures()
    {
        $feedback = new \OriginalAppName\Session\Feedback;
        $modelFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $success = $modelFixture->generate();
        if ($success) {
            $feedback->setMessage("all fixtures and encounters removed, and fixtures re-generated using current team configuration", 'positive');
        } else {
            $feedback->setMessage("while generating fixtures something went wrong", 'negative');
        }
        $this->redirect('admin/system/tennis');
    }
}

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
        return new \OriginalAppName\Response($this->view->getTemplate('admin/system/tennis/all'));
    }


    /**
     * tested and works
     * generates all slugs for the inputted table name
     */
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
     * tested fully
     * @return null set feedback and redirect
     */
    public function newSeason()
    {

        // get current year and next one
        $registry = \OriginalAppName\Registry::getInstance();
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        $modelYear->readColumn('id', $registry->get('database/options/yearId'));
        $entityYearOld = $modelYear->getDataFirst();

        // new year create to really get id
        $entityYearNew = clone $entityYearOld;
        $entityYearNew->name++;
        $modelYear->create([$entityYearNew]);
        $modelYear->readColumn('name', $entityYearNew->name);
        $entityYearNew = $modelYear->getDataFirst();

        // duplicate
        $things = ['division', 'team', 'player', 'venue'];
        foreach ($things as $thing) {
            $class = "\\OriginalAppName\\Site\\Elttl\\Model\\Tennis\\" . ucfirst($thing);
            $model = new $class;
            $model->readColumn('yearId', $entityYearOld->id);
            $entities = $model->getData();
            foreach ($entities as $entity) {
                $entity->yearId = $entityYearNew->id;
            }
            $model->duplicate($entities);
        }
        $feedback = new \OriginalAppName\Session\Feedback;

        // update option
        $modelOption = new \OriginalAppName\Model\Option;
        $modelOption->readColumn('name', 'year_id');
        $entity = $modelOption->getDataFirst();
        $entity->value = $entityYearNew->id;
        $modelOption->update($entity, ['id' => $entity->id]);
        $thingsImploded = implode(', ', $things);
        $feedback->setMessage("new season '{$entityYearNew->name}' created, $thingsImploded copied over", 'positive');
        $this->redirect('admin/system/tennis');
    }


    /**
     * removes all fixtures and encounters for this year
     * generate fixtures for this year only
     */
    public function generateFixtures()
    {
        $feedback = new \OriginalAppName\Session\Feedback;
        $service = new \OriginalAppName\Site\Elttl\Service\Tennis\Fixture;
        $success = $service->generate();
        if ($success) {
            $feedback->setMessage("all fixtures and encounters removed, and fixtures re-generated using current team configuration", 'positive');
        } else {
            $feedback->setMessage("while generating fixtures something went wrong", 'negative');
        }
        $this->redirect('admin/system/tennis');
    }
}

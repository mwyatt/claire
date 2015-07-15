<?php
namespace OriginalAppName\Admin\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Ad extends \OriginalAppName\Controller\Admin
{


	public function create()
	{
		
		// resource
		$entityAd = new \OriginalAppName\Entity\Ad;
		$modelAd = new \OriginalAppName\Model\Ad;

		// create new Ad
		$entityAd
			->setTimeRegistered(time());
		$modelAd->create([$entityAd]);

		// update
		$this->update(current($modelAd->getLastInsertIds()));
	}


	/**
	 * Ad list
	 * @return object Response
	 */
	public function all() {
		
		// resource
		$modelAd = new \OriginalAppName\Model\Ad;
		$sessionFeedback = new \OriginalAppName\Session\Feedback;

		// get ads
		$modelAd->read();

		// render
		$this
			->view
			->setDataKey('ads', $modelAd->getData());
		return new \OriginalAppName\Response($this->view->getTemplate('admin/ad/all'));
	}


	public function single($id = 0)
	{

		// resource
		$modelAd = new \OriginalAppName\Model\Ad;

		// read single
		$entityAd = $modelAd
			->readId([$id])
			->getDataFirst();

		// render
		$this
			->view
			->appendAsset('js', 'admin/ad/single')
			->setDataKey('ad', $entityAd ? $entityAd : new \OriginalAppName\Entity\Ad);
		return new \OriginalAppName\Response($this->view->getTemplate('admin/ad/single'));
	}


	public function update($id)
	{

		// resources
		$sessionFeedback = new \OriginalAppName\Session\Feedback;
		$modelAd = new \OriginalAppName\Model\Ad;

		// load 1
		$entityAd = $modelAd
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityAd) {
			$this->redirect('admin/ad/all');
		}

		// consume post
		$entityAd
			->setEmail($_POST['ad']['email'])
			->setNameFirst($_POST['ad']['nameFirst'])
			->setNameLast($_POST['ad']['nameLast']);

		// remove all permissions then add the ones selected
		$modelPermission = new \OriginalAppName\Model\Ad\Permission;
		$modelPermission->deleteAdId($id);
		$entitiesPermission = [];
		if (! empty($_POST['ad']['permission'])) {
			foreach ($_POST['ad']['permission'] as $route) {
				$entityPermission = new \OriginalAppName\Entity\Ad\Permission;
				$entityPermission->adId = $id;
				$entityPermission->name = $route;
				$entitiesPermission[] = $entityPermission;
			}
			$modelPermission->create($entitiesPermission);
		}

		// optional
		if (! $entityAd->getTimeRegistered()) {
			$entityAd->setTimeRegistered(time());
		}
		if ($_POST['ad']['password']) {
			$entityAd->setPassword($_POST['ad']['password']);
		}

		// save
		$modelAd->update($entityAd, ['id' => $entityAd->getId()]);

		// feedback / route
		$sessionFeedback->setMessage("ad $id saved", 'positive');
		$this->redirect('admin/ad/single', ['id' => $entityAd->getId()]);
	}


	public function delete($id)
	{
		
		// resources
		$modelAd = new \OriginalAppName\Model\Ad;
		$sessionFeedback = new \OriginalAppName\Session\Feedback;

		// load 1
		$entityAd = $modelAd
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityAd) {
			$this->redirect('admin/ad/all');
		}

		// delete it
		$modelAd->delete(['id' => $id]);

		// prove it
		if ($modelAd->getRowCount()) {
			$sessionFeedback->setMessage("ad $id deleted");
			$this->redirect('admin/ad/all');
		} else {
			$sessionFeedback->setMessage("unable to delete $id");
		}
	}
}
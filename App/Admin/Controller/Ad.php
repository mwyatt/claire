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
		$entityAd->timeCreated = time();
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
		$entityAd->title = $_POST['ad']['title'];
		$entityAd->description = $_POST['ad']['description'];
		$entityAd->image = $_POST['ad']['image'];
		$entityAd->url = $_POST['ad']['url'];
		$entityAd->action = $_POST['ad']['action'];
		$entityAd->group = $_POST['ad']['group'];
		$entityAd->status = $_POST['ad']['status'];

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

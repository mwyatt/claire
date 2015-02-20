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
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Controller\Admin
{


	/**
	 * User list
	 * @return object Response
	 */
	public function adminUserAll($request) {
		
		// resource
		$modelUser = new Model\User;
		$sessionFeedback = new Session\Feedback;

		// get users
		$modelUser->read();

		// delete
		if (isset($_GET['delete'])) {
			$modelUser->delete(['id' => $_GET['delete']]);
			$sessionFeedback->setMessage('user ' . $_GET['delete'] . ' deleted');
			$this->redirect('adminUserAll');
		}

		// render
		$this
			->view
			->setDataKey('users', $modelUser->getData());
		return new Response($this->view->getTemplate('admin/user/all'));
	}


	public function adminUserCreate($request)
	{
		return $this->adminUserSingle($request);
	}


	public function adminUserSingle($request)
	{

		// resource
		$modelUser = new Model\User;
		$sessionFeedback = new Session\Feedback;
		$entityUser = new Entity\User;

		// read single
		if (isset($request['id'])) {
			$modelUser->readId([$request['id']]);
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
				$modelUser->update($entityUser, ['id' => $entityUser->getId()]);
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


	/**
	 * not required now below?
	 */



	/**
	 * handles crud for all User operations
	 */
	public function run() {
		$modelLog = new model_log($this);
		$modelUser = new model_User($this);
		$sessionFeedback = new session_feedback($this);
		$cache = new cache($this);

		// get User status always
		$this->view->setDataKey('user_status', $modelUser->getStatus());

		// any post or get event
		if (
			array_key_exists('create', $_POST)
			|| array_key_exists('update', $_POST)
			|| array_key_exists('delete', $_GET)
			|| array_key_exists('archive', $_GET)
		) {
			$cache->delete('home-latest-posts');
			$cacheKey = 'ceil-User-' . $this->url->getPathPart(2);
			$cache->read($cacheKey);
			$cache->delete($cacheKey);
			$modelUser->read(array(
				'where' => array(
					'type' => $this->url->getPathPart(2),
					'status' => 'visible'
				)
			));
			$cache->create(count($modelUser->getData()));
		}

		// create draft entry and redirect to edit page
		if ($this->url->getPathPart(3) == 'new') {
			return $this->create();
		}

		// update
		if (array_key_exists('update', $_POST)) {
			return $this->update();
		}

		// archive
		if (array_key_exists('archive', $_GET)) {
			return $this->archive();
		}

		// edit
		if (array_key_exists('edit', $_GET)) {
			return $this->edit();
		}
		$this->User();
	}


	/**
	 * removes all meta assigned to the current User item and reassigns
	 * the new meta bindings
	 * @param  string $metaName identifies the type of meta
	 */
	public function updateMeta($metaName)
	{
		$modelUserMeta = new model_User_meta($this);
		$success = false;
		if (array_key_exists($metaName . '_attached', $_POST)) {
			$molds = array();
			foreach ($_POST[$metaName . '_attached'] as $value) {
				$mold = new mold_User_meta();
				$mold->User_id = $_GET['edit'];
				$mold->name = $metaName;
				$mold->value = $value;
				$molds[] = $mold;
			}
			$success = $modelUserMeta->create($molds);
		}
		return $success;
	}


	public function update()
	{
		$modelLog = new model_log($this);
		$modelUser = new model_User($this);
		$sessionFeedback = new session_feedback($this);
		$modelUserMeta = new model_User_meta($this);
		$modelUserMeta->delete(array(
			'where' => array(
				'User_id' => $_GET['edit']
			)
		));
		$mold = new mold_User();
		$mold->title = $_POST['title'];
		$mold->slug = Helper::slugify($_POST['slug']);
		$mold->html = $_POST['html'];
		$mold->type = $_POST['type'];
		$mold->time_published = strtotime(implode(' ', $_POST['time_published']));
		$mold->status = $_POST['status'];
		$modelUser->update($mold, array(
			'where' => array(
				'id' => $_GET['edit']
			)
		));
		$this->updateMeta('media');
		$this->updateMeta('tag');
		$modelLog->log('admin', 'post updated');
		$sessionFeedback->set('User updated. <a href="' . $this->url->getCache('current_sans_query') . '">Back to list</a>');
		$this->redirect('current');
	}


	public function archive()
	{
		$modelLog = new model_log($this);
		$modelUser = new model_User($this);
		$sessionFeedback = new session_feedback($this);
		if (! $modelUser->read(array('where' => array('id' => $_GET['archive'])))) {
			return $sessionFeedback->set('Problem archiving User');
		}
		$mold = $modelUser->getDataFirst();
		$mold->status = 'archive';
		if (! $modelUser->update($mold, array(
			'where' => array(
				'id' => $_GET['archive']
			)
		))) {
			return $sessionFeedback->set('Problem archiving User');
		}
		$sessionFeedback->set('User archived successfully');
		$modelLog->log('admin', 'post archived');
		$this->redirect('current_sans_query');
	}


	public function edit()
	{
		$modelUser = new model_User($this);
		$modelUser->read(array(
			'where' => array(
				'type' => $this->url->getPathPart(2),
				'id' => $_GET['edit']
			)
		));
		$modelUser->bindMeta('media');
		$modelUser->bindMeta('tag');
		if (! $modelUser->getData()) {
			$this->redirect('current_sans_query');
		}

		// single
		$User = $modelUser->getDataFirst();
		$this->view
			->setDataKey('userDate', date('Y-m-d', $User->time_published))
			->setDataKey('userTime', date('G:i', $User->time_published))
			->setDataKey('user', $User)
			->getTemplate('admin/user/update');
	}


	public function create()
	{
		$modelLog = new model_log($this);
		$modelUser = new model_User($this);
		$sessionFeedback = new session_feedback($this);
		$sessionHistory = new session_history($this);
		$mold = new mold_User();
		$mold->title = 'Untitled';
		$mold->slug = '';
		$mold->html = '';
		$mold->type = $this->url->getPathPart(2);
		$mold->time_published = time();
		$mold->user_id = 0;
		$mold->status = 'draft';
		$modelUser->create(array($mold));
		$this->route($this->url->getCache('admin') . $this->url->getPathPart(1) . '/' . $this->url->getPathPart(2) . '/?edit=' . $modelUser->getLastInsertId());
	}


	public function forgotPassword($key)
	{

		// resources
		$sessionForgotPassword = new AdminSession\User\ForgotPassword;
		$sessionFeedback = new Session\Feedback;
		$modelUser = new Model\User;


		// dependency
		if (! isset($key)) {
			$sessionFeedback->setMessage('you need a key', 'negative');
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
			$sessionFeedback->setMessage('you need a key', 'negative');
			$this->redirect('admin');
		}

		// key must equal stored one
		if (! $key == $sessionForgotPassword->get('key')) {
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
			->setDataKey('userEmail', $entityUser->getEmail());
		return new Response($this->view->getTemplate('admin/forgot-password'));
	}


	public function forgotPasswordSubmit($key)
	{
		
		// handle submission
		if ($_POST) {

			// validation
			if (! isset($_POST['password']) || ! isset($_POST['password_confirm'])) {
				$sessionFeedback->setMessage('you need to define a new password and confirmation', 'negative');
				$this->redirect('adminForgotPassword', ['key' => $key]);
			}

			// new passwords must be equal
			if ($_POST['password'] != $_POST['password_confirm']) {
				$sessionFeedback->setMessage('both password and confirm password must match', 'negative');
				$this->redirect('adminForgotPassword', ['key' => $key]);
			}

			// save
			$modelUser->readId([$sessionForgotPassword->get('userId')]);
			$entityUser = $modelUser->getDataFirst();
			$entityUser->consumeArray($_REQUEST);
			$modelUser->update($entityUser, ['id' => $entityUser->getId()]);
			if ($modelUser->getRowCount()) {
				$sessionFeedback->setMessage('password saved', 'positive');
				$this->redirect('admin');
			}

			// failure
			$sessionFeedback->setMessage('unable to save password', 'negative');
			$this->redirect('adminForgotPassword', ['key' => $key]);
		}
	}

}

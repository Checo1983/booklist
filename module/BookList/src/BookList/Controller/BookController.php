<?php 
namespace BookList\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use BookList\Form\BookForm;

class BookController extends AbstractActionController {
	protected $bookTable;
	
	public function indexAction() {
		return new ViewModel(array(
			'books' => $this->getBookTable()->fetchAll(),
		));
	}

	public function addAction() {
		$form = new BookForm();
		$form->get('submit')->setValue('Add');

		$request = $this->getRequest();
		if ($request->isPost()) {
			# code...
		}
		return array('form' => $form);
	}

	public function editAction() {
		$form = new BookForm();
		$form->bind($book);
		$form->get('submit')->setAttribute('value', 'Edit');

		$request = $this->getRequest();
		if ($request->isPost()) {
			# code...
		}

		return array(
			'id'   => $id,
			'form' => $form,
		);
	}

	public function deleteAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('book');
		}

		$request = $this->getRequest();
		if ($request->isPost()) {
			# code...
		}

		return array(
			'id'   => $id,
			//'book' => $form,
		);
	}

	public function getBookTable() {
		if (!$this->bookTable) {
			$sm = $this->getServiceLocator();
			$this->bookTable = $sm->get('BookList\Model\BookTable');
		}
		return $this->bookTable;
		
	}
}
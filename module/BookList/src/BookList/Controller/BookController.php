<?php 
namespace BookList\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use BookList\Form\BookForm;
use BookList\Model\Book;

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
			$book = new Book();
			$form->setInputFilter($book->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$book->exchangeArray($form->getData());
				$this->getBookTable()->saveBook($book);
			}

			//Redirect to books list
			return $this->redirect()->toRoute('book');
		}
		return array('form' => $form);
	}

	public function editAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		$book = $this->getBookTable()->getBook($id);
		$form = new BookForm();
		$form->bind($book);
		$form->get('submit')->setAttribute('value', 'Edit');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($book->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$this->getBookTable()->saveBook($book);

				// Redirect
				return $this->redirect()->toRoute('book');
			}
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
			$del = $request->getPost('del', 'No');

			if ($del == 'Yes') {
				$id = (int) $request->getPost('id');
				$this->getBookTable()->deleteBook($id);
			}

			// Redirect
			return $this->redirect()->toRoute('book');
		}

		return array(
			'id'   => $id,
			// 'book' => $this->getBookTable()->getBook($id)
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
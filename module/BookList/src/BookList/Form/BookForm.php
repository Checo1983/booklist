<?php
namespace BookList\Form;

use Zend\Form\Form;

class BookForm extends Form {

	public function __construct($name = null) {

		//we want to ignore the name passed
		parent::__construct('book');

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		$this->add(array(
			'name' => 'title',
			'type' => 'Text',
			'options' => array(
				'label' => 'Title',
			),
		));
		$this->add(array(
			'name' => 'author',
			'type' => 'Text',
			'options' => array(
				'label' => 'author',
			),
		));
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'atributes' => array(
				'value' => 'Go',
				'id'	=> 'submitbutton',
			),
		));
	} 
}
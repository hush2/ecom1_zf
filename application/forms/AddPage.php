<?php

class Application_Form_AddPage extends Application_Form_Base
{
    public function init()
    {
        $this->setAction('add_page');

        $this->addElement('text', 'title', array(
            'label' => 'Title<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter a title.')),
                array('StringLength', true, array(2, 32, 'messages' => 'Title must be %min% to %max% characters.')),
        )));

        $categories = new Application_Model_Category();
        $options['none'] = 'Select One';
        foreach ($categories->all() as $category) {
            $options[$category->id] = $category->category;
        }

        $this->addElement('select', 'category_id', array(
            'label' => 'Category<br/>',
            'multioptions' => $options,
            'validators' => array(
                array('Db_RecordExists', true, array('categories', 'id', 'messages' => 'Please select a category!')),
        )));

        $this->addElement('textarea', 'description', array(
            'label' => 'Description<br/>',
            'required' => true,
            'cols' => 75,
            'rows' => 5,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter some description.')),
                array('StringLength', true, array(2, 64, 'messages' => 'Description must be %min% to %max% characters.')),
        )));

        $this->addElement('textarea', 'content', array(
            'label' => 'Content<br/>',
            'required' => true,
            'id' => 'tinyeditor',
            'cols' => 75,
            'rows' => 5,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter some content.')),
                array('StringLength', true, array(2, 1024, 'messages' => 'Content must be %min% to %max% characters.')),
        )));

        $this->addElement('submit', 'submit', array(
            'label' => 'Add This Page',
            'class' => 'formbutton',
            'ignore' => true,
            'decorators' => array('ViewHelper'),
        ));

        $this->addDisplayGroup(array('title', 'category_id', 'description', 'content', 'submit'),
                               'fieldset',
                               array('legend' => 'Fill out the form to add a page of content:'));
        $fieldset = $this->getDisplayGroup('fieldset');
        $fieldset->removeDecorator('DtDdWrapper');
    }
}

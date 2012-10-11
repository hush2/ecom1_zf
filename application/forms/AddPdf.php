<?php

class Application_Form_AddPdf extends Application_Form_Base
{
    public function init()
    {
        $this->setAction('add_pdf')
             ->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'title', array(
            'label' => 'Title<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter a title.')),
                array('StringLength', true, array(2, 32, 'messages' => 'Title must be %min% to %max% characters.')),
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

        $this->addElement('file', 'pdf', array(
            'label' => 'PDF<br/>',
            'description' => '<small>PDF only, 1MB Limit.</small>',
            'required' => true,
            'maxfilesize' => 1048576,
            'filters' => array(
                'Rename' => array('target' => PDF_DIR . sha1(uniqid()))
            ),
            'validators' => array(
                array('MimeType', true, array('application/pdf', 'messages' => 'File is not a PDF.')),
                array('Size', true, 1048576),
            ),
            'decorators' => array(
                'File',
                'Error',
                array('Label', array('escape' => false)),
                array('Description', array('escape' => false, 'tag' => 'span')),
                array('HtmlTag', array('tag' => 'p')),
        )));

        $this->addElement('submit', 'submit', array(
            'label' => 'Add This PDF',
            'ignore' => true,
            'class' => 'formbutton',
            'decorators' => array('ViewHelper'),
        ));

        $this->addDisplayGroup(array('title', 'description', 'pdf', 'submit'),
                               'fieldset',
                               array('legend' => 'Fill out the form to add a PDF to the site:'));
        $fieldset = $this->getDisplayGroup('fieldset');
        $fieldset->removeDecorator('DtDdWrapper');
    }
}
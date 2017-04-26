<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Question;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class QuizAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', 'text', ['label' => 'Titre', 'required' => true]);
        $formMapper->add('questions', 'entity', ['required' => true,
            'label' => 'Questions',
            'multiple' => true,
            'class' => Question::class]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('title');
    }

    public function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id', null, ['label' => 'Id']);
        $list->addIdentifier('title', null, ['label' => 'Nom']);
    }
}
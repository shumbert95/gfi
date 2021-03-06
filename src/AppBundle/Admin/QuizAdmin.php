<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Question;
use AppBundle\Entity\Tags;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class QuizAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('code', 'text', ['label' => 'Code', 'required' => true]);
        $formMapper->add('tag', 'entity', ['label' => 'Compétence', 'required' => true, 'class' => Tags::class]);
        $formMapper->add('title', 'text', ['label' => 'Titre', 'required' => false]);
        $formMapper->add('questions', 'entity', ['required' => true,
            'label' => 'Questions',
            'multiple' => true,
            'class' => Question::class]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('code');
        $datagridMapper->add('title');
        $datagridMapper->add('tag');
    }

    public function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id', null, ['label' => 'Id']);
        $list->addIdentifier('code', null, ['label' => 'Code']);
        $list->addIdentifier('title', null, ['label' => 'Nom']);
        $list->addIdentifier('tag', null, ['label' => 'Compétence']);
    }
}
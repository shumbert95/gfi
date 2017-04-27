<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class QuestionAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('code', 'text', ['label' => 'Code', 'required' => true]);
        $formMapper->add('title', CKEditorType::class, ['label' => 'Question', 'required' => true]);
        $formMapper->add('answerOne', CKEditorType::class, ['label' => 'Réponse 1', 'required' => true]);
        $formMapper->add('answerTwo', CKEditorType::class, ['label' => 'Réponse 2', 'required' => true]);
        $formMapper->add('answerThree', CKEditorType::class, ['label' => 'Réponse 3', 'required' => false]);
        $formMapper->add('answerFour', CKEditorType::class, ['label' => 'Réponse 4', 'required' => false]);
        $formMapper->add('goodAnswer', CKEditorType::class, ['label' => 'Bonne réponse', 'required' => true]);
        $formMapper->add('time', 'integer', ['label' => 'Temps autorisé (secondes)', 'required' => true]);
        $formMapper->add('points', 'integer', ['label' => 'Points', 'required' => true]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('code');
        $datagridMapper->add('title');
    }

    public function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id', null, ['label' => 'Id']);
        $list->addIdentifier('code', null, ['label' => 'Code']);
        $list->addIdentifier('title', null, ['label' => 'Nom']);
        $list->addIdentifier('time', null, ['label' => 'Temps autorisé']);
        $list->addIdentifier('points', null, ['label' => 'Points']);
    }
}
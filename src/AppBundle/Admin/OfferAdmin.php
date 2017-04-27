<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Quiz;
use AppBundle\Entity\Tags;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OfferAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('reference', 'text', ['label' => 'Reference', 'required' => true]);
        $formMapper->add('title', 'text', ['label' => 'Titre', 'required' => true]);
        $formMapper->add('poste', 'text', ['label' => 'Poste', 'required' => true]);
        $formMapper->add('description', CKEditorType::class, ['label' => 'Description', 'required' => true]);
        $formMapper->add('date', DateType::class, ['label' => 'Date', 'required' => true]);
        $formMapper->add('required_skills', 'entity', ['required' => true,
            'label' => 'Compétences requises',
            'multiple' => true,
            'class' => Tags::class]);
        $formMapper->add('optional_skills', 'entity', ['required' => false,
            'label' => 'Compétences optionnelles',
            'multiple' => true,
            'class' => Tags::class]);
        $formMapper->add('quizs', 'entity', ['required' => false,
            'label' => 'Questionnaires',
            'multiple' => true,
            'class' => Quiz::class]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('reference');
        $datagridMapper->add('poste');
        $datagridMapper->add('title');
    }

    public function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id', null, ['label' => 'Id']);
        $list->addIdentifier('reference', null, ['label' => 'Reference']);
        $list->addIdentifier('poste', null, ['label' => 'Poste']);
        $list->addIdentifier('title', null, ['label' => 'Titre']);
    }
}
<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Question;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TagAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text', ['label' => 'Name', 'required' => true]);
        $formMapper->add('custom', null, ['label' => 'Personnalisé', 'required' => true]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('name');
    }

    public function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id', null, ['label' => 'Id']);
        $list->addIdentifier('name', null, ['label' => 'Nom']);
        $list->addIdentifier('custom', null, ['label' => 'Personnalisé', 'editable' => true]);
    }
}
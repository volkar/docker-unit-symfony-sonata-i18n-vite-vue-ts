<?php

namespace App\Admin;

use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class CategoryAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list->add('id', null, ['header_style' => 'width: 3em;', 'row_align' => 'center', 'label' => false]);
        $list->addIdentifier('title', null, ['route' => ['name' => 'edit']]);
        $list->add('slug', null, ['editable' => true]);
        $list->add(ListMapper::NAME_ACTIONS, null, ['actions' => ['edit' => [],'delete' => []], 'label' => false]);
    }

    protected function configureFormFields(FormMapper $edit): void
    {
        $edit->add('title', TextType::class);
        $edit->add('slug', TextType::class);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id');
        $show->add('title');
        $show->add('slug');
    }

    protected function configureDatagridFilters(DatagridMapper $grid): void
    {
        $grid->add('title');
    }

    public function toString(object $object): string
    {
        return $object instanceof Category ? $object->getTitle() : 'Category';
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'ASC';
        $sortValues[DatagridInterface::SORT_BY] = 'id';
    }
}
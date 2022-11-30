<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class PageAdmin extends AbstractAdmin
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
        $edit->add('content', SimpleFormatterType::class, ['format' => 'richhtml']);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id');
        $show->add('title');
        $show->add('slug');
        $show->add('content');
    }

    protected function configureDatagridFilters(DatagridMapper $grid): void
    {
        $grid->add('title');
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'ASC';
        $sortValues[DatagridInterface::SORT_BY] = 'id';
    }

}
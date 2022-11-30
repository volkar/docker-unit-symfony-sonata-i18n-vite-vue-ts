<?php

namespace App\Admin;

use App\Entity\Project;
use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ProjectAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list->add('id', null, ['header_style' => 'width: 3em;', 'row_align' => 'center', 'label' => false]);
        $list->addIdentifier('title', null, ['route' => ['name' => 'edit']]);
        $list->add('category.title');
        $list->add('picture', 'string', ['template' => 'admin/list_picture.html.twig']);
        $list->add(ListMapper::NAME_ACTIONS, null, ['actions' => ['edit' => [],'delete' => []], 'label' => false]);
    }

    protected function configureFormFields(FormMapper $edit): void
    {
        $edit->with('Content', ['class' => 'col-md-8']);
        $edit->add('title', TextType::class);
        $edit->add('content', SimpleFormatterType::class, ['format' => 'richhtml']);
        $edit->add('picture', ModelListType::class);
        $edit->end();
        $edit->with('Meta data', ['class' => 'col-md-4']);
        $edit->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'title']);
        $edit->end();
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->with('Content', ['class' => 'col-md-8']);
        $show->add('id');
        $show->add('title');
        $show->add('content');
        $show->add('category.title');
        $show->end();
        $show->with('Picture', ['class' => 'col-md-4']);
        $show->add('picture', 'string', ['template' => 'admin/show_picture.html.twig', 'label' => false]);
        $show->end();
    }

    protected function configureDatagridFilters(DatagridMapper $grid): void
    {
        $grid->add('title');
    }

    public function toString(object $object): string
    {
        return $object instanceof Project ? $object->getTitle() : 'Project';
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'ASC';
        $sortValues[DatagridInterface::SORT_BY] = 'id';
    }

}
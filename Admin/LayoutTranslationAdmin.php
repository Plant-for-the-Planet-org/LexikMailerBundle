<?php

namespace Lexik\Bundle\MailerBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * LayoutTranslationAdmin
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class LayoutTranslationAdmin extends AbstractAdmin
{
    protected $parentAssociationMapping = 'layout';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('list');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add(
                'lang',
                'language',
                [
                    'required'          => true,
                    'preferred_choices' => ['fr']
                ]
            )
            ->add(
                'body',
                'textarea',
                array(
                    'required' => true,
                    'attr'     => array(
                        'data-editor' => 'html'
                    )
                )
            );
    }
}

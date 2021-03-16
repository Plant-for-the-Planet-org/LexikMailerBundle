<?php

namespace Lexik\Bundle\MailerBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * EmailTranslationAdmin
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class EmailTranslationAdmin extends AbstractAdmin
{
    protected $parentAssociationMapping = 'email';

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
                array(
                    'required'          => true,
                    'preferred_choices' => array('fr')
                )
            )
            ->add('fromAddress')
            ->add('fromName')
            ->add('subject')
            ->add(
                'body',
                null,
                array(
                    'attr' => array('rows' => 20, 'data-editor' => 'html')
                )
            )
            ->add(
                'bodyText',
                null,
                array(
                    'attr' => array('rows' => 20)
                )
            );
    }
}

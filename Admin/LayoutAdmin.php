<?php

namespace Lexik\Bundle\MailerBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Lexik\Bundle\MailerBundle\Entity\Layout;
use Lexik\Bundle\MailerBundle\Entity\LayoutTranslation;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * LayoutAdmin
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class LayoutAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('show');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('reference')
            ->add('description');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('General')
            ->add('reference', 'text', ['required' => true])
            ->add('description', 'textarea', ['required' => false])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('reference')
            ->add('description')
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'edit'   => array(),
                        'delete' => array(),
                    )
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('reference');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null): void
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $id = $this->getRequest()->get('id');

        /** @var Layout $object */
        $object = $this->getObject($id);

        $createMenuItem = $menu->addChild(
            $this->getTranslator()->trans('create_translation'),
            array(
                'route'           => 'admin_lexik_mailer_layout_layouttranslation_create',
                'routeParameters' => array(
                    'id' => $id
                )
            )
        );

        $createMenuItem->setLinkAttribute('class', 'lexik-mailer-create');

        /** @var LayoutTranslation $translation */
        foreach ($object->getTranslations() as $translation) {
            $menu->addChild(
                $translation->getLang(),
                array(
                    'route'           => 'admin_lexik_mailer_layout_layouttranslation_edit',
                    'routeParameters' => array('id' => $id, 'childId' => $translation->getId()),
                    'routeAbsolute'   => false
                )
            );
        }
    }
}

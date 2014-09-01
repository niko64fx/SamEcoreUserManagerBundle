<?php

namespace CanalTP\SamEcoreUserManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;
use CanalTP\SamEcoreUserManagerBundle\Form\DataTransformer\RoleToUserApplicationRoleTransformer;
use CanalTP\SamEcoreUserManagerBundle\Form\Type\RoleByApplicationType;

class RoleType extends AbstractType
{
    private $em;
    private $userRolesTransformer;

    public function __construct(
        EntityManager $entityManager,
        RoleToUserApplicationRoleTransformer $userRolesTransformer
    )
    {
        $this->em = $entityManager;
        $this->userRolesTransformer = $userRolesTransformer;
    }

    private function initRoleField(FormBuilderInterface $builder)
    {
        $builder->add(
            'applications',
            'collection',
            array(
                'label' => 'applications',
                'type' => new RoleByApplicationType()
            )
        )->addModelTransformer($this->userRolesTransformer);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->initRoleField($builder);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CanalTP\SamEcoreUserManagerBundle\Entity\User'
            )
        );
    }

    public function getName()
    {
        return 'assign_role';
    }
}

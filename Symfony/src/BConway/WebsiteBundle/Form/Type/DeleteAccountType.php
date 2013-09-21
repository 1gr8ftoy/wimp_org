<?php
// src/BConway/WebsiteBundle/Form/Type/DeleteAccountType.php

namespace BConway\WebsiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Collection;

class DeleteAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', 'password', array(
                'label' => 'Current password:'
            ))
            ->add('deleteAccount', 'submit', array(
                'label' => 'Delete my account'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'currentPassword' => array(
                new UserPassword(array('message' => 'Invalid password, please try again'))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'delete_account';
    }
}
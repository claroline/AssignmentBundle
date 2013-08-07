<?php

namespace Claroline\AssignmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AssignmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('instructions', 'textarea');
        $builder->add('allowLateUpload', 'checkbox');
        $builder->add('isPublic', 'checkbox');
        $builder->add(
            'startDate',
            'date',
            array(
                'format' => 'd-M-yyyy ',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker', 'data-date-format' => 'dd-mm-yyyy'),
                'input' => 'datetime'
            )

        );
        $builder->add(
            'endDate',
            'date',
            array(
                'format' => 'd-M-yyyy ',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker', 'data-date-format' => 'dd-mm-yyyy'),
                'input' => 'datetime'
            )
        );
    }

    public function getName()
    {
        return 'assignment_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'translation_domain' => 'assignment'
            )
        );
    }
}
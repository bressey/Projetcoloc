<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColocationsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adresse')->add('ville')->add('nbPers')->add('nbChambre')->add('type', ChoiceType::class, array(
		'choices'  => array(
        '...' => "NULL",
        'T1' => "T1",
        'T2' => "T2",
		'T3' => "T3",
		'T4' => "T4",
		'T5' => "T5",
		'T6 et +' => "T6 et +")))->add('prix')
		->add('prix');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Colocations'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_colocations';
    }


}

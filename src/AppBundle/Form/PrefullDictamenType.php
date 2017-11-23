<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrefullDictamenType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id')->add('evaluaciones')->add('argumento')->add('dicpresGrado')->add('dicpresNombre')->add('dicpresApellidoPaterno')->add('dicpresApellidoMaterno')->add('dicsecGrado')->add('dicsecNombre')->add('dicsecApellidoPaterno')->add('dicsecApellidoMaterno')->add('asesor1')->add('asesor2')->add('asesor3')->add('asesor4')->add('asesor5')->add('asesor6')->add('division');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PrefullDictamen'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_prefulldictamen';
    }


}

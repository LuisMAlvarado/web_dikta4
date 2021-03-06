<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DictamenType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numDictamen')
            ->add('fechaDictmen', DateType::class,array(
                'format' => 'dd-MM-yyyy'
            ))
            ->add('nivelAsignado')
            ->add('modalidades')
            ->add('argumento')
            ->add('asesor1')
            ->add('asesor2')
            ->add('asesor3')
            ->add('asesor4')
            ->add('asesor5')
            ->add('asesor6')
            ->add('presidente')
            ->add('secretario')
            ->add('pdfDictamen')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Dictamen'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_dictamen';
    }


}

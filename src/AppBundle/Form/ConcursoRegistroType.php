<?php

namespace AppBundle\Form;

use AppBundle\Form\EventListener\AddConcursoAsisDivSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ConcursoRegistroType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registros', CollectionType::class, array(
                'entry_type' => RegistroAspType::class,
                'by_reference' =>  false,
                'allow_add' => true,
                'allow_delete' =>true,
                'entry_options' => array(
                    'required' => true
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Concurso'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_concurso';
    }


}

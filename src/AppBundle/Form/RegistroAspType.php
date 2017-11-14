<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\AspiranteToRfcTransformer;
use AppBundle\Form\EventListener\AddEntregoDocsSubscriber;
use function PHPSTORM_META\type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroAspType extends AbstractType
{
    private  $manager;

    public function __construct($manager)
    {
        $this->manager=$manager;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('numRegistro', HiddenType::class)
            //->add('puntaje')
            //->add('prelacion')
            //->add('nivelAsig')
            //->add('createAt')
           // ->add('id')
            ->add('aspiranteRfc', TextType::class)
            //->add('concurso')
            ->add('entregoDocs')
            ->addEventSubscriber(new AddEntregoDocsSubscriber())
        ;
        $builder->get('aspiranteRfc')->addModelTransformer(new AspiranteToRfcTransformer($this->manager));
    }
    
    /**->addEventSubscriber(new AddPdfSubscriber())
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Registro'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_registro';
    }


}

<?php

namespace AppBundle\Form;

use AppBundle\Form\EventListener\AddConcursoAsisDivSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManager;


class ConcursoType extends AbstractType
{
    private $security, $em, $user;
    
public function __construct($security,$em, $user)
{
    $this->security=$security;
    $this->em=$em;
    $this->user=$user;
    
}

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('plaza')
            ->add('createAt', DateType::class,array(
                'format' => 'dd-MM-yyyy'
            ))
            //->add('fechaPublicacion', DateType::class, array(
            //    'format' => 'dd-MM-yyyy',
            // ))
            ->add('unidad')
            ->add('areaDepartamental')
            ->add('clasificacion')
            ->add('categoria')
            ->add('tiempoDedicacion')
            ->add('horario')
            ->add('causaltxt')
            ->add('causal',
                ChoiceType::class, array(
                    'choices'  => array(
                        'LICENCIA' => 'LICENCIA',
                        'SABÁTICO' => 'SABÁTICO.',
                        'NOMBRAMIENTO DE CONFIANZA ' => 'NOMBRAMIENTO DE CONFIANZA',
                        'COMISIÓN' => 'COMISIÓN.',
                        'DEFUNCIÓN.' => 'DEFUNCIÓN.',
                        'RENUNCIA' =>'RENUNCIA',
                        'RECISIÓN' =>'RECISIÓN',
                        'INCAPACIDAD' => 'INCAPACIDAD',
                        'DESIGNACIÓN COMO ÓRGANO PERSONAL ' => 'DESIGNACIÓN COMO ÓRGANO PERSONAL.',
                        'ABANDONO DE EMPLEO ' => 'ABANDONO DE EMPLEO.',
                        'REALIZACIÓN NO OPORTUNA DE C. OPO.'=> 'REALIZACIÓN NO OPORTUNA DE CONCURSO DE OPOSICIÓN.',
                        'PLAZA DE NUEVA CREACIÓN.' => 'PLAZA DE NUEVA CREACIÓN.',
                        'INTERPOSICIÓN DE RECURSO DEL' => 'INTERPOSICIÓN DE RECURSO DEL',
                        'CREACIÓN DE GRUPOS ADICIONALES' => 'CREACIÓN DE GRUPOS ADICIONALES.',
                        'TÉRMINO DE CONTRATO' =>'TÉRMINO DE CONTRATO',
                        'CONCURSO OP. DESIERTO' => 'CONCURSO DE OPOSICIÓN DESIERTO',
                        'CONCURSO OP. SIN ASPIRANTES' => 'CONCURSO DE OPOSICIÓN SIN ASPIRANTES',
                        'C.O. IMPUGNADO ' => 'CONCURSO DE  OPOSICIÓN IMPUGNADO',

                    ),'placeholder' => '--SELECCIONE--',
                    'empty_data'  => null))

            ->add('salarioA', MoneyType::class, array('currency'=>'MXN','grouping'=> true, 'required' => false))
            ->add('salarioB', MoneyType::class, array('currency'=>'MXN','grouping'=> true, 'required' => false))
            ->add('actividades')
            ->add('aConocimiento',  ChoiceType::class, array(
                'choices'  => array(
                    'CIENCIAS B.' => 'CIENCIAS BASICAS',
                    'INGENIERIA' => 'INGENIERIA',
                    'C. BIOLOG.' => 'CIENCIAS BIOLOGICAS',
                    'C. SALUD' => 'CIENCIAS DE LA SALUD',
                    'C. SOC.' => 'CIENCIAS SOCIALES',
                    'C. ECO. ADMIN.' => 'CIENCIAS ECONÓMICO ADMINISTRATIVAS',
                    'HUMANIDADES' => 'HUMANIDADES',
                ),'placeholder' => '--SELECCIONE--',
                'empty_data'  => null))
            ->add('disciplina')
            ->add('requisitos')
            ->add('fechaIn', DateType::class, array(
                'format' => 'dd-MM-yyyy',
                'years'=>range(date('Y'),date('Y')+4),
            ))
            ->add('fechaTer', DateType::class, array(
                'format' => 'dd-MM-yyyy',
                'years'=>range(date('Y'),date('Y')+4),
            ))
            ->add('tpHclase')
            ->add('tpHacademia')
            ->add('tpHayudantia')
            ->add('clavePlaza')
            
            ->add('dictamen',HiddenType::class)
            ->addEventSubscriber(new AddConcursoAsisDivSubscriber($this->security,$this->em,$this->user))

           // ->add('estatus')
           // ->add('pdfConcurso')
            ->add('numConcurso')

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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

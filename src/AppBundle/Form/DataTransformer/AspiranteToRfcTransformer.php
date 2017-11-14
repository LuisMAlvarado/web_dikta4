<?php
/**
 * Created by PhpStorm.
 * User: luismicoms
 * Date: 18/10/17
 * Time: 15:45
 */

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Aspirante;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AspiranteToRfcTransformer implements DataTransformerInterface
{

    private $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param mixed $aspirante
     * @return string
     *
     */
    public function transform($aspirante)
    {
        // TODO: Implement transform() method.
        if (null ===$aspirante){
            return '';
        }
        return $aspirante->getRfc();

    }

    public function reverseTransform($rfc)
    {
        // TODO: Implement reverseTransform() method.
        if (!$rfc){
            return;
        }

        $aspirante =$this->manager->getRepository('AppBundle:Aspirante')->find($rfc);

        if (null=== $aspirante){

             throw new TransformationFailedException(sprintf('EL RFC "%s" no se encuentra en la Base de Datos',$rfc));

        }

        return $aspirante;

    }

}
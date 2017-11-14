<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


class AspiranteRepository extends EntityRepository
{

    /**
     * @param $roleId
     * @return array
     *
     */
    public function findRoleId($roleId)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT c FROM AppBundle:Role c
           WHERE c.id = :id'
            )->setParameter('id', $roleId);
        return $query->getResult();
    }


    public function findByEnable($estadoenable)

    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT a FROM AppBundle:Aspirante a
           
          WHERE a.enable = :estadoenable
           
          ORDER BY a.createAt DESC'
            )->setParameter('estadoenable', $estadoenable);

        return $query->getResult();
    }

    /**
     * consulta el RFC que se envia para ser escrito en AJAX
     * @param $rfc_consult
     * @return array
     *
     */
    public function getArrayByRfcNombre($rfc_consult)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT rc.rfc AS rfc, CONCAT(rc.nombre, ' ', rc.apellidoPaterno, ' ', CASE WHEN rc.apellidoMaterno IS NULL THEN '' ELSE rc.apellidoMaterno END) AS nombre
                    FROM AppBundle:Aspirante rc
                     WHERE rc.rfc = :rfc_c     
         "
            )->setParameter('rfc_c', $rfc_consult);
        try {
            return $query->getArrayResult();
        } catch (NoResultException $e){
            return null;
        }
    }



}
<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archivo;
use AppBundle\Entity\Aspirante;
use AppBundle\Entity\Concurso;
use FPDM\FPDM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Aspirante controller.
 *
 * @Route("aspirante")
 */
class AspiranteController extends Controller
{
    /**
     * Lists all aspirante entities.
     *
     * @Route("/", name="aspirante_index")
     * @Method("GET")
     * @security("has_role('ROLE_ADMINISTRADOR') or has_role('ROLE_ASISTENTEDIV')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->isGranted('ROLE_ADMINISTRADOR')){
            $aspirantes = $em->getRepository('AppBundle:Aspirante')->findAll();
        }
    elseif ($this->isGranted('ROLE_ASISTENTEDIV')) {
        //  $concursos = $repository->findBy HAY QUE GENERAR EL ARREGLO PARA QUE DESPLIEGE LOS allConcursos DEL USUARIO
        $estadoenable = 0 ;
    $aspirantes = $this->getDoctrine()->getRepository('AppBundle:Aspirante')->findByEnable($estadoenable);
    }


        return $this->render('aspirante/index.html.twig', array(
            'aspirantes' => $aspirantes,
        ));
    }

    /**
     * Creates a new aspirante entity.
     *
     * @Route("/new", name="aspirante_new")
     * @Method({"GET", "POST"})
     * @security("has_role('ROLE_ASPIRANTE_CREATE')")

     */
    public function newAction(Request $request)
    {
        $aspirante = new Aspirante();
        $roleId = 5;
        $role = $this->getDoctrine()->getRepository('AppBundle:Role')->find($roleId);
        $aspirante ->setRole($role);
        if ($this->isGranted('ROLE_ASISTENTEDIV')) {
            $enableasp = true;
            $aspirante->setEnable($enableasp);
        }
        $form = $this->createForm('AppBundle\Form\AspiranteType', $aspirante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Líneas agregadas por el usuario

            $salt = md5(time());

            $encoder = $this->get('security.encoder_factory')->getEncoder($aspirante);
            $passwordCodificado = $encoder->encodePassword(
                $form->getData()->getPassword(),
                $salt
            );
            $form->getdata()->setPassword($passwordCodificado);
            $form->getdata()->setSalt($salt);
            $fnac=$form->getData()->getFechaBirthday()->format('Y-m-d');

            $fecha = time() - strtotime($fnac);
            $edad = floor($fecha / 31556926);
            //dump($edad);exit();
            $aspirante->setEdad($edad);

            // Hasta aquí llegan las líneas agregadas

            $em->persist($aspirante);
            $em->flush($aspirante);

            return $this->redirectToRoute('aspirante_show', array('id' => $aspirante->getRfc()));
        }

        return $this->render('aspirante/new.html.twig', array(
            'aspirante' => $aspirante,
            'form' => $form->createView(),
        ));
    }

    /**
     * contralador que busca al aspirante por RFC
     * @Route("/consulta/aspirante/{concurso}", name="rfc_consulta")
     * @Method("GET")
     *
     */

    public function getArrayByRfcNombre(Request $request, Concurso $concurso)
    {

        $auxrfc = '';
        //$auxrfc = 'LUKE123456';
        //$auxrfc = 'AAAPL741215';

        if($request->query->get('auxrfc'))
        {
            $auxrfc = $request->query->get('auxrfc');
        }


        $em = $this->getDoctrine();
        $aspirante = $em->getRepository('AppBundle:Aspirante')->getArrayByRfcNombre($auxrfc);

        //(var_dump($aspirante);exit();



        if (!$aspirante){
            $aspirante=array('nombre'=>'EL RFC QUE INGRESO NO EXISTE EN LA BASE DE DATOS','rfc'=>'2');
         }else{
            $registro = $em->getRepository('AppBundle:Registro')->findOneBy(array(
                'aspiranteRfc' => $auxrfc,
                'concurso' => $concurso,
            ));
            if ($registro) {
                $aspirante=array('nombre'=>'ASPIRANTE YA REGISTRADO, [BORRAR] ESTE REGISTRO -->','rfc'=> '1');
            }else {
                $aspirante = $aspirante[0];
            }
        }

        //var_dump($aspirante);exit();


        $reponse = new JsonResponse($aspirante);

        return $reponse;
    }



    /**
     * Crear un PRE - new aspirante entity.
     *
     * @Route("/prenew", name="aspirante_prenew")
     * @Method({"GET", "POST"})

     */
    public function prenewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $aspirante = new Aspirante();
        //$copEstudios = new Archivo();
        //$identificacion = new Archivo();
        //$aspirante->addArchivo($copEstudios);
        //$aspirante->addArchivo($identificacion);
        $roleId = 5;
        $role = $this->getDoctrine()->getRepository('AppBundle:Role')->find($roleId);
        $aspirante ->setRole($role);
        $form = $this->createForm('AppBundle\Form\AspirantePreType', $aspirante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Líneas agregadas por el usuario

            $salt = md5(time());

            $encoder = $this->get('security.encoder_factory')->getEncoder($aspirante);
            $passwordCodificado = $encoder->encodePassword(
                $form->getData()->getPassword(),
                $salt
            );
            $form->getdata()->setPassword($passwordCodificado);
            $form->getdata()->setSalt($salt);
            $fnac=$form->getData()->getFechaBirthday()->format('Y-m-d');

            $fecha = time() - strtotime($fnac);
            $edad = floor($fecha / 31556926);
            //dump($edad);exit();
            $aspirante->setEdad($edad);

            // Hasta aquí llegan las líneas agregadas

            $em->persist($aspirante);
            $em->flush($aspirante);

            return $this->redirectToRoute('preaspirante_show', array('id' => $aspirante->getRfc()));
        }

        return $this->render('aspirante/prenew.html.twig', array(
            'aspirante' => $aspirante,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a aspirante entity.
     *
     * @Route("/prenew/{id}", name="preaspirante_show")
     * @Method("GET")
     *
     */
    public function preshowAction(Aspirante $aspirante)
    {
        $deleteForm = $this->createDeleteForm($aspirante);

        return $this->render('aspirante/preshow.html.twig', array(
            'aspirante' => $aspirante,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Finds and genera PDFs a Concurso entity.
     *
     * @Route("/prenew/{id}/prepdf", name="preasp_showpdfs")
     * @Method("GET")
     */
    public function showpdfsAction(Aspirante $aspirante)
    {

        /**return $this->render('aspirante/pdfpreshow.html.twig', array(
            'aspirante' => $aspirante,

        ));
        */

        $html = $this->renderView('aspirante/pdfpreshow.html.twig', array(
            'aspirante' => $aspirante,

        ));

        // set style for barcode
        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

// QRCODE,L : QR-CODE Low error correction


        $pdfObj = $this->get("white_october.tcpdf")->create();
        $pdfObj->setPrintHeader(false);
        $pdfObj->setPrintFooter(false);
        $pdfObj->SetAuthor('LuisM-Dictaminadora');
        $pdfObj->SetTitle('preAspirante_' . $aspirante->getRfc());
        $pdfObj->SetFont('helvetica', '', 7);
        $pdfObj->AddPage('P', 'mm', 'Letter');
        $pdfObj->Image(__DIR__.'/../../../web/resource/img/encabezadopre.jpg',10,10,0,15,'JPG','','N');
        $pdfObj->writeHTML($html, true, true, true, false, '');

        //$pdfObj->write2DBarcode('https://siipi.izt.uam.mx/dictaminadoras/aspirante/'.$aspirante->getRfc(), 'QRCODE,Q', 130, 100, 30, 30, $style, 'N');
        $pdfObj->write2DBarcode('http://localhost:8000/aspirante/'.$aspirante->getRfc(), 'QRCODE,Q', 130, 100, 30, 30, $style, 'N');

        $pdfObj->Text(130, 130, 'CODIGO DEL '.$aspirante->getRfc());
     //   $pdfObj->AddPage('P', 'mm', 'Letter');
       // $pdfObj->writeHTML($html2, true, true, true, false, '');
        // $y1=$pdfObj->GetY()-50;
        //  $pdfObj->writeHTMLCell(194, '', 6, 90, $html2, 0, 1, 0, true, 'L', true);

        $pdfObj->Output('preAspirante_'.$aspirante->getRfc().'.pdf', 'I');

    }

    /**
     * Finds and displays a aspirante entity.
     *
     * @Route("/{id}", name="aspirante_show")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMINISTRADOR') or has_role('ROLE_ASISTENTEDIV') ")
     */
    public function showAction(Aspirante $aspirante)
    {
        $deleteForm = $this->createDeleteForm($aspirante);

        return $this->render('aspirante/show.html.twig', array(
            'aspirante' => $aspirante,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Aspirante entity.
     *
     * @Route("/asp/{id}", name="aspirante_aspshow")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMINISTRADOR') or (user.getRfc() == aspirante.getRfc()) ")
     */
    public function aspshowAction(Aspirante $aspirante)
    {
        $deleteForm = $this->createDeleteForm($aspirante);

        return $this->render('aspirante/aspshow.html.twig', array(
            'aspirante' => $aspirante,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing aspirante entity.
     *
     * @Route("/{id}/edit", name="aspirante_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMINISTRADOR')or has_role('ROLE_ASISTENTEDIV') or (has_role('ROLE_ASPIRANTE_UPDATE') and user.getRfc() == aspirante.getRfc()) ")
     */
    public function editAction(Request $request, Aspirante $aspirante)
    {
        $em = $this->getDoctrine()->getManager();
        $passwordOriginal = $aspirante->getPassword();
        $deleteForm = $this->createDeleteForm($aspirante);
        $editForm = $this->createForm('AppBundle\Form\AspiranteType', $aspirante);
        $editForm->handleRequest($request);
        $roleId = 5;
        $role = $this->getDoctrine()->getRepository('AppBundle:Role')->find($roleId);
        $aspirante->setRole($role);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$this->getDoctrine()->getManager()->flush();
            
            // Líneas agregadas para la codificación del password
            if (null == $editForm->getData()->getPassword()) {
                $editForm->getData()->setPassword($passwordOriginal);
            } else {
                $salt = md5(time());


                $encoder = $this->get('security.encoder_factory')->getEncoder($aspirante);
                $passwordCodificado = $encoder->encodePassword(
                    $editForm->getData()->getPassword(),
                    $salt
                );
                $editForm->getdata()->setPassword($passwordCodificado);
                $editForm->getdata()->setSalt($salt);
                // $editForm->getdata()->setRole($role);
            }
            // Aquí terminan las líneas agregadas
            
            $em->persist($aspirante);
            $em->flush();

//AQUI PORN LA CONDICION SI ES ASPIRANTE o NO!!! para enviarlo al ASPSHOW!!!!
            if ($this->isGranted('ROLE_ASPIRANTE')) {
                return $this->redirectToRoute('aspirante_aspshow', array('id' => $aspirante->getRfc()));
            } else {
                return $this->redirectToRoute('aspirante_show', array('id' => $aspirante->getRfc()));

            }
            
        }

        return $this->render('aspirante/edit.html.twig', array(
            'aspirante' => $aspirante,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * @Route("/{aspirante}/enable/", name="aspirante_enable")
     *
     *
     * @Method({"GET", "POST"})
     *
     */

    public function enableAspAction(Request $request, Aspirante $aspirante)// SE USA JUNTO CON EL @rotue {"propiedad"} y en conjunto con el twig cuando pasas Ruta(Controlador) pasas a la funcion esa Entidad
    {


        //$newestatus = $this->getDoctrine()->getRepository('AppBundle:Estatus')->find($nest);
        //Estatus::"nombre_variable" definida en ENTIDAD en este caso Estatus
        $enableasp = true;
        $aspirante ->setEnable($enableasp);

        $em = $this->getDoctrine()->getManager();
        $em->persist($aspirante);
        $em->flush($aspirante);
        return $this->redirectToRoute('aspirante_show', array('id' => $aspirante->getRfc()));

        /**QUITO ESTO PARA QUE ENVIE DIRECTO AL CAMBIO
         * $form = $this->createForm('AppBundle\Form\ConcursoType', $reconcurso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($reconcurso);
        $em->flush($reconcurso);

        return $this->redirectToRoute('concurso_show', array('id' => $reconcurso->getId()));
        }

        return $this->render('concurso/new.html.twig', array(
        'concurso' => $reconcurso,
        'form' => $form->createView(),
        )); */

    }

    /**
     *
     * @Route("/{id}/Medicard", name="medicard_pdf")
     * @Method({"GET", "POST"})
     */
    public function pdfFRAspAction(Request $request, Aspirante $aspirante)
    {


        //$clasificacion = $concurso->getClasificacion();
        //var_dump($clasificacion);exit();
        $fields = array(
            'Nombre' => $aspirante->getNombreCompleto() ,
            'No'=>$aspirante->getRfc(),


        );
        /*
                foreach ($concurso->getRegistros() as $i => $registro)
                {
                    $fields['aspirante_'.$i] = $registro->getAspiranteRfc()->getNombreCompleto();
                }
        */
        //       dump($fields); exit();
        $pdf = new FPDM(__DIR__."/../../../formatosPDF/TARJETAE.pdf");

        //$pdf = new FPDM(__DIR__."/../../../formatosPDF/solregAsp.pdf");
        $pdf->Load($fields, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8

        $pdf->Merge();
       // $nombre=preg_replace('/\./', '', $aspi->getRfc().'_'.$concurso->getNumConcurso());
        // $pdf->Output($nombre.'.pdf', 'I');
        $pdf->Output($aspirante->getNombre().'.pdf', 'I');
    }



    /**
     * Deletes a aspirante entity.
     *
     * @Route("/{id}", name="aspirante_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Aspirante $aspirante)
    {
        $form = $this->createDeleteForm($aspirante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aspirante);
            $em->flush($aspirante);
        }

        return $this->redirectToRoute('aspirante_index');
    }

    /**
     * Creates a form to delete a aspirante entity.
     *
     * @param Aspirante $aspirante The aspirante entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Aspirante $aspirante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aspirante_delete', array('id' => $aspirante->getRfc())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

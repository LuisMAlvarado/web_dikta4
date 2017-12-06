<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dictamen;
use AppBundle\Entity\Concurso;
use FPDM\FPDM;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;

/**
 * Dictamen controller.
 *
 * @Route("dictamen")
 */
class DictamenController extends Controller
{
    /**
     * Lists all Dictamen entities.
     *
     * @Route("/", name="dictamen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


       if ($this->isGranted(new Expression('"ROLE_ADMINSTRADOR" in roles'))){
           $dictamens = $em->getRepository('AppBundle:Dictamen')->findAll();
       }
       elseif ($this->isGranted(new Expression('"ROLE_DICTAMINADOR" in roles or "ROLE_ASISTENTEDIV" in roles '))) {
           $dictamens=$em->getRepository('AppBundle:Dictamen')->AllporDiv($this->getUser()->getDivision()->getId());
       }

       elseif ($this->isGranted(new Expression('"ROLE_ASISTENTEDEP" in roles '))) {
           $dictamens=$em->getRepository('AppBundle:Dictamen')->AllporDep($this->getUser()->getDepartamento()->getId());
       }
        return $this->render('dictamen/index.html.twig', array(
            'dictamens' => $dictamens,
        ));
    }

    /**
     * Creates a new Dictamen entity.
     *
     * @Route("/new", name="dictamen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        if ($this->isGranted(new Expression(' "ROLE_DICTAMINADOR" in roles'))) {
            $dictaman = new Dictamen();
            $idc = $request->query->get('id');
            $concurso = $em->getRepository('AppBundle:Concurso')->find($idc);
            $idDivconcurso= $concurso->getDepartamento()->getDivision();
            $prefilldic=$em->getRepository('AppBundle:PrefullDictamen')->findBy(array('division'=> $idDivconcurso));
            $prefilldic = $prefilldic[0];
            //var_dump($prefilldic);exit();

            if($concurso->getDictamen() != null ){
                return $this->redirectToRoute('dictamen_show', array('id' => $concurso->getDictamen()->getId()));
            }
           //INICIA EL PRELLENADO DEL DICTAMEN
            $presidente=$prefilldic->getNombreCompletoPres();
            $secretario =$prefilldic->getNombreCompletoSec();
            $asesor1 =$prefilldic->getAsesor1();
            $asesor2 =$prefilldic->getAsesor2();
            $asesor3 =$prefilldic->getAsesor3();
            $asesor4 =$prefilldic->getAsesor4();
            $asesor5 =$prefilldic->getAsesor5();
            $asesor6 =$prefilldic->getAsesor6();
            $evaluaciones=$prefilldic->getEvaluaciones();
            $argumento=$prefilldic->getArgumento();
            //var_dump($asesor1,$asesor2,$asesor3,$asesor4,$asesor5,$asesor6);exit();
            $dictaman->setPresidente($presidente);
            $dictaman->setSecretario($secretario);
            $dictaman->setAsesor1($asesor1);
            $dictaman->setAsesor2($asesor2);
            $dictaman->setAsesor3($asesor3);
            $dictaman->setAsesor4($asesor4);
            $dictaman->setAsesor5($asesor5);
            $dictaman->setAsesor6($asesor6);
            $dictaman->setModalidades($evaluaciones);
            $dictaman->setArgumento($argumento);
           // $dictaman->setConcurso($concurso);
            $concurso->setDictamen($dictaman);
        }else{
            return $this->createAccessDeniedException();
        }

       // $form = $this->createForm('AppBundle\Form\DictamenType', $dictaman); QUITO DICTAMEN e embebo A CONCURSO
        $form = $this->createForm('AppBundle\Form\ConcursoDictamenType', $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($concurso); //Borra1
            $em->flush(); //Borra2
            //$em->persist($dictaman); P1
            //$em->flush($dictaman); P2

            return $this->redirectToRoute('dictamen_show', array('id' => $dictaman->getId()));
        }

        return $this->render('dictamen/new.html.twig', array(
            'dictaman' => $dictaman,
            'concurso' => $concurso,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/FDictamenpdf", name="FDictamen_pdf")
     *
     */

    public function pdfFRAspsAction(Dictamen $dictaman)
    {
        $concurso=$dictaman->getConcurso();
        $registros=$concurso->getRegistros();
        $Regs= $concurso->getGanador();

      // dump($ganador);exit();

        $fields = array(
            'clasificacion'=>$concurso->getClasificacion()->getNombre(),
            'tiempoDedicacion'=>$concurso->getTiempoDedicacion()->getNombre(),
            'numDictamen'=>$concurso->getDictamen()->getNumDictamen(),
            'fechaDictmenDIA'=>$dictaman->getFechaDictmen()->format('d'),
            'fechaDictmenMES'=>$dictaman->getFechaDictmen()->format('m'),
            'fechaDictmenANIO'=>$dictaman->getFechaDictmen()->format('Y'),
            'divCOM'=>$concurso->getDepartamento()->getDivision()->getNombre(),
            'divDIR'=>$concurso->getDepartamento()->getDivision()->getNombre(),
            'numConcurso'=> 'EC.'.$concurso->getNumConcurso(),
            'fechaPublicacion'=>$concurso->getFechaPublicacion()->format('d - m - Y'),

         //   'pre_0'=> $ganador->getApellidoPaterno().' '.$ganador->getApellidoMaterno().' '.$ganador->getNombre(),
         //   'nivpre_0'=>$concurso->getClasificacion()->getNombre().'   NIVEL  '.$Regs->getNivelAsig(),

            'unidad'=>$concurso->getUnidad(),
            'division'=>$concurso->getDepartamento()->getDivision()->getNombre(),
            'departamento'=>mb_strtoupper($concurso->getDepartamento()->getNombre(),"UTF-8"),
            'areaDepartamental'=>$concurso->getAreaDepartamental(),

            'modalidades'=>$dictaman->getModalidades(),
            'argumento1'=>$dictaman->getArgumento(),
            'asesores_1'=>$dictaman->getAsesor1(),
            'asesores_2'=>$dictaman->getAsesor2(),
            'asesores_3'=>$dictaman->getAsesor3(),
            'asesores_4'=>$dictaman->getAsesor4(),
            'asesores_5'=>$dictaman->getAsesor5(),
            'asesores_6'=>$dictaman->getAsesor6(),
            'presidenteCOM'=>$dictaman->getPresidente(),
            'secretarioCOM'=>$dictaman->getSecretario(),
            'presidenteCOM2'=>$dictaman->getPresidente(),
            'secretarioCOM2'=>$dictaman->getSecretario(),
            'clasificacion2'=>$concurso->getClasificacion()->getNombre(),
            'numDictamen2'=>$concurso->getDictamen()->getNumDictamen(),
            'fechaDictmenDIA2'=>$dictaman->getFechaDictmen()->format('d'),
            'fechaDictmenMES2'=>$dictaman->getFechaDictmen()->format('m'),
            'fechaDictmenANIO2'=>$dictaman->getFechaDictmen()->format('Y'),

        );
        if($Regs==null){
            $fields['pre_0']='DESIERTA';
            $fields['nivpre_0']=$concurso->getClasificacion()->getAbreviacion().'  '.$concurso->getCategoria()->getAbreviacion();
        }

        if($Regs!= null){
            $ganador= $concurso->getGanador()->getAspiranteRfc();

           // $fields[pre_0]=2;
            $fields['pre_0']=$ganador->getApellidoPaterno().' '.$ganador->getApellidoMaterno().' '.$ganador->getNombre();
            $fields['nivpre_'.$Regs->getPrelacion()]=$concurso->getClasificacion()->getAbreviacion().'  '.$concurso->getCategoria()->getAbreviacion().'  '.$concurso->getGanador()->getNivelAsig();
        }



        foreach ($registros as $regis )
        {
            if($regis->getPrelacion()==0) {continue;}
            $fields['pre_'.$regis->getPrelacion()]=$regis->getAspiranteRfc()->getNombreCompleto();
            $fields['nivpre_'.$regis->getPrelacion()]=$regis->getNivelAsig();
        }
      //  dump($fields);exit();

        foreach ($registros as $i => $registro)
        {
            $fields['asp_'.$i] = $registro->getAspiranteRfc()->getNombreCompleto();
        }

      //  dump($fields);exit();
        $pdf = new FPDM(__DIR__."/../../../formatosPDF/dictamen.pdf");
        $pdf->Load($fields, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        $pdf->Merge();
        $nombre=preg_replace('/\./', '', 'DICTAMEN_'.$concurso->getDictamen()->getNumDictamen());
        $pdf->Output($nombre.'.pdf', 'D');
    }






    /**
     * Finds and displays a Dictamen entity.
     *
     * @Route("/{id}", name="dictamen_show")
     * @Method("GET")
     */
    public function showAction(Dictamen $dictaman)
    {
        $deleteForm = $this->createDeleteForm($dictaman);
        $concur=$dictaman->getConcurso();
        $registros=$concur->getRegistros();

        return $this->render('dictamen/show.html.twig', array(
            'dictaman' => $dictaman,
            'delete_form' => $deleteForm->createView(),
            'concurso' =>$concur,
            'registros' =>$registros,
        ));
    }

    /**
     * Displays a form to edit an existing Dictamen entity.
     *
     * @Route("/{id}/edit", name="dictamen_edit")
     * @Method({"GET", "POST"})
     *
     * @Security(" (dictaman.getConcurso().getEstatus().getId() == 5) and (has_role('ROLE_DICTAMEN_UPDATE') or has_role('ROLE_ADMINISTRADOR'))")
     */

    public function editAction(Request $request, Dictamen $dictaman)
    {
        $deleteForm = $this->createDeleteForm($dictaman);
        $concurso=$dictaman->getConcurso();
        $editForm = $this->createForm('AppBundle\Form\ConcursoDictamenType', $concurso);

        //$editForm = $this->createForm('AppBundle\Form\DictamenType', $dictaman);
        $editForm->handleRequest($request);
         $argumentopre= $dictaman->getArgumento();
        $concurso=$dictaman->getConcurso();

       /**INTENTO IMPRIMIR LOS NOMBRE DEL GANADOR Y LOS NO CUMPLEN EN EL ARGUMENTO
       $registros=$concurso->getRegistros();
       $ganador= $concurso->getGanador();
        if($ganador!= null) {
            $prelado0 = $concurso->getGanador()->getAspiranteRfc()->getNombreCompleto();
            $argumentopre=$argumentopre."\n".$prelado0."-- SI CUMPLE CON LOS REQUISITOS";
            foreach ($registros as $registro) {
                if ( empty($registro->getPrelacion()) ) {

                    $argumentopre=$argumentopre."\n".$registro->getAspiranteRfc()->getNombreCompleto()." -- NO CUMPLE CON LOS REQUISITOS";
                }
            }


        } elseif ($ganador == null){

            foreach ($registros as $registro) {
                if ($registro->getPrelacion() == null) {

                    $argumentopre=$argumentopre."\n".$registro->getAspiranteRfc()->getNombreCompleto()." -- NO CUMPLE CON LOS REQUISITOS";
                }
            }

        }

         //var_dump($argumentopre);exit();
         $dictaman->setArgumento($argumentopre);
        */

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dictamen_show', array('id' => $dictaman->getId()));
        }

        return $this->render('dictamen/edit.html.twig', array(
            'dictaman' => $dictaman,
            'concurso' => $concurso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Dictamen entity.
     *
     * @Route("/{id}", name="dictamen_delete")
     * @Method("DELETE")
     * @Security(" (dictaman.getConcurso().getEstatus().getId() == 5) and (has_role('ROLE_DICTAMEN_DELETE') or has_role('ROLE_ADMINISTRADOR'))")
     */


    public function deleteAction(Request $request, Dictamen $dictaman)
    {
        $form = $this->createDeleteForm($dictaman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dictaman);
            $em->flush($dictaman);
        }

        return $this->redirectToRoute('dictamen_index');
    }

    /**
     * Creates a form to delete a dictaman entity.
     *
     * @param Dictamen $dictaman The Dictamen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dictamen $dictaman)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dictamen_delete', array('id' => $dictaman->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

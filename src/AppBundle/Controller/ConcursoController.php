<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Concurso;
use AppBundle\Entity\Registro;
use AppBundle\Entity\Division;
use AppBundle\Entity\Estatus;
use Doctrine\ORM\Mapping\Id;
use FPDM\FPDM;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\ExpressionLanguage\Expression;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Form\ConcursoType;
use Symfony\Component\Validator\Constraints\IsNull;

/**
 * Concurso controller.
 *
 * @Route("concurso")
 */
class ConcursoController extends Controller
{
    /**
     * Lists all concurso entities.
     *
     * @Route("/", name="concurso_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $cadena = '';

        if($request->query->get('cadena'))
        {
            $cadena = $request->query->get('cadena');
        }

        $em = $this->getDoctrine()->getManager();
        $divisiones=$em->getRepository('AppBundle:Division')->findBy(array('id'=>array(2,3,4)));

        $aspi=$this->getUser(); //para el caso aspirante

        if ($this->isGranted(new Expression(' "ROLE_ADMINISTRADOR" in roles'))) {
            $dato=(new \DateTime());
            $concursos= $em->getRepository('AppBundle:Concurso')->findAllOrderedByFecha($dato);
        } elseif ($this->isGranted('ROLE_ASPIRANTE')){
            $dato=(new \DateTime());
            $estp=3;
            $rfc1=$aspi->getRfc();
            // $concursos= $em->getRepository('AppBundle:Concurso')->findAllOrderedBynoReg($dato,$rfc1);

            $concursos= null; //$em->getRepository('AppBundle:Concurso')->searchCECporAspSinRegistro($cadena,$estp,$rfc1);

            //dump($concursos); exit();
            //$concursos= $em->getRepository('AppBundle:Concurso')->PublicadonoReg($estp,$rfc1);
            //se debe generar una consulta usando un comparador ArrayCollect

            //$concursos= $em->getRepository('AppBundle:Concurso')->findAllOrderedBynoReg($dato,$rfc1);

        } elseif ($this->isGranted('ROLE_DICTAMINADOR')){
            $mdic=4;
            $concursos= $em->getRepository('AppBundle:Concurso')->EstadoMayorQue($this->getUser()->getDivision()->getId(),$mdic);
        } elseif ($this->isGranted('ROLE_ASISTENTEDEP')) {
            //  $concursos = $repository->findBy HAY QUE GENERAR EL ARREGLO PARA QUE DESPLIEGE LOS allConcursos DEL USUARIO
            // $concursos = $this->getDoctrine()->getRepository('AppBundle:Concurso')->findAllOrderedById2($this->getUser()->getDepartamento()->getId());
            $concursos = $em->getRepository('AppBundle:Concurso')->searchCECporDepto($cadena,$this->getUser()->getDepartamento()->getId());

        } elseif ($this->isGranted('ROLE_ASISTENTEDIV')) {
            //  $concursos = $repository->findBy HAY QUE GENERAR EL ARREGLO PARA QUE DESPLIEGE LOS allConcursos DEL USUARIO


            //var_dump($cadena);exit();

            $concursos = $em->getRepository('AppBundle:Concurso')->search($cadena,$this->getUser()->getDivision()->getId());



            // $concursos = $this->getDoctrine()->getRepository('AppBundle:Concurso')->findAllOrderedById($this->getUser()->getDivision()->getId());

            //PARA USO DEL ESTATUS
            // $edo='2';
            // $concursos = $this->getDoctrine()->getRepository('AppBundle:Concurso')->findAllOrderedByIdxedo($this->getUser()->getDivision()->getId(),$edo);
        }

//EL CONTROLADOR ENVIA AL ASPIRANTE LOS CONCURSOS QUE TIENE EN ESTADO 3=PUBLICADO Y NO TIENE REGISTRO
        //ANTES RENDERISABA A portada.html.twig
        if ($this->isGranted(new Expression(' "ROLE_ASPIRANTE" in roles'))){
            return $this->render('concurso/portada2.html.twig', array(
                'concursos' => $concursos,
                'aspirante'=>$aspi,
                'est' => 10,
                'cadena' => $cadena,
                'divisiones' => $divisiones,
            ));
        }


        return $this->render('concurso/index.html.twig', array(
            'concursos' => $concursos,
            'cadena'=>$cadena,
            'est' => 10,
            'divisiones' => $divisiones,

        ));
    }

    


    /**
     * @Route("/formPDF", name="form_pdf")
     */
    public function formFPDMAction()
    {

        $fields= array(
            'name'    => 'My name',
            'address' => 'My address',
            'city'    => 'My city',
            'phone'   => 'My phone number',

        );

        $pdf = new FPDM(__DIR__."/../../../formulariosPDF/template.pdf");
        $pdf->Load($fields,true);
        $pdf->Merge();
        $pdf->Output('lmap2.pdf','D');
    }

    /**
     * LISTA LOS ESTADOS 3 publicacion SEGUN LA DIVISION Y EL DEPA
     *
     * @Route("/publi_format/div/{div}/dep/{dep}", name="concurso_formatop")
     * @Method("GET")
     */
    public function concursoFormatoAction($div,$dep)
    {
        $em = $this->getDoctrine()->getManager();
        $estp =3;
        if ($div== empty(trim($div))){
            $concursop= $em->getRepository('AppBundle:Concurso')->EstadoPublicado($estp);
            return $this->render('concurso/fconcursos.html.twig', array(
                'concursos' => $concursop,

            ));
        }
       // $div=null;
       // $dep=null;
        elseif($div !=empty(trim($div)) && empty(trim($dep))) {
        $concursop= $em->getRepository('AppBundle:Concurso')->EstadoPublicadoDiv($estp,$div);
        return $this->render('concurso/fconcursos.html.twig', array(
            'concursos' => $concursop,

        ));
        }
        elseif($div !=empty(trim($div)) && $dep !=empty(trim($dep))) {
            $concursop= $em->getRepository('AppBundle:Concurso')->EstadoPublicadoDivDep($estp,$dep);
            return $this->render('concurso/fconcursos.html.twig', array(
                'concursos' => $concursop,

            ));
        }

    }

    /**
     * LISTA LOS ESTADOS 3 publicacion SEGUN LA DIVISION Y EL DEPA
     * SIN REGISTRO DEL ASPIRANTE FIRMADO
     *
     * @Route("/publi_Aspformat/div/{div}/dep/{dep}", name="concursoAsp_formatop")
     * @Method("GET")
     */
    public function concursoAspFormatoAction($div,$dep)
    {
        $em = $this->getDoctrine()->getManager();
        $estp =3;
        $aspi=$this->getUser()->getRfc();



        if ($div== empty(trim($div))){
            $concursop= $em->getRepository('AppBundle:Concurso')->EstadoPublicadoAsp($estp,$aspi);
            return $this->render('concurso/fconcursos.html.twig', array(
                'concursos' => $concursop,

            ));
        }
        // $div=null;
        // $dep=null;
        elseif($div !=empty(trim($div)) && empty(trim($dep))) {
            $concursop= $em->getRepository('AppBundle:Concurso')->EstadoPublicadoDivAsp($estp,$div,$aspi);
            return $this->render('concurso/fconcursos.html.twig', array(
                'concursos' => $concursop,

            ));
        }
        elseif($div !=empty(trim($div)) && $dep !=empty(trim($dep))) {
            $concursop= $em->getRepository('AppBundle:Concurso')->EstadoPublicadoDivDepAsp($estp,$dep,$aspi);
            return $this->render('concurso/fconcursos.html.twig', array(
                'concursos' => $concursop,

            ));
        }

    }

    /**
     * @Route("/publi_format/search/div/{id}", name="depto_search")
     * @Method("GET")
     *
     */

    public function searchDeptosAction(Division $division)
    {
        $em = $this->getDoctrine();
        $departamentos = $em->getRepository('AppBundle:Departamento')->getByDivisionIdArray($division->getId());

        $reponse = new JsonResponse($departamentos);

        return $reponse;
    }

    /**
     * Lists all concurso entities segun el estado
     *
     * @Route("/est/{est}", name="concurso_indexest")
     * @Method("GET")
     */
    public function indexestAction($est, Request $request)
    {


        $cadena = '';

        if($request->query->get('cadena'))
        {
            $cadena = $request->query->get('cadena');
        }
        $em = $this->getDoctrine()->getManager();

        $aspi=$this->getUser(); //para el caso aspirante

        if ($this->isGranted(new Expression(' "ROLE_ADMINISTRADOR" in roles'))) {
            $dato=(new \DateTime());
            $concursos= $em->getRepository('AppBundle:Concurso')->findAllOrderedByFecha($dato);
        }
        elseif ($this->isGranted('ROLE_ASPIRANTE')){
            $dato=(new \DateTime());
            //$estp=3;
            //se debe generar una consulta usando un comparador ArrayCollect
            $rfc1=$aspi->getRfc();
           $concursos= $em->getRepository('AppBundle:Concurso')->findAllOrderedBynoReg($dato,$rfc1);
            //$concursos= $em->getRepository('AppBundle:Concurso')->findAllOrderedBynoReg($estp,$rfc1);

        }

        elseif ($this->isGranted('ROLE_DICTAMINADOR')){
            // $concursos= $em->getRepository('AppBundle:Concurso')->TodosEstado($this->getUser()->getDivision()->getId(),$est);
            $concursos= $em->getRepository('AppBundle:Concurso')->EdoNoImportaDictamen($this->getUser()->getDivision()->getId(),$est);
        }
        elseif ($this->isGranted('ROLE_ASISTENTEDEP')) {
            //  $concursos = $repository->findBy HAY QUE GENERAR EL ARREGLO PARA QUE DESPLIEGE LOS allConcursos DEL USUARIO
            $concursos = $this->getDoctrine()->getRepository('AppBundle:Concurso')->EstxDepto($this->getUser()->getDepartamento()->getId(),$est);
        }
        elseif ($this->isGranted('ROLE_ASISTENTEDIV')) {
            //  $concursos = $repository->findBy HAY QUE GENERAR EL ARREGLO PARA QUE DESPLIEGE LOS allConcursos DEL USUARIO

            //$est=3;
            $concursos = $this->getDoctrine()->getRepository('AppBundle:Concurso')->TodosEstado($this->getUser()->getDivision()->getId(),$est);

            //PARA USO DEL ESTATUS
            // $edo='2';
            // $concursos = $this->getDoctrine()->getRepository('AppBundle:Concurso')->findAllOrderedByIdxedo($this->getUser()->getDivision()->getId(),$edo);
        }

        if ($this->isGranted(new Expression(' "ROLE_ASPIRANTE" in roles'))){
            return $this->render('concurso/portada.html.twig', array(
                'concursos' => $concursos,
                'aspirante'=>$aspi,
                'est' => $est,
                'cadena' =>$cadena
            ));
        }


        return $this->render('concurso/index.html.twig', array(
            'concursos' => $concursos,
            'est' => $est,
            'cadena' =>$cadena

        ));
    }



    /**
     * Creates a new concurso entity.
     *
     * @Route("/new", name="concurso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $concurso = new Concurso();
        $newestatus = $this->getDoctrine()->getRepository('AppBundle:Estatus')->find(Estatus::EnRevision); //Estatus::"nombre_variable" definida en ENTIDAD en este caso Estatus
        $concurso ->setEstatus($newestatus);

        if ($this->isGranted(new Expression(' "ROLE_ASISTENTEDEP" in roles'))){

            $asisdiv =$this->getUser()->getDivision()->getId();
            $asisdep1 = $this->getUser()->getDepartamento()->getId();
            $asisdep=$this->getDoctrine()->getRepository('AppBundle:Departamento')->find($asisdep1);
            $concurso->setDepartamento($asisdep);

        }
        $form = $this->createForm('AppBundle\Form\ConcursoType', $concurso);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //obtengo e inserto el valor de clasificacion,categoria,tiempoDedicacion
            $em = $this->getDoctrine()->getManager();
//PRUEBAS
        //    $clasificacionId = $form->getdata()->getClasificacion()->getId();
        //    $categ = $em->getRepository('AppBundle:Clatesal')->getArrayByClasificacionId($clasificacionId) ;
          //  dump($clasificacionId,$categ);exit();
            //COMENTAR LO ANTERIOR

          //  $clatesalS=$em->getRepository('AppBundle:Clatesal')->findOneBy(array(
          //      'clasificacion' => $form->getdata()->getClasificacion()->getId(),
          //      'categoria' => $form->getdata()->getCategoria()->getId(),
          //      'tiempoDedicacion' => $form->getdata()->getTiempoDedicacion()->getId(),
          //  ));

          //  $concurso->setActividades($clatesalS->getActividad());
          //  $concurso->setRequisitos($clatesalS->getRequisitos());
          //  $concurso->setSalarioA((int)$salA=$clatesalS->getSalA());
          //  $concurso->setSalarioB((int)$salB=$clatesalS->getSalB());
            //termina la insercion de Clatesal

            $em->persist($concurso);
            $em->flush($concurso);

            return $this->redirectToRoute('concurso_show', array('id' => $concurso->getId()));
        }
        if ($this->isGranted(new Expression(' "ROLE_ASISTENTEDEP" in roles'))){

            return $this->render('concurso/new.html.twig', array(
                'concurso' => $concurso,
                'form' => $form->createView(),
            ));
        }

        return $this->render('concurso/new.html.twig', array(
            'concurso' => $concurso,
            'form' => $form->createView(),
        ));


    }

    /**
     * Finds and displays a concurso entity.
     *
     * @Route("/{id}", name="concurso_show")
     * @Method("GET")
     */
    public function showAction(Concurso $concurso)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($concurso);
        $dias = $concurso->getFechaIn()->diff($concurso->getFechaTer())->format('%Y AÑOS - %M MESES - %D DÍAS');


        return $this->render('concurso/show.html.twig', array(
            'concurso' => $concurso,
            'delete_form' => $deleteForm->createView(),
            'dias' => $dias,
        ));
    }

    /**
     * Finds and displays a Concurso entity.
     * muestra a los aspirantes que entragaron DOCUMENTOS
     * @Route("/{id}/regs", name="concurso_showreg")
     * @Method("GET")
     */
    public function showregAction(Concurso $concurso)
    {
        // REGISTRO DE ASPIRANTES EN ESTAPA DE PUBLICACION

        $deleteForm = $this->createDeleteForm($concurso);
        return $this->render('concurso/showreg.html.twig', array(
            'concurso' => $concurso,
         //   'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            //   'dias' => $dias,
        ));
    }


    /**
     * @Route("/{concurso}/registrados/", name="concurso_resgistradossalta")
     *
     * @Method({"GET", "POST"})
     *
     */

        //PARA CAMBIAR EL NUMERO DE REGISTRO EN CADA UNO DE LOS REGISTROS DE LOS ASPIRANTES Y FECHA DE ESA ALTA DE REGISTRO DEL CONCURSO
      //en showAspregPub.html.twig recolecta el cambio en DOCs? y agrega el registro en ADD ASPIRANTE

    public function altaRegistradosAction(Request $request, Concurso $concurso)// SE USA JUNTO CON EL @rotue {"propiedad"} y en conjunto con el twig cuando pasas Ruta(Controlador) pasas a la funcion esa Entidad
    {
        $em = $this->getDoctrine()->getManager();
        //$registros = $request->query->get('registros');
        $registros = $concurso->getRegistros();
        //var_dump($registros);exit();
        // $deleteForm = $this->createDeleteForm($concurso);
        //$registros= $concurso->getRegistrosCompletos();//SE DEBE HACER EL INPUT(SELECTOR PALOMITA)URGE ARREGLO LMAP
        //dump($registros); exit();  //   CAMBIAR LA FORMA DE SELECIONAR LOS REGISTROS!!!!!
        $numRegistro='REG.'.$concurso->getNumConcurso();
        $fechaRegistro=new \DateTime('now');
        foreach ($registros as $registro)
        {
            $registro->setNumRegistro($numRegistro);
            $registro->setFechaRegistro($fechaRegistro);

            $em->persist($registro);
        }
        $em->flush();
        // $dias = $concurso->getFechaIn()->diff($concurso->getFechaTer())->format('%Y AÑOS - %M MESES - %D DÍAS');
        return $this->render('concurso/showregistros.html.twig', array(
            'concurso' => $concurso,
            'numregistro' =>$numRegistro,
            'fecharegistro' =>$fechaRegistro,
            //'delete_form' => $deleteForm->createView(),

            //   'dias' => $dias,
        ));


///var_dump($numRegistro,$fechaRegistro); exit();


        /** lo uso de base
         *
        $newestatus = $this->getDoctrine()->getRepository('AppBundle:Estatus')->find($nest);
        //Estatus::"nombre_variable" definida en ENTIDAD en este caso Estatus
        $concurso ->setEstatus($newestatus);

        $em = $this->getDoctrine()->getManager();
        $em->persist($concurso);
        $em->flush($concurso);
        return $this->redirectToRoute('concurso_show', array('id' => $concurso->getId()));

         */

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
     *
     * @Route("/{id}/Pubregs", name="concurso_showPubreg")
     * @Method({"GET", "POST"})
     */

    //envia el cocnurso y muestra a los Aspirantes registrados DURANTE estado PUBLICADO

    public function showPubRegAction(Request $request, Concurso $concurso)
    {

        $deleteForm = $this->createDeleteForm($concurso);

        // $dias = $concurso->getFechaIn()->diff($concurso->getFechaTer())->format('%Y AÑOS - %M MESES - %D DÍAS');
        $form = $this->createForm('AppBundle\Form\ConcursoRegistroType', $concurso);
        $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
        $this->getDoctrine()->getManager()->flush();
         return $this->redirectToRoute('concurso_showPubreg', array('id' => $concurso->getId()));
    }

        return $this->render('concurso/showAspregPub.html.twig', array(

            'concurso' => $concurso,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            //   'dias' => $dias,
        ));
    }


    /**
     *
     * @Route("/{id}/FORMpdf", name="cecFORM_pdf")
     */
    //GENERA EL PDF alta de Concurso

    public function pdfFAction(Concurso $concurso)
    {

        $fields = array(
            'clasificacionn' => $concurso->getClasificacion()->getNombre() ,
            'numEC'=> $concurso->getNumConcurso(),
            'fechaEdia'=>$concurso->getCreateAt()->format('d'),
            'fechaEmes'=>$concurso->getCreateAt()->format('m'),
            'fechaEanio'=>$concurso->getCreateAt()->format('Y'),
            'categoria' => $concurso->getClasificacion()->getAbreviacion().' '.$concurso->getCategoria()->getNombre(),
            'tdedicacionn' =>$concurso->getTiempoDedicacion()->getNombre(),
            'hclase'=>$concurso->getTpHclase(),
            'hotras'=>$concurso->getTpHacademia(),
            'hayudantia'=>$concurso->getTpHayudantia(),
            'unidadd'=>$concurso->getUnidad(),
            'divisionn'=>$concurso->getDepartamento()->getDivision()->getNombre(),
            'departamentoo'=>$concurso->getDepartamento()->getNombre(),
            'areadepto'=>$concurso->getAreaDepartamental(),
            'salarioA'=>number_format($concurso->getSalarioA(),2,".",","),
            'salarioB'=>number_format($concurso->getSalarioB(),2,".",","),
            'horario'=>$concurso->getHorario(),
            'fInidia'=>$concurso->getFechaIn()->format('d'),
            'fInimes'=>$concurso->getFechaIn()->format('m'),
            'fInianio'=>$concurso->getFechaIn()->format('Y'),
            'fTermdia'=>$concurso->getFechaTer()->format('d'),
            'fTermmes'=>$concurso->getFechaTer()->format('m'),
            'fTermanio'=>$concurso->getFechaTer()->format('Y'),
            'actividades' =>$concurso->getActividades(),
            'aConocimientoo'=>$concurso->getAConocimiento(),
            'disciplina'=>$concurso->getDisciplina(),
            'requisitos'=>$concurso->getRequisitos(),
            'causalcomp'=>$concurso->getCausalC(),
            'numplaza'=>$concurso->getPlaza(),
            'codigoplaza'=>$concurso->getClavePlaza(),
            'jdnombrecompl'=>$concurso->getDepartamento()->getDpNombreCompleto(),

            'subdirRL'=>'M. EN C. HIPÓLITO LARA RESÉNDIZ',
            'nombrectrlplantilla'=>' ',

        );

   $divfunciones=$concurso->getDepartamento()->getDivision()->getId();

        if($divfunciones==4){
            $fields['dirnombrecompl']='DRA. MARGARITA E. GALLEGOS MARTINEZ       EN FUNCIONES';
        }

        if($divfunciones!= 4){


            // $fields[pre_0]=2;
            $fields['dirnombrecompl']=$concurso->getDepartamento()->getDivision()->getDNombreCompleto();

                }


        $pdf = new FPDM(__DIR__."/../../../formatosPDF/regCEC.pdf");
        $pdf->Load($fields, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        $pdf->Merge();
        $nombre=preg_replace('/\./', '', 'Concurso_'.$concurso->getNumConcurso());
        $pdf->Output($nombre.'.pdf', 'D');
    }

    /**
     * @Route("/{id}/FRAspspdf", name="FORMRAsps_pdf")
     *
     */

    // debe generar los ASPIRANTES con entregoDocs = true en listado de registro de ASPIRANTES en PDF
    public function pdfFRAspsAction(Concurso $concurso)


    {

        //$clasificacion = $concurso->getClasificacion();
        //var_dump($clasificacion);exit();
        $fields = array(

            'FRegDIA'=>date("d"),
            'FRegMES'=>date("m"),
            'FRegANIO'=>date("Y"),
            'NumConcurso'=> 'EC.'.$concurso->getNumConcurso(),
            'divisionNSEC'=>$concurso->getDepartamento()->getDivision()->getSaNombreCompleto(),
            'divisionCOM'=>$concurso->getDepartamento()->getDivision()->getNombre(),
            'NumConcursoREF'=>'EC.'.$concurso->getNumConcurso(),
            'divisionSEC'=>$concurso->getDepartamento()->getDivision()->getNombre(),
            'FPublicacion'=>$concurso->getFechaPublicacion()->format('d - m - Y'),


            // 'subdirRL'=>'M. EN C. HIPÓLITO LARA RESÉNDIZ',
            // 'nombrectrlplantilla'=>'LIC. CIRO M. DÍAZ ROJAS',



        );


        foreach ($concurso->getRegistrosCompletos() as $i => $registro) // recorreo a los que tienen el criteria 'entregoDocs' true
        {
            $fields['asp_'.$i] = $registro->getAspiranteRfc()->getNombreCompleto();
        }

        //dump($fields); exit();

        $pdf = new FPDM(__DIR__."/../../../formatosPDF/regAsps22.pdf");
        $pdf->Load($fields, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        $pdf->Merge();
        $nombre=preg_replace('/\./', '', 'REG_'.$concurso->getNumConcurso());
        $pdf->Output($nombre.'.pdf', 'D');
    }





    /**
     * Finds and genera PDFs a Concurso entity.
     *
     * @Route("/{id}/pdfs", name="concurso_showpdfs")
     * @Method("GET")
     */
    public function showpdfsAction(Concurso $concurso)
    {

        $dias = $concurso->getFechaIn()->diff($concurso->getFechaTer())->format('%Y AÑOS - %M MESES - %D DÍAS');

        $html = $this->renderView('concurso/pdfshowc1.html.twig', array(
            'concurso' => $concurso,
            'dias' => $dias,
        ));

        $html2 = $this->renderView('concurso/pdfshowc2.html.twig', array(
            'concurso' => $concurso,
            'dias' => $dias,
        ));

        // $dimensiones=array (8.5,11);
        $pdfObj = $this->get("white_october.tcpdf")->create();
        $pdfObj->setPrintHeader(false);
        $pdfObj->setPrintFooter(false);
        $pdfObj->SetAuthor('LuisM-Dictaminadora');
        $pdfObj->SetTitle('Concurso_' . $concurso->getNumConcurso());
        $pdfObj->SetFont('helvetica', '', 7);
        $pdfObj->AddPage('P', 'mm', 'Letter');
        $pdfObj->writeHTML($html, true, true, true, false, '');
        $pdfObj->AddPage('P', 'mm', 'Letter');
        $pdfObj->writeHTML($html2, true, true, true, false, '');
        // $y1=$pdfObj->GetY()-50;
        //  $pdfObj->writeHTMLCell(194, '', 6, 90, $html2, 0, 1, 0, true, 'L', true);

        $pdfObj->Output('Concurso_'.$concurso->getNumConcurso().'.pdf', 'I');
    }


    /**
     * Displays a form to edit an existing concurso entity.
     *
     * @Route("/{id}/edit", name="concurso_edit")
     * @Method({"GET", "POST"})
     * @Security("(has_role('ROLE_CONCURSO_UPDATE') and user.getDivision() == concurso.getDepartamento().getDivision()) and concurso.getEstatus().getId() < 3 or has_role('ROLE_ADMINISTRADOR')")
     */
    public function editAction(Request $request, Concurso $concurso)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($concurso);
        $editForm = $this->createForm('AppBundle\Form\ConcursoType', $concurso);
        $editForm->handleRequest($request);
//PRUEBAS
       //  $clasificacionId = $editForm->getdata()->getClasificacion()->getId();
        // $categ = $em->getRepository('AppBundle:Categoria')->getArrayByClasificacionId($clasificacionId) ;
        // dump($clasificacionId,$categ);exit();


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('concurso_show', array('id' => $concurso->getId()));
        }

        return $this->render('concurso/edit.html.twig', array(
            'concurso' => $concurso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{concurso}/reconvocar/", name="reconvocar_edit")
     *
     *
     * @Method({"GET", "POST"})
     *
     */

public function reconvocarAction(Request $request, Concurso $concurso)// SE USA JUNTO CON EL @rotue {"propiedad"} y en conjunto con el twig cuando pasas Ruta(Controlador) pasas a la funcion esa Entidad
{
    $reconcurso = clone $concurso;

    $newestatus = $this->getDoctrine()->getRepository('AppBundle:Estatus')->find(Estatus::EnAprobacion); //Estatus::"nombre_variable" definida en ENTIDAD en este caso Estatus
    $reconcurso ->setEstatus($newestatus);

    $form = $this->createForm('AppBundle\Form\ConcursoType', $reconcurso);
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
    ));

}


    /**
     * @Route("/{concurso}/{nest}/nxstatus/", name="next_estatus")
     *CAMBIA EL ESTATUS DE FORMA QUE ENVIAS EL CONCURSO Y EL IDE DEL ESTATUS DESEADO ANTES DE ESO HAY UNA VENTANA MODAL PARA PREGUNTAR
     *
     * @Method({"GET", "POST"})
     *
     */

    public function nestatusAction(Request $request, Concurso $concurso, $nest)// SE USA JUNTO CON EL @rotue {"propiedad"} y en conjunto con el twig cuando pasas Ruta(Controlador) pasas a la funcion esa Entidad
    {


        $newestatus = $this->getDoctrine()->getRepository('AppBundle:Estatus')->find($nest);
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($concurso);
        $editForm = $this->createForm('AppBundle\Form\ConcursoType', $concurso);
        $editForm->handleRequest($request);
        //Estatus::"nombre_variable" definida en ENTIDAD en este caso Estatus
        $v1=$concurso->getEstatus()->getId();
        $v2=$concurso->getNumConcurso();
       // var_dump($v1,$v2);exit();
        if ($concurso->getEstatus()->getId() < 3 && $concurso->getNumConcurso() == null) {

            return $this->redirectToRoute('concurso_edit', array('id' => $concurso->getId(),
                //    'concurso' => $concurso,
                //    'edit_form' => $editForm->createView(),
                //    'delete_form' => $deleteForm->createView(),
            ));
        }

        if ($concurso->getEstatus()->getId() == 4 ) {
            //Recorrido de registros Docs = false
            // $em = $this->getDoctrine()->getManager();
            //$registros = $request->query->get('registros');
            $registros = $concurso->getRegistros();
           // $numRegistro = 'REG.'.$concurso->getNumConcurso();
           // $fechaRegistro = new \DateTime('now');
            foreach ($registros as $registro) {
                if ($registro->getEntregoDocs() == false) {
                    $em->remove($registro);
                }
            }
             $em->flush();

            $numRegistro='REG.'.$concurso->getNumConcurso();
            $fechaRegistro=new \DateTime('now');
            foreach ($registros as $registro)
            {
                $registro->setNumRegistro($numRegistro);
                $registro->setFechaRegistro($fechaRegistro);
                //dump($registro);
                $em->persist($registro);
            }
            $em->flush();
            //exit();

        }



        //termina recorrido de registros de Docs = false


        $concurso ->setEstatus($newestatus);

        $em = $this->getDoctrine()->getManager();
        $em->persist($concurso);
        //$em->flush();
        $em->flush($concurso);
        return $this->redirectToRoute('concurso_show', array('id' => $concurso->getId()));

       // return $this->render('concurso/edit.html.twig', array(
       //     'concurso' => $concurso,
       //     'edit_form' => $editForm->createView(),
       //     'delete_form' => $deleteForm->createView(),
       // ));

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
     * Deletes a concurso entity.
     *
     * @Route("/{id}", name="concurso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Concurso $concurso)
    {
        $form = $this->createDeleteForm($concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($concurso);
            $em->flush($concurso);
        }

        return $this->redirectToRoute('concurso_index');
    }

    /**
     * Creates a form to delete a concurso entity.
     *
     * @param Concurso $concurso The concurso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Concurso $concurso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('concurso_delete', array('id' => $concurso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

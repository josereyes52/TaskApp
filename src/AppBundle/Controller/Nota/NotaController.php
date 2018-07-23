<?php 


namespace AppBundle\Controller\Nota;
use AppBundle\Entity\Nota;
use AppBundle\Form\NotaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ticket;
use AppBundle\Entity\Usuario;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class NotaController extends Controller
{
//	/**
//	 *
//	 * @Route("/ticket", options={"expose"=true} ,name="lista_ticket")
//	 */
//	public function indexTickets(){
//        $role = $this->getUser()->getRoles()[0];
//        $tickets = null;
//            if ($role == "Normal"){
//                $tickets = $this->getDoctrine()
//                    ->getRepository(ticket::class)
//                    ->findBy(['usuario' => $this->getUser()->getID()]);
//
//            }else{
//                $tickets = $this->getDoctrine()
//                    ->getRepository(ticket::class)
//                    ->findBy(['usuarioAsignado' => $this->getUser()->getID()]);
//            }
//
//		return $this->render("@App/Ticket/lista_ticket.html.twig",
//			[
//				"tickets" => $tickets,
//                "role" => $role
//			]
//		);
//	}
//
//    /**
//     *
//     * @Route("/ticket/registrar", options={"expose"=true} ,name="agregar_ticket")
//     */
//    public function indexAgregarTickets(){
//
//        $role = $this->getUser()->getRoles()[0];
//        $usuarioActivo = $this->getUser()->getId();
//        $fechaCreado = date("Y-m-d");
//        $usuarios = $this->getDoctrine()
//            ->getRepository(Usuario::class)
//            ->findBy(["tipoUsuario"=>'Tecnico']);
//        return $this->render("@App/Ticket/registrar_ticket.html.twig",
//            [
//                "usuarios" => $usuarios,
//                "role" => $role,
//                "usuarioActivo" => $usuarioActivo,
//                "fechaCreado" => $fechaCreado
//            ]
//        );
//    }
//
//    /**
//     *
//     * @Route("/ticket/{id}", name = "ver_ticket")
//     * @Method("GET")
//     * @param Ticket $ticket
//     */
//
//    public function indexVerTicket(Ticket $ticket){
//
//        return $this->render("@App/Ticket/ver_ticket.html.twig",
//            [
//                "ticket" => $ticket,
//                "roles" => $this->getUser()->getRoles()[0]
//            ]
//        );
//
//    }

    /**
     *
     * @Route("/nota", options={"expose"=true} ,name="agregar_nota")
     */
    public function indexNota(){
        $nota = $this->getDoctrine()
            ->getRepository(Nota::class)
            ->findBy(array('ticketId'=>2));
        var_dump($nota);die;
        return $this->render("@App/Nota/registrar_nota.html.twig",
            [
                "nota" => $nota
            ]
        );

    }




    /**
     *
     * @Route("/rest/nota/registrar", options={"expose"=true} ,name = "guardar_nota")
     * @Method("POST")
     * @param Request $request
     */
    public function guardarNota(Request $request){
        $data = json_decode($request->getContent(), true);
        $nota = new Nota();
//        var_dump($ticket);die;
        $form = $this->createForm(NotaType::class, $nota);
        $form->submit($data);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $encoders = array(new JsonEncoder());
        $serializer = new Serializer($normalizers, $encoders);

//        $jsonContent = $this->get('serializer')->serialize($ticket,'json');

        $em = $this->getDoctrine()->getManager();
        //persist is to save
        $em->persist($nota);

        $em->flush();
//        $jsonContent = json_decode($serializer,true);

        return new JsonResponse(array("response"=>'Added' ) );
    }


//    /**
//     *
//     * @Route("/rest/ticket/{id}", options={"expose"=true} ,name = "actualizar_ticket")
//     * @Method("PUT")
//     * @param Request $request
//     *@param Ticket $ticket
//     *return JsonResponse
//     */
//    public function actualozarUsuarios(Request $request, Ticket $ticket){
//        $data = $request->getContent();
//        $data = json_decode($data, true);
//
//        $form = $this->createForm(TicketType::class, $ticket);
//        $form->submit($data);
//
////        if ($form->isValid()){
////            var_dump("neka");die;
//
//            $normalizer = new ObjectNormalizer();
//            $normalizer->setCircularReferenceLimit(1);
//            // Add Circular reference handler
//            // Add Circular reference handler
//            $normalizer->setCircularReferenceHandler(function ($object) {
//                return $object->getId();
//            });
//            $normalizers = array($normalizer);
//            $encoders = array(new JsonEncoder());
//            $serializer = new Serializer($normalizers, $encoders);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->flush();
//
//            return new JsonResponse( array("estado"=>$ticket->getEstado() ) );
//
////            return new JsonResponse($serializer);
////        }
//
////        return $form->getViewData();
////        return new JsonResponse(null, 400);
//    }
}
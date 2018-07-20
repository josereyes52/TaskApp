<?php 


namespace AppBundle\Controller\Ticket;
use AppBundle\Entity\ticket;
use AppBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Usuario;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TicketController extends Controller
{
	/**
	 *
	 * @Route("/ticket", options={"expose"=true} ,name="lista_ticket")
	 */
	public function indexTickets(){
		 $tickets = $this->getDoctrine()
		 	->getRepository(ticket::class)
		 	->findAll();
		return $this->render("@App/Ticket/lista_ticket.html.twig",
			[
				"tickets" => $tickets,
			]
		);
	}

    /**
     *
     * @Route("/ticket/{id}", name = "ver_ticket")
     * @Method("GET")
     * @param Ticket $ticket
     */

    public function indexVerTicket(Ticket $ticket){

        return $this->render("@App/Ticket/ver_ticket.html.twig",
            [
                "ticket" => $ticket
            ]
        );

    }










    /**
     *
     * @Route("/rest/ticket/{id}", options={"expose"=true} ,name = "actualizar_ticket")
     * @Method("PUT")
     * @param Request $request
     *@param Ticket $ticket
     *return JsonResponse
     */
    public function actualozarUsuarios(Request $request, Ticket $ticket){
        $data = $request->getContent();
        $data = json_decode($data, true);

        $form = $this->createForm(TicketType::class, $ticket);
        $form->submit($data);

        if ($form->isValid()){
            var_dump("neka");die;

            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(1);
            // Add Circular reference handler
            // Add Circular reference handler
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $encoders = array(new JsonEncoder());
            $serializer = new Serializer($normalizers, $encoders);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new JsonResponse($serializer);
        }

        //$form->getErrors();
        return new JsonResponse(null, 400);
    }
}
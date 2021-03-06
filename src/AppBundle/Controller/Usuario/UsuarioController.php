<?php 


namespace AppBundle\Controller\Usuario;
use AppBundle\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Usuario;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuarioController extends Controller
{
	/**
	 *
	 * @Route("/usuario", options={"expose"=true} ,name="lista_usuario")
	 */
	public function indexUsuarios(){
		 $usuarios = $this->getDoctrine()
		 	->getRepository(Usuario::class)
		 	->findAll();
		return $this->render("@App/Usuario/lista_usuario.html.twig",
			[
				"usuarios" => $usuarios
			]
		);
	}


	/**
	 *
	 * @Route("/usuario/{id}", name = "editar_usuario")
	 * @Method("GET")
	 * @param Usuario $usuario
	 */

	public function indexEditarUsuario(Usuario $usuario){

		return $this->render("@App/Usuario/editar_usuario.html.twig",
			[
				"usuario" => $usuario
			]
		);

	}

    /**
     *
     * @Route("/registro", name = "registrar_usuario")
     */

    public function indexRegistrarUsuario(){

        return $this->render("@App/Usuario/registrar_usuario.html.twig");

    }


	/**
	 *
	 * @Route("/usuario/{id}", name = "eliminar_usuario")
	 * @Method("DELETE")
	 * @param Usuario $usuario
	 */

	public function indexEliminarUsuario(Usuario $usuario){
        $em = $this->getDoctrine()->getManager();


        $em->remove($usuario);
		$em->flush();

		return $this->redirectToRoute('lista_usuario');

	}



	/**
	 *
	 * @Route("/usuario/{idUsuario}", name = "informacion usuario")
	 */
	public function indexUsuariosid($idUsuario){
		return $this->render("@App/Usuario/index.html.twig",["idUsuario" => $idUsuario]
		);
	}


	//Restful API

	/**
	 *
	 * @Route("/rest/usuario/{id}", options={"expose"=true}, name = "buscar_usuarios")
	 * @Method("GET")
	 *@param Usuario $usuario
	 */
	public function buscarUsuarios( Usuario $usuario){

		$jsonContent = $this->get('serializer')->serialize($usuario,'json');
		$jsonContent = json_decode($jsonContent,true);
		return new JsonResponse($jsonContent);
	}

	/**
	 *
	 * @Route("/rest/usuario/", options={"expose"=true} ,name = "guardar_usuarios")
	 * @Method("POST")
	 * @param Request $request
	 */
	public function guardarUsuarios(Request $request, UserPasswordEncoderInterface $passwordEncoder){
		$data = json_decode($request->getContent(), true);
		$usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->submit($data);

        $password = $passwordEncoder->encodePassword($usuario, $usuario->getContrasena());
        $usuario->setContrasena($password);

		$jsonContent = $this->get('serializer')->serialize($usuario,'json');

		$em = $this->getDoctrine()->getManager();
		//persist is to save
		$em->persist($usuario);

		$em->flush();
		$jsonContent = json_decode($jsonContent,true);

		return new JsonResponse($jsonContent);
	}

	/**
	 *
	 * @Route("/rest/usuario/{id}", options={"expose"=true} ,name = "actualizar_usuarios")
	 * @Method("PUT")
	 * @param Request $request
	 *@param Usuario $usuario
	 *return JsonResponse
	 */
	public function actualozarUsuarios(Request $request, Usuario $usuario){
		$data = $request->getContent();
		$data = json_decode($data, true);

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->submit($data);

        if ($form->isValid()){

//            $jsonContent = $this->get('serializer')->serialize($usuario,'json');
//            $jsonContent = json_decode($jsonContent,true);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

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



            return new JsonResponse($serializer);
        }

        //$form->getErrors();
        return new JsonResponse(null, 400);
    }
}
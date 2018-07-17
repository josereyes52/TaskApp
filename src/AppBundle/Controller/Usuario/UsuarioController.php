<?php 


namespace AppBundle\Controller\Usuario;
use AppBundle\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Usuario;

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
     * @Route("/login", name = "iniciar_sesion")
     */

    public function indexLoginUsuario(){

        return $this->render("@App/Usuario/iniciar_sesion.html.twig");

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
	public function guardarUsuarios(Request $request){
		$data = json_decode($request->getContent(), true);
		$usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->submit($data);

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

            $jsonContent = $this->get('serializer')->serialize($usuario,'json');
            $jsonContent = json_decode($jsonContent,true);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new JsonResponse($jsonContent);
        }

        //$form->getErrors();
        return new JsonResponse(null, 400);
    }
}
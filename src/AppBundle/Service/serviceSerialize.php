<?php
namespace AppBundle\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// use Symfony\Component\HttpFoundation\Request;
//use AppBundle\Entity\Usuario;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * 
 */
class serviceSerialize  
{
	
	function formatt($data = 'default')
	{
		$encoders = array( new JsonEncoder());
		$normalizers = array( new ObjectNormalizer());
		$serializer = new Serializer($normalizers, $encoders);

		$jsonContent = $serializer->serialize($data,'json');
		$jsonContent = json_decode($jsonContent, 'json');


		return new JsonResponse($jsonContent);
	}
}
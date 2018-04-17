<?php
require_once __DIR__.'/vendor/autoload.php';
require_once '../Config/appController.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App();

$app->post('/{negocio}/usuario/login', 'usuarioLogin');
$app->get('/{negocio}/observaciones','getObservaciones');

$app->run();


function usuarioLogin (Request $request, Response $response) {
	$negocio 	= $request->getAttribute('negocio');
	$model_usuario = loadModel('Usuarios',$negocio);
	$response->withHeader('Content-type', 'application/json');
	$obj_usuario = array();
	try{
		$usuario 	= (isset($request->getParsedBody()['usuario']) && !empty($request->getParsedBody()['usuario'])) ? $request->getParsedBody()['usuario'] : NULL;
		$clave 		= (isset($request->getParsedBody()['clave']) && !empty($request->getParsedBody()['clave'])) ? $request->getParsedBody()['clave'] : NULL;		
		if($model_usuario->validarReglasNegocioUsuario($usuario,$clave)){
			$arr_obj_usuario 					= $model_usuario->usuarioLogin($usuario , $clave);
			$obj_usuario['success'] 			= true;
			$obj_usuario["messageCliente"] 		= "Todo correcto";
			$obj_usuario["messageDeveloper"] 	= "Todo correcto validarReglasNegocioUsuario";
			$obj_usuario["data"] 				= $arr_obj_usuario;
		}else{
			$obj_usuario['success'] 			= false;
			$obj_usuario["messageCliente"] 		= "Tu usuario o clave no son correctos";
			$obj_usuario["messageDeveloper"] 	= "Error cuando ingresó a la función validarReglasNegocioUsuario";
			$obj_usuario["data"] 				= array();
		}
		$usuarioLogin = $response->withJson($obj_usuario);
		return $usuarioLogin;
	}catch(Exception $e){
		error_log(date('Y-m-d H:i:s')." Error: ".$e." \n", 3, 'usuarioLogin'.$negocio.'-'.date('Y-m-d H').'.log');
		$obj_usuario['success'] 			= false;
		$obj_usuario["messageCliente"] 		= "Estamos teniendo problemas con tu servicio, por favor contactar con soporte";
		$obj_usuario["messageDeveloper"] 	= $e;
		$obj_usuario["data"] 				= array();
		$usuarioLogin = $response->withJson($obj_usuario);
		return $usuarioLogin;
	}
}


/*
*TODO:
*
*C:\"Program Files (x86)"\Zend\Apache2\htdocs\api\v1\vendor\bin\phpunit --bootstrap Model/Usuarios.php --testdox tests
*C:\"Program Files (x86)"\Zend\Apache2\htdocs\api\v1\vendor\bin\phpunit --bootstrap Model/Usuarios.php tests/UsuariosTest
*
*/
?>


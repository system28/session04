<?php
class Usuarios{
	
	public $negocio = '';
	
	/**
	 * Verifica usuario y contraseña
	 * @param string $usuario
	 * @param string $pass
	 * @return array
	 * @author Joel Vasquez Villalobos.
	 * @version 18 Enero 2014
	 * @version Modificado por Henry: 11 Septiembre 2017
	 * @description cambio de los metos del driver pgsql por PDO
	*/
	public function usuarioLogin($usuario,$pass){
		$cnx = loadModel('database',$this->negocio);
		$db = $cnx->getConnection();
		$data= array();
		$sql = "SELECT u.usuario,u.clave FROM public.usuarios u WHERE u.usuario = '$usuario' and u.estado=true";
		$arr_obj_usuario = pg_query($sql);
		$num_rows = pg_num_rows($arr_obj_usuario);		
		if($num_rows == 1){
			$obj_usuario=pg_fetch_object($arr_obj_usuario);
			$usuario = $obj_usuario->usuario;
			$db_clave = $obj_usuario->clave;
			if($db_clave==$pass){
				$is_valid_pass = true;
			}else{
				$is_valid_pass = false;
			}
			if($is_valid_pass){											
				$data['success'] = true;
				$data['message'] = 'Bienvenido';
				$data['usuario'] = $usuario;
			}else{
				$data['success'] = false;					
				$data['message'] = 'contrasenia incorrecta';
				$data['usuario'] = null;
			}
			return $data;
		}else{
			$data['success'] = false;					
			$data['message'] = 'Usuario no existe o no esta activo';
			$data['usuario'] = null;
			return $data;
		}
	}
	
	public function validarReglasNegocioUsuario($usuario,$clave){
		if($this->esEmailValido($usuario) AND $this->esNotNull($usuario,$clave) AND $this->esClaveValida($clave)){
			return true;
		}
		return false;
	}
	
	public function esEmailValido($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
		return true;
    }
	
	public function esNotNull($email,$clave){
        if (is_null($email) OR is_null($clave)) {
            return false;
        }
		return true;
    }
	
	
	/**
	* Debe tener un mínimo de 8 caracteres
	* Debe contener al menos 1 número
	* Debe contener al menos un carácter en mayúscula
	* Debe contener al menos un carácter minúsculo
	*
	*/
	public function esClaveValida($clave){
		$uppercase = preg_match('@[A-Z]@', $clave);
		$lowercase = preg_match('@[a-z]@', $clave);
		$number    = preg_match('@[0-9]@', $clave);
		if(!$uppercase || !$lowercase || !$number || strlen($clave) < 8) {
		  return false;
		}
		return true;
	}
}
?>
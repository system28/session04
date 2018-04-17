<?php
/**
 * Permite mostrar errores en formato leible
 * @return <pre>
 * @version 18 April 2014
 * @author Joel Vasquez Villalobos.
 * @version Revisado por Geynen: 15 Octubre 2015
 */	
function debug ($what){
    echo '<pre>';
    if (is_array($what)) {
		print_r ($what);
    }else{
        var_dump ($what);
    }
    echo '</pre>';
}

/**
 * Gestiona la conexion a base de datos y las instancias de las clases.
 * @return arr_obj_observacion
 * @version 18 April 2014
 * @author Joel Vasquez Villalobos.
 * @version Revisado por Geynen: 15 Octubre 2015
 */	
function loadModel($modelName,$negocio){
	if($modelName=='database'){
		$modelPath = '../Config/'.$negocio.'_'.$modelName.'.php';
		if(is_file($modelPath)){
			if (!class_exists($modelName)) {
				require_once($modelPath);
			}		
		}else{
			echo 'No existe la conexion'.$modelPath;
			exit();
		}
		$model = new $modelName();
		return $model;	
	}else{
		$modelPath = '../Model/'.$modelName.'.php';
		if(is_file($modelPath)){
			if (!class_exists($modelName)) {
				require_once($modelPath);
			}
		}else{
			echo 'No existe este modelo '.$modelPath;
			exit();
		}
		$model = new $modelName();
		if($negocio != 'null'){
			$model->negocio = $negocio;
		}		
		return $model;
	}
}
?>
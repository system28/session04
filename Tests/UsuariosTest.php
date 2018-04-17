<?php
use PHPUnit\Framework\TestCase;
/**
 *	@testdox Usuarios
*/
final class UsuariosTest extends TestCase{
	/**
	 *	@testdox Clase Usuario instancia correcta
	*/
    public function UsuarioInstanciaCorrecta(){
		$usuarios = new Usuarios();
        $this->assertInstanceOf(
            Usuarios::class,
            $usuarios
        );
    }
	
	/**
	 *	@testdox Email Valido
     *	@depends UsuarioInstanciaCorrecta
     */

    public function EmailValido(){
		$usuarios = new Usuarios();
        $this->assertEquals(
            true,
            $usuarios->esEmailValido('joe@email.com')
        );
    }
}
?>
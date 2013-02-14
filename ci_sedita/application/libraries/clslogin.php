<?php
if (!defined('BASEPATH'))
    exit('No tiene Permiso para acceder directamente al Script');
/**
 * @author Miguel Quiroz Martinez
 * @author mquirozm1984@hotmail.com
 * @copyright WEB2MQ 2009
 * @version 1.0.0 
 * @package libraries
 * @access  public
 * |---------------------------------------------------------------
 * | clsLogin 
 * |---------------------------------------------------------------
 * |
 * | me maneja el login de mi clase
 * |
 */
         /*
            CREATE TABLE IF NOT EXISTS  `ci_sessions` (
            session_id varchar(40) DEFAULT '0' NOT NULL,
            ip_address varchar(16) DEFAULT '0' NOT NULL,
            user_agent varchar(50) NOT NULL,
            last_activity int(10) unsigned DEFAULT 0 NOT NULL,
            user_data text DEFAULT '' NOT NULL,
            PRIMARY KEY (session_id)
            );
         */
class clsLogin
{
    /**
     * Antes que nada empezaremos declarando nuestra variables en la clase. Cómo podeis 
     * ver empiezan todas con un “_” de manera que serán variables del tipo “privado” de
     * manera, que solo podremos acceder a ellas y modificarlas dentro de la misma clase.
     * También aprovecharemos para darles un valor por defecto.
     * @var integer $_id id del usuario logoneado
     * @var string $_user user del usuario
     * @var string $_clave clave del usuario
     * @var string $_name nombre del usuario
     * @var boolean $_auth indica si esta logoneado el usuario o no
     *   
     */
    var $_id = 0;
    var $_user = "";
    var $_clave = "";
    var $_name = "";
    var $_tipoUser = "";
    var $_auth = false;
 
    /**
     * Admin_login($auto = TRUE) constructor de la clase
     * Podemos ver que el constructor es el mismo nombre de la clase (acordaros de la mayúscula!).
     * También podemos llamarlo “__construct”, pero nuestra manera no habrá problemas con
     * versiones antiguas de PHP.
     * También pasaremos un parámetro que por defecto valdrá “TRUE”, de manera que siempre que
     * llamemos a nuestra clase se efectuara la comprobación.
     * En la linea 5 vemos como llamamos a una instancia de CodeIgniter, ya que ahora nos 
     * movemos en ámbito de clase propia y no estamos ‘heredando’ ninguna función de CodeIgniter.
     * De manera que en vez de llamar a las funciones $this->libreria->funcion como lo hacíamos 
     * en los controladores, lo llamaremos con $CI->libreria->funcion, ya que en estos momentos
     * $this se refiere a nuestra clase.
     * Con esto $CI->session->userdata(’nick’) lo que hacemos es coger los valores de las
     * variables sessión, es parecido a $_SESSION['nick'] pero cómo CodeIgniter tiene su propio
     * sistema de variables session lo haremos de esta manera.
     * De manera que pasaremos el valor de usuario y la contraseña a nuestra función de login 
     * (que veremos mas adelante), y en caso de que sea correcto,copiaremos el valor de las
     * variables session en nuestra clase, para que podamos usarlo luego.
     * @param boolean $auto verdadero pra que busque en la bd si el usuario existe
     */
    function clsLogin($auto = true)
    {
        if ($auto) {
            $CI = &get_instance();
            if ($this->login($CI->session->userdata('user'), $CI->session->userdata('clave'))) {
                $this->_id = $CI->session->userdata('id');
                $this->_nick = $CI->session->userdata('user');
                $this->_clave = $CI->session->userdata('clave');
                $this->_name = $CI->session->userdata('name');
                $this->_tipoUser = $CI->session->userdata('tipoUser');
                $this->_auth = true;
            }
        }
    }
    function getTipo()
    {
        return $this->_tipo;
    }

    /**
     * getId() retorna el id del usuario
     * @return integer _id
     */
    function getId()
    {
        return $this->_id;
    }
    /**
     * getUser() retorna el user del usuario
     * @return string _user
     */
    function getUser()
    {
        return $this->_user;
    }
    /**
     * getClave() retorna la clave del usuario
     * @return string _clave
     */
    function getClave()
    {
        return $this->_clave;
    }
    /**
     * getName() retorna el nombre del usuario
     * @return string _name
     */
    function getName()
    {
        return $this->_name;
    }
    /**
     * getTipoUser() retorna el nombre del usuario
     * @return string _tipoUser
     */
    function getTipoUser()
    {
        return $this->_tipoUser;
    }
    /**
     * login($user = "", $clave = "")
     * La función de login recibirá dos parámetros: usuario y contraseña que normalmente serán 
     * los que el usuario nos introduzca mediante un formulario. Pero también se usará para
     * validarse automáticamente mediante las variables SESSION que tendremos almacenadas,
     * asi siempre comprobaremos que las credenciales de los usuarios son siempre validas.
     * Entonces procederemos a comprobar que el usuario y la contraseña coinciden con la base 
     * de datos, si todo esta correcto crearemos las variables sesión (o las actualizaremos).
     * Primero hay que tener claro que todas las variables tipo $this->_nombre son variables
     * privadas de la clase por lo que solo podremos acceder a ellas desde dentro (por eso 
     * creamos en el articulo anterior funciones para retomar esos valores). La consulta en la
     * base de datos es muy sencilla, simplemente comprobamos que exista un registro que contenga
     * el usuario y el password (que ira encriptado con la función sha1).
     * Si todo es correcto crearemos las variables SESSION mediante la clase de CodeIgniter 
     * session Class) y le daremos valor a nuestra variables privadas. Para acabar devolveremos
     * TRUE para que nuestro sistema sepa que todo ha ido correctamente.
     * Si algo falla llamaremos a la función logout para que elimine todos los restos y
     * devolveremos FALSE.
     * @param string $user usuario a consultar
     * @param string $clave usuario a consultar
     * 
     */
    function login($user = "", $clave = "")
    {
        if (empty($user) || empty($clave))
            return false;
        
        $CI = &get_instance();
        
        $sql = "SELECT usu_personal_id, usu_nombre, usu_tipo
                FROM usuario
                WHERE usu_nombre=? AND usu_clave=?";
        
        $query = $CI->db->query($sql, array(strtolower($user), strtolower($clave)));
        
        if ($query->num_rows() == 1) {
            //para retornar un solo resultado
            $row = $query->row();
            $this->_id = $row->usu_personal_id;
            $this->_user = $user;
            $this->_clave = $clave;
            $this->_name = $row->usu_nombre;
            $this->_tipoUser = $row->usu_tipo;
            $this->_auth = true;
            //si lo guardo asi solo hago una sola update no uno x uno en la BD
            $info_session = array('id' => $this->_id, 'user' => $user, 'clave' => $clave,
                'name' => $this->_name, 'tipoUser' => $this->_tipoUser);
            $CI->session->set_userdata($info_session);
            return true;
        } 
        else {
            $this->_auth = false;
            $this->logout();
            return false;
        }
        
        $query->free_result();
        $query->close();
        $CI->db->close();
    } //funcion login
    
    /**
     * logout()
     * Esta función simple y llanamente destruirá las variables session.
     */
    function logout()
    {
        $CI = &get_instance();
        $CI->session->sess_destroy();
        //$this->session->sess_destroy();
        $this->_auth = false;
        $this->_id = 0;
        $this->_user = "";
        $this->_clave = "";
        $this->_name = "";
        $this->_tipoUser = "";
    } //logout
    /**
     * Check()
     * La función check (comprobar) mirara simplemente si cumplimos el nivel indicado. 
     * El segundo parámetro especificaremos si queremos que se compruebe estrictamente es decir,
     * suponiendo que [Nivel1:Usuario, Nivel2:Moderador, Nivel3:Administrador], si comprobamos
     * estrictamente el nivel 2 solo lo pasarían los Moderadores, en cambio si comprobamos lo
     * mismo sin ser estrictos, tanto los Moderadores como Administradores deberían tener acceso.
     * Aquí simplemente hacemos comparaciones con el nivel que queremos comprobar y el que tiene
     * el usuario, en caso de que sea estricto
     * miraremos que coincida exactamente (==), sino lo es, miraremos que sea mayor o igual (>=).
     */
    function check()
    {
        if (!$this->_auth)
            return false;
        else
            return true;
    } //check
    /*
    function check($nivel = 0, $estricto = TRUE){
		if(!$this->_auth)
			return FALSE;
		else
			return TRUE;			
		if($estricto){
			if($nivel == $this->_nivel)            
				return TRUE;
			else
				return FALSE;
		}else{
			if($nivel < = $this->_nivel)            
				return TRUE;
			else
				return FALSE;    
		}
    }//check
    */
}
////////////////////INDICO QUE NO ALMACENE EN CACHE LA INFORMACION
// Date in the past
//$CI->output->set_header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT");
// always modified
//$CI->output->set_header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT");
// HTTP/1.1
//$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
//$CI->output->set_header("Cache-Control: post-check=0, pre-check=0", FALSE);
//$CI->output->set_header("Pragma: no-cache");
////////////////////////////////////FIN DE CACHE
?>
<?php

	class Pedido {
		private $id;
		private $usuario_id;
		private $provincia;
		private $localidad;
		private $direccion;
		private $coste;
		private $estado;
		private $fecha;
		private $hora;
		private $db;

		public function __construct() {
			 $this->db = Database::connect();
		}
	
	    /**
	     * @return mixed
	     */
	    public function getId()
	    {
	        return $this->id;
	    }

	    /**
	     * @param mixed $id
	     *
	     * @return self
	     */
	    public function setId($id)
	    {
	        $this->id = $id;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getUsuarioId()
	    {
	        return $this->usuario_id;
	    }

	    /**
	     * @param mixed $usuario_id
	     *
	     * @return self
	     */
	    public function setUsuarioId($usuario_id)
	    {
	        $this->usuario_id = $usuario_id;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getProvincia()
	    {
	        return $this->provincia;
	    }

	    /**
	     * @param mixed $provincia
	     *
	     * @return self
	     */
	    public function setProvincia($provincia)
	    {
	        $this->provincia = $this->db->real_escape_string($provincia);

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getLocalidad()
	    {
	        return $this->localidad;
	    }

	    /**
	     * @param mixed $localidad
	     *
	     * @return self
	     */
	    public function setLocalidad($localidad)
	    {
	        $this->localidad = $this->db->real_escape_string($localidad);

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getDireccion()
	    {
	        return $this->direccion;
	    }

	    /**
	     * @param mixed $direccion
	     *
	     * @return self
	     */
	    public function setDireccion($direccion)
	    {
	        $this->direccion = $this->db->real_escape_string($direccion);

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getCoste()
	    {
	        return $this->coste;
	    }

	    /**
	     * @param mixed $coste
	     *
	     * @return self
	     */
	    public function setCoste($coste)
	    {
	        $this->coste = $coste;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getEstado()
	    {
	        return $this->estado;
	    }

	    /**
	     * @param mixed $estado
	     *
	     * @return self
	     */
	    public function setEstado($estado)
	    {
	        $this->estado = $estado;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getFecha()
	    {
	        return $this->fecha;
	    }

	    /**
	     * @param mixed $fecha
	     *
	     * @return self
	     */
	    public function setFecha($fecha)
	    {
	        $this->fecha = $fecha;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getHora()
	    {
	        return $this->hora;
	    }

	    /**
	     * @param mixed $hora
	     *
	     * @return self
	     */
	    public function setHora($hora)
	    {
	        $this->hora = $hora;

	        return $this;
	    }

	    public function getAll() {
	    	$productos = $this->db->query("SELECT * FROM pedidos");
	    	return $productos;
	    }

	   	public function getOne() {
	    	$producto = $this->db->query("SELECT * FROM pedidos WHERE id={$this->getId()}");
	    	return $producto->fetch_object();
	    }

	    public function getOneByUser() {
	    	$sql = "SELECT id, coste FROM pedidos WHERE usuario_id = {$this->getUsuarioId()} ORDER BY id DESC LIMIT 1";
	    	$pedido = $this->db->query($sql);
	    	return $pedido->fetch_object();
	    }

	    public function getAllByUser() {
	    	$sql = "SELECT * FROM pedidos WHERE usuario_id = {$this->getUsuarioId()} ORDER BY id DESC";
	    	$pedido = $this->db->query($sql);
	    	return $pedido;
	    }

	    public function getProductosByPedido($id) {
	    	$sql = "SELECT pr.*, lp.unidades FROM productos pr 
	    			INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id 
	    			WHERE lp.pedido_id = {$id}";
	    	$productos = $this->db->query($sql);
	    	return $productos;
	    }

	    public function save() {
	    	$sql = "INSERT INTO pedidos VALUES(NULL, {$this->getUsuarioId()}, '{$this->getProvincia()}', '{$this->getLocalidad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'confirm', CURDATE(), CURTIME());";
	    	$save = $this->db->query($sql);

	    	$result = false;
	    	if ($save) {
	    		$result = true;
	    	}
	    	return $result;
	    }

	    public function save_linea() {
	    	$sql = "SELECT LAST_INSERT_ID() AS 'pedido';";
	    	$query = $this->db->query($sql);
	    	$pedido_id = $query->fetch_object()->pedido;

	    	foreach ($_SESSION['carrito'] as $elemento) {
				$producto = $elemento['producto'];

				$insert = "INSERT INTO lineas_pedidos VALUES(NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']})";
				$save = $this->db->query($insert);
			}

			$result = false;
	    	if ($save) {
	    		$result = true;
	    	}
	    	return $result;
	    }

	    public function edit() {
	    	$sql = "UPDATE pedidos SET estado = '{$this->getEstado()}' 
	    			WHERE id = {$this->getId()}";

	    	$save = $this->db->query($sql);

	    	$result = false;
	    	if ($save) {
	    		$result = true;
	    	}
	    	return $result;
	    }

	}

?>
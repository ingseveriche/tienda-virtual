<?php

	require_once 'models/pedido.php';

	class pedidoController {

		public function hacer() {
			require_once 'views/pedido/hacer.php';
		}

		public function add() {
			if (isset($_SESSION['identity'])) {
				$usuario_id = $_SESSION['identity']->id;
				$provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
				$localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
				$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
				$stats = Utils::statsCarrito();
				$coste = $stats['total'];

				if ($provincia && $localidad && $direccion) {
					//Guardar datos en la BD
					$pedido = New Pedido();
					$pedido->setUsuarioId($usuario_id);
					$pedido->setProvincia($provincia);
					$pedido->setLocalidad($localidad);
					$pedido->setDireccion($direccion);
					$pedido->setCoste($coste);

					$save = $pedido->save();
					//Guardar linea pedido
					$save_linea = $pedido->save_linea();

					if ($save && $save_linea) {
						$_SESSION['pedido'] = "complete";
					}
					else {
						$_SESSION['pedido'] = "failed";
					}
				}
				else {
					$_SESSION['pedido'] = "failed";
				}

				header("Location:".base_url."pedido/confirmado");
			}
			else {
				//Redigir al index
				header("Location:".base_url);
			}
		}

		public function confirmado() {
			if (isset($_SESSION['identity'])) {
				$identity = $_SESSION['identity'];
				$pedido = New Pedido();
				$pedido->setUsuarioId($identity->id);
				$pedido = $pedido->getOneByUser();

				$pedido_productos = New Pedido();
				$productos = $pedido_productos->getProductosByPedido($pedido->id);
			}

			//se elimina la información del carrito
			unset($_SESSION['carrito']);

			require_once 'views/pedido/confirmado.php';
		}

		public function mis_pedidos() {
			Utils::isIdentity();
			$usuario_id = $_SESSION['identity']->id;
			$pedido = New Pedido();

			//sacar los pedidos del usuario
			$pedido->setUsuarioId($usuario_id);
			$pedidos = $pedido->getAllByUser();

			require_once 'views/pedido/mis_pedidos.php';
		}

		public function detalle() {
			Utils::isIdentity();
			if (isset($_GET['id'])) {
				$id = $_GET['id'];

				//sacar el pedido
				$pedido = New Pedido();
				$pedido->setId($id);
				$pedido = $pedido->getOne();

				//sacar los productos
				$pedido_productos = New Pedido();
				$productos = $pedido_productos->getProductosByPedido($id);

				require_once 'views/pedido/detalle.php';
			}
			else {
				header('Location:'.base_url.'pedido/mis_pedidos');
			}	
		}

		public function gestion() {
			Utils::isAdmin();
			$gestion = true;

			$pedido = New Pedido();
			$pedidos = $pedido->getAll();

			require_once 'views/pedido/mis_pedidos.php';
		}

		public function estado() {
			Utils::isAdmin();
			if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
				//recoger datos del form
				$id = $_POST['pedido_id'];
				$estado = $_POST['estado'];

				//update del pedido
				$pedido = New Pedido();
				$pedido->setId($id);
				$pedido->setEstado($estado);
				$pedido->edit();

				header('Location:'.base_url.'pedido/detalle&id='.$id);
			}
			else {
				header('Location:'.base_url);
			}
		}

	}

?>
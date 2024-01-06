<?php if (isset($_SESSION['pedido']) && $_SESSION['pedido'] == 'complete') : ?>
	<h1>¡Pedido Confirmado!</h1>
	<p>Tu pedido ha sido guardado con exito, una vez que realices la transferencia bancaria a la cuenta 123456789 con el coste del pedido, será procesado y envíado.</p>
	<br>
	<?php if (isset($pedido)) : ?>
		<h3>Datos del Pedido</h3>
		Id del pedido: <?=$pedido->id?> <br>
		Total a pagar: $<?=$pedido->coste?> <br>
		Productos: <br>
		<table>
			<tr>
				<th>Imagen</th>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Unidades</th>
			</tr>
			<?php while($producto = $productos->fetch_object()) : ?>
				<tr>
					<td>
						<?php if ($producto->imagen != null) : ?>
							<img src="<?=base_url?>uploads/images/<?=$producto->imagen?>" class="img_carrito" />
						<?php else : ?>
							<img src="<?=base_url?>assets/img/sin-imagen.png" class="img_carrito" />
						<?php endif ?>
					</td>
					<td>
						<a href="<?=base_url?>producto/ver&id=<?=$producto->id?>">
							<?=$producto->nombre?>
						</a>
					</td>
					<td>
						<?=$producto->precio?>
					</td>
					<td>
						<?=$producto->unidades?>
					</td>
				</tr>
			<?php endwhile; ?>
		</table>
	<?php endif; ?>

<?php elseif (isset($_SESSION['pedido']) && $_SESSION['pedido'] != 'complete') : ?>
	<h1>Tu pedido NO ha podido procesarse.</h1>
<?php endif; ?>
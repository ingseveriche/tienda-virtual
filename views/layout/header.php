<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Tienda de Muebles</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="<?=base_url?>assets/css/styles.css">
	</head>
	<body>

		<div id="container">
			<!-- Cabecera -->
			<header id="header">
				<div id="logo">
					<a href="<?=base_url?>">
						<img src="<?=base_url?>assets/img/logo.png" alt="Logotipo" />
					</a>
					<h1>Tienda de Muebles</h1>	
				</div>
			</header>

			<!-- Menú -->
			<?php $categorias = Utils::showCategorias(); ?>
			<nav id="menu">
				<ul>
					<li>
						<a href="<?=base_url?>">Inicio</a>
					</li>
					<?php while ($cat = $categorias->fetch_object()) : ?>
						<li>
							<a href="<?=base_url?>categoria/ver&id=<?=$cat->id?>"><?=$cat->nombre?></a>
						</li>
					<?php endwhile; ?>
				</ul>
			</nav>

			<div id="content">
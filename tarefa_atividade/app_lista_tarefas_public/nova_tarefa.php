<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>

		<?php if( isset($_GET['inclusao']) && $_GET['inclusao'] == 1 ) { ?>
			<div class="bg-success pt-2 text-white d-flex justify-content-center">
				<h5>Tarefa inserida com sucesso!</h5>
			</div>
		<?php } ?>

		<div class="container app">
			<div class="row">
				<div class="col-md-3 menu">
					<ul class="list-group">
						<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
						<li class="list-group-item active"><a href="#">Nova tarefa</a></li>
						<li class="list-group-item"><a href="todas_tarefas.php">Todas tarefas</a></li>
					</ul>
				</div>

				<div class="col-md-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Nova tarefa</h4>
								<hr />

								<form method="post" action="tarefa_controller.php?acao=inserir">
									<div class="form-group">
										<label for="tarefa">Tarefa:</label>
										<input type="text" class="form-control" name="tarefa" id="tarefa">
									</div>
									<div class="form-group">
										<label for="prioridade">Prioridade:</label>
										<select class="form-control" name="prioridade" id="prioridade">
											<option value="1">Baixa</option>
											<option value="2">Média</option>
											<option value="3">Alta</option>
										</select>
									</div>
									<div class="form-group">
										<label>Categoria:</label>
										<select class="form-control" name="id_categoria">
											<?php foreach($categorias as $categoria) { ?>
												<option value="<?= $categoria->id ?>"><?= $categoria->nome ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="prazo">Prazo:</label>
										<input type="date" class="form-control" name="prazo" id="prazo">
									</div>
									<button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
								</form>


							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
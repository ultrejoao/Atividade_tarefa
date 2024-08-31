<?php

	$acao = 'recuperar';
	require 'tarefa_controller.php';



	/*
	echo '<pre>';
	print_r($tarefas);
	echo '</pre>';
	*/

?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<script>
			function editar(id, txt_tarefa) {

				//criar um form de edição
				let form = document.createElement('form')
				form.action = 'tarefa_controller.php?acao=atualizar'
				form.method = 'post'
				form.className = 'row'

				//criar um input para entrada do texto
				let inputTarefa = document.createElement('input')
				inputTarefa.type = 'text'
				inputTarefa.name = 'tarefa'
				inputTarefa.className = 'col-9 form-control'
				inputTarefa.value = txt_tarefa

				//criar um input hidden para guardar o id da tarefa
				let inputId = document.createElement('input')
				inputId.type = 'hidden'
				inputId.name = 'id'
				inputId.value = id

				//criar um button para envio do form
				let button = document.createElement('button')
				button.type = 'submit'
				button.className = 'col-3 btn btn-info'
				button.innerHTML = 'Atualizar'

				//incluir inputTarefa no form
				form.appendChild(inputTarefa)

				//incluir inputId no form
				form.appendChild(inputId)

				//incluir button no form
				form.appendChild(button)

				//teste
				//console.log(form)

				//selecionar a div tarefa
				let tarefa = document.getElementById('tarefa_'+id)

				//limpar o texto da tarefa para inclusão do form
				tarefa.innerHTML = ''

				//incluir form na página
				tarefa.insertBefore(form, tarefa[0])

			}

			function remover(id) {
    			location.href = 'todas_tarefas.php?acao=remover&id='+id+'&filter=' + encodeURIComponent(document.getElementById('filter').value);
			}

			function marcarRealizada(id) {
    			location.href = 'todas_tarefas.php?acao=marcarRealizada&id='+id+'&filter=' + encodeURIComponent(document.getElementById('filter').value);
			}

			function arquivar(id) {
				location.href = 'todas_tarefas.php?acao=arquivar&id=' + id + '&filter=' + encodeURIComponent(document.getElementById('filter').value);
			}


			
		</script>
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

		<div class="container app">
			<div class="row">
				<div class="col-sm-3 menu">
					<ul class="list-group">
						<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item active"><a href="#">Todas tarefas</a></li>
						
					</ul>
					
				</div>

				<div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Todas tarefas</h4>
								<hr />
								<form method="get" action="todas_tarefas.php">
									<div class="form-group">
										<label for="filter">Filtrar por:</label>
										<select id="filter" name="filter" class="form-control" onchange="this.form.submit()">
											<option value="all" <?= $filter == 'all' ? 'selected' : '' ?>>Todas</option>
											<option value="pending" <?= $filter == 'pending' ? 'selected' : '' ?>>Pendentes</option>
											<option value="completed" <?= $filter == 'completed' ? 'selected' : '' ?>>Concluídas</option>
											<option value="archived" <?= $filter == 'archived' ? 'selected' : '' ?>>Arquivadas</option>
										</select>
									</div>
									<div class="form-group">
										<label for="ordenacao">Ordenar:</label>
										<select id="ordenacao" name="ordenacao" class="form-control" onchange="this.form.submit()">
											<option value="data_cadastro ASC" <?= $ordenacao == 'data_cadastro ASC' ? 'selected' : '' ?>>Data de Criação (Crescente)</option>
											<option value="data_cadastro DESC" <?= $ordenacao == 'data_cadastro DESC' ? 'selected' : '' ?>>Data de Criação (Decrescente)</option>
											<option value="prioridade ASC" <?= $ordenacao == 'prioridade ASC' ? 'selected' : '' ?>>Prioridade (Baixa (1) para Alta (3))</option>
											<option value="prioridade DESC" <?= $ordenacao == 'prioridade DESC' ? 'selected' : '' ?>>Prioridade (Alta (3) para Baixa (1))</option>
										</select>
										<label><br>Filtrar:</label>
										<label>Categoria:</label>
										<select class="form-control" name="id_categoria">
											<?php foreach($categorias as $categoria) { ?>
												<option value="<?= $categoria->id ?>"><?= $categoria->nome ?></option>
											<?php } ?>
										</select>
									</div>
								</form>

								<?php foreach($tarefas as $indice => $tarefa) { ?>
									<div class="row mb-3 d-flex align-items-center tarefa">
										<div class="col-sm-9" id="tarefa_<?= $tarefa->id ?>">
											<?= $tarefa->tarefa ?> (<?= $tarefa->status ?>)
										</div>
										<div class="col-sm-3 mt-2 d-flex justify-content-between">
											<i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)"></i>
											<?php if($tarefa->status == 'pendente') { ?>
												<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')"></i>
												<i class="fas fa-check-square fa-lg text-success" onclick="marcarRealizada(<?= $tarefa->id ?>)"></i>
												<i class="fas fa-archive fa-lg text-secondary" onclick="arquivar(<?= $tarefa->id ?>)"></i>
											<?php } ?>
										</div>
									</div>
								<?php } ?>


							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

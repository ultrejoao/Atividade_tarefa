<?php

require "../app_lista_tarefas/tarefa.model.php";
require "../app_lista_tarefas/tarefa.service.php";
require "../app_lista_tarefas/conexao.php";

require 'categoria.php';
require 'categoria.service.php';


$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all'; 
$ordenacao = isset($_GET['ordenacao']) ? $_GET['ordenacao'] : 'data_cadastro ASC'; 


if ($acao == 'inserir') {
    $tarefa = new Tarefa();
    $tarefa->__set('tarefa', $_POST['tarefa'])
           ->__set('prioridade', $_POST['prioridade']) 
		   ->__set('prazo', $_POST['prazo'])
		   ->__set('categoria', $_POST['categoria']); // Recebe a categoria do formulário



    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->inserir();

    header('Location: nova_tarefa.php?inclusao=1');

} else if($acao == 'recuperar') {
    $tarefa = new Tarefa();
    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);

    if ($filter == 'completed') {
        $tarefas = $tarefaService->recuperarTarefasPorStatus(2);
    } else if ($filter == 'pending') {
        $tarefas = $tarefaService->recuperarTarefasPorStatus(1);
    } else if ($filter == 'archived') {
        $tarefas = $tarefaService->recuperarTarefasArquivadas();
    } else {
        $tarefas = $tarefaService->recuperarTarefasOrdenadas($ordenacao);
    }


} else if($acao == 'atualizar') {

    $tarefa = new Tarefa();
    $tarefa->__set('id', $_POST['id'])
           ->__set('tarefa', $_POST['tarefa'])
           ->__set('prioridade', $_POST['prioridade']) 
		   ->__set('prazo', $_POST['prazo'])
		   ->__set('categoria', $_POST['categoria']); // Recebe a categoria do formulário



    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->atualizar();

    header('Location: todas_tarefas.php?filter=' . $filter);

} else if($acao == 'remover') {

    $tarefa = new Tarefa();
    $tarefa->__set('id', $_GET['id']);

    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->remover();

    header('Location: todas_tarefas.php?filter=' . $filter);

} else if($acao == 'marcarRealizada') {

    $tarefa = new Tarefa();
    $tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->marcarRealizada();

    header('Location: todas_tarefas.php?filter=' . $filter);

} else if($acao == 'recuperarTarefasPendentes') {
		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);
		
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperarTarefasPendentes();

} else if ($acao == 'arquivar') {
	$tarefa = new Tarefa();
	$tarefa->__set('id', $_GET['id'])->__set('arquivada', 1);
	
	$conexao = new Conexao();
	$tarefaService = new TarefaService($conexao, $tarefa);
	$tarefaService->arquivar();
	
	if (isset($_GET['pag']) && $_GET['pag'] == 'index') {
		header('location: index.php');
	} else {
		header('location: todas_tarefas.php');
	}

} else if ($acao == 'recuperarPorCategoria') {
	$id_categoria = $_GET['id_categoria'];
	$tarefa = new Tarefa();
	$tarefa->__set('id_categoria', $id_categoria);

	$conexao = new Conexao();
	$tarefaService = new TarefaService($conexao, $tarefa);
	$tarefas = $tarefaService->recuperarPorCategoria();
}	

if ($acao == 'recuperarTarefasPendentes' || $acao == 'novaTarefa') {
    $categoria = new Categoria();
    $conexao = new Conexao();

    $categoriaService = new CategoriaService($conexao, $categoria);
    $categorias = $categoriaService->recuperar();
}


?>
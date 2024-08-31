<?php


//CRUD
class TarefaService {

	private $conexao;
	private $tarefa;

	public function __construct(Conexao $conexao, Tarefa $tarefa) {
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
	}

	public function inserir() {
		try {
			$query = '
				INSERT INTO tb_tarefas (tarefa, data_cadastro, id_status, prioridade)
				VALUES (:tarefa, NOW(), 1, :prioridade)'; 
	
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
			$stmt->bindValue(':prioridade', $this->tarefa->__get('prioridade')); 
			$stmt->execute();
		} catch (PDOException $e) {
			echo '<p>Erro ao inserir tarefa: ' . $e->getMessage() . '</p>';
		}
	}
	

	public function recuperar() {
		try {
			$query = '
				SELECT 
					t.id, s.status, t.tarefa, t.data_cadastro, t.prioridade 
				FROM 
					tb_tarefas AS t
					LEFT JOIN tb_status AS s ON (t.id_status = s.id)
				WHERE t.arquivada = 0
			';
			
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			echo '<p>Erro ao recuperar tarefas: ' . $e->getMessage() . '</p>';
			return [];
		}
	}
	

	public function atualizar() { //update

		$query = "update tb_tarefas set tarefa = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function remover() { //delete

		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute();
	}

	public function marcarRealizada() { //update

		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function recuperarTarefasPendentes() {
		try {
			$query = '
				SELECT 
					t.id, s.status, t.tarefa, t.data_cadastro, t.prioridade 
				FROM 
					tb_tarefas AS t
					LEFT JOIN tb_status AS s ON (t.id_status = s.id)
				WHERE t.id_status = :id_status AND t.arquivada = 0';
			
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			echo '<p>Erro ao recuperar tarefas pendentes: ' . $e->getMessage() . '</p>';
			return [];
		}
	}

	public function recuperarTarefasPorStatus($status) {
		try {
			$query = '
				SELECT 
					t.id, s.status, t.tarefa 
				FROM 
					tb_tarefas AS t
					LEFT JOIN tb_status AS s ON (t.id_status = s.id)
				WHERE s.id = :status
				AND t.arquivada = 0
			';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':status', $status);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			echo '<p>Erro ao recuperar tarefas por status: ' . $e->getMessage() . '</p>';
			return [];
		}
	}

	public function arquivar() {
		try {
			$query = '
				UPDATE tb_tarefas 
				SET arquivada = 1 
				WHERE id = :id
			';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id', $this->tarefa->__get('id'));
			$stmt->execute();
		} catch (PDOException $e) {
			echo '<p>Erro ao arquivar tarefa: ' . $e->getMessage() . '</p>';
		}
	}
	
	public function recuperarTarefasArquivadas() {
		try {
			$query = '
				SELECT 
					t.id, s.status, t.tarefa 
				FROM 
					tb_tarefas AS t
					LEFT JOIN tb_status AS s ON (t.id_status = s.id)
				WHERE t.arquivada = 1
			';
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			echo '<p>Erro ao recuperar tarefas arquivadas: ' . $e->getMessage() . '</p>';
			return [];
		}
	}

	public function recuperarTarefasOrdenadas($ordenacao) {
		try {
			$query = '
				SELECT 
					t.id, s.status, t.tarefa, t.data_cadastro, t.prioridade, t.prazo 
				FROM 
					tb_tarefas AS t
					LEFT JOIN tb_status AS s ON (t.id_status = s.id)
				WHERE t.arquivada = 0
				ORDER BY ' . $ordenacao;
			
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			echo '<p>Erro ao recuperar tarefas ordenadas: ' . $e->getMessage() . '</p>';
			return [];
		}
	}

	public function recuperarPorCategoria() {
		$query = 'SELECT t.id, t.id_status, s.status, t.tarefa, t.data_cadastro, t.prioridade, t.prazo, c.nome as categoria 
				  FROM tb_tarefas AS t 
				  LEFT JOIN tb_status AS s ON t.id_status = s.id 
				  LEFT JOIN categorias AS c ON t.id_categoria = c.id 
				  WHERE t.id_categoria = :id_categoria';
	
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_categoria', $this->tarefa->__get('id_categoria'));
		$stmt->execute();
	
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
}

?>
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo  = $_POST['tipo'];

    $tabelas = [
        'administrador' => [
            'tabela'   => 'administrador',
            'id'       => 'ADM_id',
            'nome'     => 'ADM_nome',
            'email'    => 'ADM_email',
            'senha'    => 'ADM_senha',
            'redirect' => '../painel.php',
            'usaHash'  => true
        ],
        'professor' => [
            'tabela'   => 'professor',
            'id'       => 'PRO_id',
            'nome'     => 'PRO_nome',
            'email'    => 'PRO_email',
            'senha'    => 'PRO_cod',
            'redirect' => '../professor/painel.php',
            'usaHash'  => false
        ],
        'aluno' => [
            'tabela'   => 'aluno',
            'id'       => 'ALU_id',
            'nome'     => 'ALU_nome',
            'email'    => 'ALU_email',
            'senha'    => 'ALU_cod',
            'redirect' => '../aluno/painel.php',
            'usaHash'  => false
        ],
        'responsavel' => [
            'tabela'   => 'responsavel',
            'id'       => 'RES_id',
            'nome'     => 'RES_nome',
            'email'    => 'RES_email',
            'senha'    => 'RES_cod',
            'redirect' => '../responsavel/painel.php',
            'usaHash'  => false
        ]
    ];

    if (!isset($tabelas[$tipo])) {
        echo "Tipo de usuário inválido.";
        exit();
    }

    $dados = $tabelas[$tipo];

    $stmt = $conn->prepare("SELECT {$dados['id']}, {$dados['nome']}, {$dados['senha']} FROM {$dados['tabela']} WHERE {$dados['email']} = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $nome, $senhaBanco);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        if ($dados['usaHash']) {
            $valido = password_verify($senha, $senhaBanco);
        } else {
            $valido = ($senha === $senhaBanco);
        }

        if ($valido) {
            $_SESSION['user'] = $nome;
            $_SESSION['id']   = $id;
            $_SESSION['tipo'] = $tipo;
            header("Location: " . $dados['redirect']);
            exit();
        } else {
            echo "Senha inválida.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>

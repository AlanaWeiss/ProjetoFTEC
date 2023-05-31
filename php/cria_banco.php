<?php
include_once('./conexao.php');

#region Primeira tabela: tipos
$pdo->exec("
CREATE TABLE IF NOT EXISTS tipos (
    tipo TEXT PRIMARY KEY
)");
// Array com os dados a serem inseridos
$tipos = array(
    "administrador",
    "aluno",
    "professor"
);

// Loop para percorrer o array de tipos
foreach($tipos as $tipo) {
    // Verifica se o tipo já existe na tabela
    $stmt = $pdo->prepare("SELECT tipo FROM tipos WHERE tipo = ?");
    $stmt->execute([$tipo]);
    $resultado = $stmt->fetch();

    // Se o tipo não existir, insere na tabela
    if(!$resultado) {
        $stmt = $pdo->prepare("INSERT INTO tipos (tipo) VALUES (?)");
        $stmt->execute([$tipo]);
    }
}

#endregion

#region Segunda tabela: materias
$pdo->exec("
CREATE TABLE IF NOT EXISTS materias (
    materia TEXT PRIMARY KEY
)");

// Array com os dados a serem inseridos
$materias = array(
    "Artes",
    "Biologia",
    "Educação Física",
    "Filosofia",
    "Física",
    "Geografia",
    "História",
    "Inglês",
    "Matemática",
    "Português",
    "Química",
    "Sociologia"
);

// Loop para percorrer o array de materias
foreach($materias as $materia) {
    // Verifica se a materia já existe na tabela
    $stmt = $pdo->prepare("SELECT materia FROM materias WHERE materia = ?");
    $stmt->execute([$materia]);
    $resultado = $stmt->fetch();

    // Se a materia não existir, insere na tabela
    if(!$resultado) {
        $stmt = $pdo->prepare("INSERT INTO materias (materia) VALUES (?)");
        $stmt->execute([$materia]);
    }
}
#endregion

#region Terceira tabela: usuarios
$pdo->exec("
CREATE TABLE IF NOT EXISTS usuarios (
    nome TEXT PRIMARY KEY,
    email TEXT NOT NULL,
    senha TEXT NOT NULL,
    tipo TEXT NOT NULL,
    FOREIGN KEY (tipo) REFERENCES tipos(tipo)
)");

// Dados a serem inseridos
$nome = "Admin";
$email = "admin@example.com";
$senha = "admin";
$tipo = "administrador";

// Verifica se o usuário já existe na tabela
$stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE nome = ?");
$stmt->execute([$nome]);
$resultado = $stmt->fetch();

// Se o usuário não existir, insere na tabela
if(!$resultado) {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $senha, $tipo]);
}

#endregion

#region Quarta tabela: conteudos
$pdo->exec("
CREATE TABLE IF NOT EXISTS conteudos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    conteudo TEXT NOT NULL,
    nome TEXT NOT NULL,
    materia TEXT NOT NULL,
    FOREIGN KEY (nome) REFERENCES usuarios(nome),
    FOREIGN KEY (materia) REFERENCES materias(materia)
)");
#endregion

#region Quinta tabela: eventos
$pdo->exec("
CREATE TABLE IF NOT EXISTS eventos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ano INTEGER NOT NULL,
    mes INTEGER NOT NULL,
    dia INTEGER NOT NULL,
    titulo TEXT NOT NULL,
    descricao TEXT NOT NULL,
    criado_por TEXT NOT NULL
)");
#endregion

?>

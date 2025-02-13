-- Cria a base de dados
CREATE DATABASE gestao_funcionarios;

-- Seleciona a base de dados
USE gestao_funcionarios;

-- Tabela de utilizadores
CREATE TABLE utilizadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    palavra_passe VARCHAR(255) NOT NULL
);

-- Tabela de perfis
CREATE TABLE perfis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilizador_id INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    data_nascimento DATE,
    telefone VARCHAR(20),
    foto_perfil VARCHAR(255), -- Caminho da foto de perfil
    FOREIGN KEY (utilizador_id) REFERENCES utilizadores(id) ON DELETE CASCADE
);

-- Tabela de ficheiros
CREATE TABLE ficheiros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilizador_id INT NOT NULL,
    nome_ficheiro VARCHAR(255) NOT NULL,
    caminho_ficheiro VARCHAR(255) NOT NULL, -- Caminho do ficheiro no servidor
    data_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilizador_id) REFERENCES utilizadores(id) ON DELETE CASCADE
);

-- Insere um utilizador de teste (senha: "123456" em hash)
INSERT INTO utilizadores (email, palavra_passe)
VALUES (
    'ricardo.vieira@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' -- Hash da senha "123456"
);

-- Insere o perfil do utilizador de teste
INSERT INTO perfis (utilizador_id, nome, data_nascimento, telefone)
VALUES (
    1, -- ID do utilizador inserido acima
    'Ricardo Vieira',
    '1985-05-15',
    '912345678'
);
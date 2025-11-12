CREATE DATABASE loja;
commit;
USE loja;

-- Tabela de Usuários
CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL, -- Use 255 para o hash seguro (password_hash)
    perfil ENUM('cliente', 'admin') NOT NULL,
    data_cadastro DATETIME NOT NULL
);

-- Tabela de Produtos
CREATE TABLE produtos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL UNIQUE,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT 1
);

-- Tabela de Pedidos
CREATE TABLE pedidos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_pedido DATETIME NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    status ENUM('pendente', 'pago', 'enviado', 'cancelado') NOT NULL,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de Itens do Pedido (Muitos para Muitos)
CREATE TABLE itens_pedido (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
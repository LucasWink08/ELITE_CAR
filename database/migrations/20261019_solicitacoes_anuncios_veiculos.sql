USE elite;

CREATE TABLE IF NOT EXISTS solicitacoes_anuncios_veiculos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    carro_id INT UNSIGNED NULL,
    marca VARCHAR(80) NOT NULL,
    modelo VARCHAR(120) NOT NULL,
    ano SMALLINT UNSIGNED NOT NULL,
    preco DECIMAL(14, 2) NOT NULL,
    descricao TEXT NOT NULL,
    quilometragem INT UNSIGNED NOT NULL,
    cor VARCHAR(60) NOT NULL,
    combustivel VARCHAR(40) NOT NULL,
    cambio VARCHAR(60) NOT NULL,
    versao VARCHAR(100) NULL,
    motor VARCHAR(120) NOT NULL,
    potencia SMALLINT UNSIGNED NOT NULL,
    informacoes_adicionais TEXT NULL,
    fotos_json LONGTEXT NOT NULL,
    documento_crlv_path VARCHAR(500) NOT NULL,
    documento_extra_path VARCHAR(500) NULL,
    status ENUM('em_analise', 'aprovado', 'rejeitado') NOT NULL DEFAULT 'em_analise',
    admin_observacao VARCHAR(1000) NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    revisado_em DATETIME NULL,
    INDEX idx_anuncios_usuario_data (usuario_id, criado_em),
    INDEX idx_anuncios_status_data (status, criado_em),
    UNIQUE KEY uq_anuncios_carro (carro_id),
    CONSTRAINT fk_anuncios_usuario FOREIGN KEY (usuario_id)
        REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_anuncios_carro FOREIGN KEY (carro_id)
        REFERENCES carros (id) ON DELETE SET NULL
);

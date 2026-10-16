USE luxcars;

SET @luxcars_tipo_existe = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'usuarios' AND COLUMN_NAME = 'tipo'
);
SET @luxcars_sql = IF(
    @luxcars_tipo_existe = 0,
    'ALTER TABLE usuarios ADD COLUMN tipo ENUM(''cliente'', ''admin'') NOT NULL DEFAULT ''cliente'' AFTER senha_hash',
    'SELECT 1'
);
PREPARE luxcars_stmt FROM @luxcars_sql;
EXECUTE luxcars_stmt;
DEALLOCATE PREPARE luxcars_stmt;

CREATE TABLE IF NOT EXISTS favoritos (
    usuario_id INT UNSIGNED NOT NULL,
    carro_id INT UNSIGNED NOT NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, carro_id),
    CONSTRAINT fk_favoritos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_favoritos_carro FOREIGN KEY (carro_id) REFERENCES carros (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS comparacao_carros (
    usuario_id INT UNSIGNED NOT NULL,
    carro_id INT UNSIGNED NOT NULL,
    adicionado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, carro_id),
    CONSTRAINT fk_comparacao_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_comparacao_carro FOREIGN KEY (carro_id) REFERENCES carros (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS historico_visualizacoes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    carro_id INT UNSIGNED NOT NULL,
    visualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_historico_usuario_data (usuario_id, visualizado_em),
    CONSTRAINT fk_historico_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_historico_carro FOREIGN KEY (carro_id) REFERENCES carros (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS intencoes_compra (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    carro_id INT UNSIGNED NOT NULL,
    mensagem VARCHAR(1000) NULL,
    status ENUM('nova', 'em_atendimento', 'concluida', 'cancelada') NOT NULL DEFAULT 'nova',
    criada_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_intencoes_usuario_data (usuario_id, criada_em),
    CONSTRAINT fk_intencoes_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_intencoes_carro FOREIGN KEY (carro_id) REFERENCES carros (id) ON DELETE CASCADE
);

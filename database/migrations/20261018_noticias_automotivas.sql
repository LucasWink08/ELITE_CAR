USE elite;

CREATE TABLE IF NOT EXISTS noticias_automotivas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apitube_id VARCHAR(64) NOT NULL UNIQUE,
    titulo VARCHAR(500) NOT NULL,
    descricao TEXT NULL,
    imagem_url TEXT NULL,
    url_original TEXT NOT NULL,
    fonte VARCHAR(255) NULL,
    idioma VARCHAR(12) NOT NULL DEFAULT 'pt',
    publicado_em DATETIME NULL,
    dados_json LONGTEXT NOT NULL,
    sincronizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_noticias_publicado (publicado_em, sincronizado_em)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS noticias_automotivas_sync (
    id TINYINT UNSIGNED NOT NULL PRIMARY KEY,
    ultima_tentativa_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

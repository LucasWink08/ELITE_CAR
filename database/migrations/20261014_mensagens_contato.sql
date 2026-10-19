USE elite;

CREATE TABLE IF NOT EXISTS mensagens_contato (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    assunto VARCHAR(160) NOT NULL,
    mensagem TEXT NOT NULL,
    status ENUM('nova', 'lida', 'respondida') NOT NULL DEFAULT 'nova',
    recebida_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_contato_status_data (status, recebida_em)
);

USE elite;

-- Tabela para solicitações de test drive. Execute uma vez em bancos existentes.
CREATE TABLE IF NOT EXISTS agendamentos_test_drive (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NULL,
    carro_id INT UNSIGNED NOT NULL,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    data_agendamento DATE NOT NULL,
    horario TIME NOT NULL,
    status ENUM('solicitado', 'confirmado', 'concluido', 'cancelado') NOT NULL DEFAULT 'solicitado',
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_test_drive_carro_horario (carro_id, data_agendamento, horario),
    INDEX idx_test_drive_status_data (status, data_agendamento),
    CONSTRAINT fk_test_drive_usuario FOREIGN KEY (usuario_id)
        REFERENCES usuarios (id) ON DELETE SET NULL,
    CONSTRAINT fk_test_drive_carro FOREIGN KEY (carro_id)
        REFERENCES carros (id) ON DELETE CASCADE
);

CREATE DATABASE IF NOT EXISTS luxcars
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE luxcars;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    endereco VARCHAR(180) NOT NULL,
    numero_endereco VARCHAR(20) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente',
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

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

CREATE TABLE IF NOT EXISTS carros (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(80) NOT NULL,
    modelo VARCHAR(120) NOT NULL,
    ano SMALLINT UNSIGNED NOT NULL,
    preco DECIMAL(14, 2) NOT NULL,
    imagem VARCHAR(255) NULL,
    descricao TEXT NULL,
    quilometragem INT UNSIGNED NULL,
    cor VARCHAR(60) NULL,
    combustivel VARCHAR(40) NULL,
    cambio VARCHAR(60) NULL,
    versao VARCHAR(100) NULL,
    informacoes_adicionais TEXT NULL,
    status ENUM('disponivel', 'indisponivel', 'vendido') NOT NULL DEFAULT 'disponivel',
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_carros_status (status),
    INDEX idx_carros_marca_modelo (marca, modelo)
);

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

CREATE TABLE IF NOT EXISTS carrinho (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    carro_id INT UNSIGNED NOT NULL,
    quantidade TINYINT UNSIGNED NOT NULL DEFAULT 1,
    adicionado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_carrinho_usuario_carro (usuario_id, carro_id),
    CONSTRAINT fk_carrinho_usuario FOREIGN KEY (usuario_id)
        REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_carrinho_carro FOREIGN KEY (carro_id)
        REFERENCES carros (id) ON DELETE CASCADE
);

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

INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais, status)
SELECT 'BMW', 'X6 Competition', 2023, 899000.00, 'assets/imagens/cars/bmw/2020-bmw-x6-m-competition-1.webp', 'SUV esportivo com motor V8 biturbo.', 12000, 'Preto', 'Gasolina', 'Automático', 'M Competition', 'Tração integral e acabamento esportivo M.', 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'X6 Competition');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais, status)
SELECT 'Audi', 'R8 GT', 2023, 1250000.00, 'assets/imagens/cars/destaques/r8v10.webp', 'Esportivo V10 de alto desempenho.', 3500, 'Cinza', 'Gasolina', 'Automatizado', 'GT', 'Motor V10 e tração quattro.', 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'R8 GT');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais, status)
SELECT 'Ferrari', '488 GTB', 2017, 3490000.00, 'assets/imagens/cars/ferrari/300px-2017_Ferrari_488_GTB_Automatic_3.9.jpg', 'Cupê esportivo com motor V8 biturbo.', 8600, 'Vermelho', 'Gasolina', 'Automatizado', 'GTB', 'Câmbio de dupla embreagem e tração traseira.', 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = '488 GTB');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais, status)
SELECT 'Porsche', '911 GT2 RS', 2018, 2800000.00, 'assets/imagens/cars/porsche/porsche-911-gt2-rs.jpg', 'Esportivo de alto desempenho da linha 911.', 5200, 'Branco', 'Gasolina', 'Automatizado', 'GT2 RS', 'Motor boxer biturbo e tração traseira.', 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = '911 GT2 RS');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais, status)
SELECT 'Mercedes-Benz', 'AMG GT 63 S', 2022, 1650000.00, 'assets/imagens/cars/mercedes/amggt63s.jpg', 'Sedã esportivo com preparação AMG.', 14000, 'Preto', 'Gasolina', 'Automático', '4MATIC+', 'Tração integral e pacote de desempenho AMG.', 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'AMG GT 63 S');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais, status)
SELECT 'Lamborghini', 'Huracán', 2022, 3900000.00, 'assets/imagens/cars/lamborghini/huracen2018.jpg', 'Superesportivo italiano com motor V10.', 4100, 'Amarelo', 'Gasolina', 'Automatizado', 'EVO', 'Tração integral e modos de condução selecionáveis.', 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'Huracán');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais, status)
SELECT 'McLaren', '720S', 2021, 3200000.00, 'assets/imagens/cars/mclaren/720S-Coupe_hero_crop-16x9.webp', 'Supercarro leve com motor V8 biturbo.', 6000, 'Laranja', 'Gasolina', 'Automatizado', 'Performance', 'Monocoque de fibra de carbono e tração traseira.', 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = '720S');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, cor, combustivel, cambio, versao, informacoes_adicionais, status)
SELECT 'Koenigsegg', 'Jesko', 2023, 18000000.00, 'assets/imagens/cars/koenigsegg/Koenigsegg_Jesko_Genf_2019_1Y7A5546.jpg', 'Hipercarro de produção limitada.', 900, 'Prata', 'Gasolina', 'Automatizado', 'Attack', 'Unidade de produção limitada com aerodinâmica de pista.', 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'Jesko');


-- Catalogo completo de anuncios cadastrados nas paginas das marcas.
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'r8 gt', 2022, 1850000.00, 'assets/imagens/cars/audi/2023-audi-r8-gt-front-three-quarters-motion-3-1664827965.avif', 'Motor : 5.2L V10 atmosférico Potência : 560 cv Aceleração 0-100 km/h : Aproximadamente 3,6 segundos Velocidade máxima : 320 km/h', 30000, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'r8 gt' AND ano = 2022 AND imagem = 'assets/imagens/cars/audi/2023-audi-r8-gt-front-three-quarters-motion-3-1664827965.avif');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'rs6 avant', 2022, 1350000.00, 'assets/imagens/cars/audi/audi-rs6-avant-gt.jpg', 'Motor : 4.0L V8 biturbo Potência : 600 cv Aceleração 0-100 km/h : Aproximadamente 3,5 segundos Velocidade máxima : 320 km/h', 35550, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'rs6 avant' AND ano = 2022 AND imagem = 'assets/imagens/cars/audi/audi-rs6-avant-gt.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'tt rs', 2019, 455800.00, 'assets/imagens/cars/audi/audi-tt rs.jpg', 'Motor : 2.5L 5 cilindros turboalimentado Potência : 400 cv Aceleração 0-100 km/h : Aproximadamente 3,7 segundos Velocidade máxima : 280 km/h', 21000, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'tt rs' AND ano = 2019 AND imagem = 'assets/imagens/cars/audi/audi-tt rs.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'mtm rs6 evo', 2019, 1500000.00, 'assets/imagens/cars/audi/mtmrs6evo.jpg', 'Motor : 4.0L V8 biturbo, modificado Potência : 1.000 cv Aceleração 0-100 km/h : Aproximadamente 3,0 segundos Velocidade máxima : Acima de 330 km/h', 22500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'mtm rs6 evo' AND ano = 2019 AND imagem = 'assets/imagens/cars/audi/mtmrs6evo.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'rs6 avant', 2023, 1400000.00, 'assets/imagens/cars/audi/nova-audi-rs6-avant-performance-frente.webp', 'Motor : 4.0L V8 biturbo Potência : 600 cv Aceleração 0-100 km/h : Aproximadamente 3,5 segundos Velocidade máxima : 280 km/h (limitada eletronicamente)', 15450, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'rs6 avant' AND ano = 2023 AND imagem = 'assets/imagens/cars/audi/nova-audi-rs6-avant-performance-frente.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'rs3 Sportback', 2021, 450000.00, 'assets/imagens/cars/audi/RS3 Sportback 12021.jpg', 'Motor : 2.5L 5 cilindros turboalimentado Potência : 400 cv Aceleração 0-100 km/h : Aproximadamente 3,8 segundos Velocidade máxima : 320 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'rs3 Sportback' AND ano = 2021 AND imagem = 'assets/imagens/cars/audi/RS3 Sportback 12021.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'rs4 avant', 2021, 700000.00, 'assets/imagens/cars/audi/rs4-avant_2.jpg', 'Motor : 2.9L V6 biturbo Potência : 450 cv Aceleração 0-100 km/h : Aproximadamente 4,1 segundos Velocidade máxima : 250 km/h (limitada eletronicamwnte)', 45000, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'rs4 avant' AND ano = 2021 AND imagem = 'assets/imagens/cars/audi/rs4-avant_2.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'rs7', 2024, 1200000.00, 'assets/imagens/cars/audi/rs7 2025.avif', 'Motor : 4.0L V8 biturbo Potência : 600 cv Aceleração 0-100 km/h : Aproximadamente 3,6 segundos Velocidade máxima : 250 km/h (limitada eletronicamente)', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'rs7' AND ano = 2024 AND imagem = 'assets/imagens/cars/audi/rs7 2025.avif');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'r8', 2018, 1250000.00, 'assets/imagens/cars/audi/image.png', 'Motor : 5.2L V10 atmosférico Potência : 560 cv Aceleração 0-100 km/h : Aproximadamente 3,6 segundos Velocidade máxima : 320 km/h', 560, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'r8' AND ano = 2018 AND imagem = 'assets/imagens/cars/audi/image.png');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Audi', 'rs3', 2015, 450000.00, 'assets/imagens/cars/audi/rs32025.png', 'Motor : 5.2L V10 atmosférico Potência : 560 cv Aceleração 0-100 km/h : Aproximadamente 3,6 segundos Velocidade máxima : 320 km/h', 42500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Audi' AND modelo = 'rs3' AND ano = 2015 AND imagem = 'assets/imagens/cars/audi/rs32025.png');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'i8 motor híbrido', 2021, 1100000.00, 'assets/imagens/cars/bmw/bmw i8.webp', 'Motor: Híbrido Potência: 362 cv Aceleração 0-100 km/h: 4,4 segundos Velocidade máxima: 250 km/h', 10000, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'i8 motor híbrido' AND ano = 2021 AND imagem = 'assets/imagens/cars/bmw/bmw i8.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'x6 competition', 2023, 630000.00, 'assets/imagens/cars/bmw/2020-bmw-x6-m-competition-1.webp', 'Motor : V8 biturbo de 4,4 litros Potência : 617 cv Aceleração 0-100 km/h : 3,8 segundos Velocidade máxima : 250 km/h (limitada eletronicamente)', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'x6 competition' AND ano = 2023 AND imagem = 'assets/imagens/cars/bmw/2020-bmw-x6-m-competition-1.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'm5 cs v8 biturbo', 2022, 900000.00, 'assets/imagens/cars/bmw/BMW M5 CS.webp', 'Motor:V8 biturbo de 4,4 litros Potência : 635 cv Aceleração 0-100 km/h : 3,0 segundos Velocidade máxima : 305 km/h (limitada eletronicamente)', 9000, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'm5 cs v8 biturbo' AND ano = 2022 AND imagem = 'assets/imagens/cars/bmw/BMW M5 CS.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'i7 m70 xdrive', 2023, 1350000.00, 'assets/imagens/cars/bmw/bmw-i7-m70.jpg', 'Motor : Elétrico Potência:660 cv Aceleração 0-100 km/h : 3,7 segundos Velocidade máxima : 250 km/h', 0, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'i7 m70 xdrive' AND ano = 2023 AND imagem = 'assets/imagens/cars/bmw/bmw-i7-m70.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'x4 m40i', 2021, 500000.00, 'assets/imagens/cars/bmw/BMW-X4-M40i-Individual_1.jpg', 'Motor : 3.0L turboalimentado I6 Potência : 382 cv Aceleração 0-100 km/h : 4,4 segundos Velocidade máxima : 250 km/h (limitada eletronicamente)', 0, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'x4 m40i' AND ano = 2021 AND imagem = 'assets/imagens/cars/bmw/BMW-X4-M40i-Individual_1.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'm3 g80cs', 2021, 950000.00, 'assets/imagens/cars/bmw/BMWM3G80CS.png', 'Motor : 3.0L turboalimentado I6 Potência : 543 cv Aceleração 0-100 km/h : 3,4 segundos Velocidade máxima : 302 km/h (limitada eletronicamente)', 0, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'm3 g80cs' AND ano = 2021 AND imagem = 'assets/imagens/cars/bmw/BMWM3G80CS.png');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'm8 gran coupe', 2023, 1150000.00, 'assets/imagens/cars/bmw/bmwm8grancoupe.webp', 'Motor : 4.4L V8 biturbo Potência : 617 cv Aceleração 0-100 km/h : 3,1 segundos Velocidade máxima : 250 km/h (limitada eletronicamente)', 10500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'm8 gran coupe' AND ano = 2023 AND imagem = 'assets/imagens/cars/bmw/bmwm8grancoupe.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'm4', 2023, 630000.00, 'assets/imagens/cars/bmw/m4competition.jpg', 'Motor : 3.0L turboalimentado I6 Potência : 473 cv Aceleração 0-100 km/h : 4,1 segundos Velocidade máxima : 250 km/h', 7000, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'm4' AND ano = 2023 AND imagem = 'assets/imagens/cars/bmw/m4competition.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'm4 gts', 2017, 1100000.00, 'assets/imagens/cars/bmw/M4gts.jpg', 'Motor : 3.0L turboalimentado I6 Potência : 493 cv Aceleração 0-100 km/h : 3,7 segundos Velocidade máxima : 305 km/h', 8900, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'm4 gts' AND ano = 2017 AND imagem = 'assets/imagens/cars/bmw/M4gts.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'BMW', 'm5', 2021, 920990.00, 'assets/imagens/cars/bmw/G90 BMW M5 saloon-13.webp', 'Motor : 4.4L V8 biturbo Potência : 625 cv Aceleração 0-100 km/h : 3,3 segundos Velocidade máxima : 250 km/h', 13445, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'BMW' AND modelo = 'm5' AND ano = 2021 AND imagem = 'assets/imagens/cars/bmw/G90 BMW M5 saloon-13.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'divo', 2021, 40000000.00, 'assets/imagens/cars/bugatti/2018-08-24-bugatti-divo-37.avif', 'Motor: 8.0L W16 quad-turbo Potência: 1.500 cv Aceleração 0-100 km/h: Aproximadamente 2,4 segundos Velocidade máxima: 380 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'divo' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/2018-08-24-bugatti-divo-37.avif');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'veyron', 2021, 7150000.00, 'assets/imagens/cars/bugatti/veyron.jpg', 'Motor: 8.0L W16 quad-turbo Potência: 1.001 cv Aceleração 0-100 km/h: Aproximadamente 2,5 segundos Velocidade máxima: 407 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'veyron' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/veyron.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'chiron', 2020, 35000000.00, 'assets/imagens/cars/bugatti/bugatti-chiron-super-sport-2021.webp', 'Motor: 8.0L W16 quad-turbo Potência: 1.500 cv Aceleração 0-100 km/h: Aproximadamente 2,5 segundos Velocidade máxima: 420 km/h', NULL, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'chiron' AND ano = 2020 AND imagem = 'assets/imagens/cars/bugatti/bugatti-chiron-super-sport-2021.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'veyron', 2021, 6000000.00, 'assets/imagens/cars/bugatti/Bugatti-Veyron-2015 (1).jpg', 'Motor: 8.0L W16 quad-turbo Potência: 1.001 cv Aceleração 0-100 km/h: Aproximadamente 2,5 segundos Velocidade máxima: 407 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'veyron' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/Bugatti-Veyron-2015 (1).jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'w16 mistral', 2021, 30000000.00, 'assets/imagens/cars/bugatti/Bugatti-W16_Mistral-2024-1280-f3cc71974aebcc89ec019de660555c0652.webp', 'Motor: 8.0L W16 quad-turbo Potência: 1.600 cv Aceleração 0-100 km/h: Aproximadamente 2,5 segundos Velocidade máxima: 420 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'w16 mistral' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/Bugatti-W16_Mistral-2024-1280-f3cc71974aebcc89ec019de660555c0652.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'centodieci', 2021, 40000000.00, 'assets/imagens/cars/bugatti/centodieci.webp', 'Motor: 8.0L W16 quad-turbo Potência: 1.600 cv Aceleração 0-100 km/h: Aproximadamente 2,4 segundos Velocidade máxima: 380 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'centodieci' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/centodieci.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'chiron', 2021, 1150000.00, 'assets/imagens/cars/bugatti/chiron.webp', 'Motor: 8.0L W16 quad-turbo Potência: 1.500 cv Aceleração 0-100 km/h: Aproximadamente 2,5 segundos Velocidade máxima: 420 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'chiron' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/chiron.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'eb110', 2021, 2500000.00, 'assets/imagens/cars/bugatti/eb110.jpg', 'Motor: 3.5L V12 quad-turbo Potência: 560 cv Aceleração 0-100 km/h: Aproximadamente 3,2 segundos Velocidade máxima: 343 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'eb110' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/eb110.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'la voiture noire', 2021, 70000000.00, 'assets/imagens/cars/bugatti/lavoityre.webp', 'Motor: 8.0L W16 quad-turbo Potência: 1.500 cv Aceleração 0-100 km/h: Aproximadamente 2,5 segundos Velocidade máxima: 420 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'la voiture noire' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/lavoityre.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Bugatti', 'divo', 2021, 40000000.00, 'assets/imagens/cars/bugatti/divo2.jpg', 'Motor: 8.0L W16 quad-turbo Potência: 1.500 cv Aceleração 0-100 km/h: Aproximadamente 2,4 segundos Velocidade máxima: 380 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Bugatti' AND modelo = 'divo' AND ano = 2021 AND imagem = 'assets/imagens/cars/bugatti/divo2.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', '488 gtb', 2017, 4490000.00, 'assets/imagens/cars/ferrari/ferrarr.webp', 'Motor:V8 biturbo de 670 cv Aceleração: 0-100 km/h em 3,0 segundos Velocidade máxima de 330 km/h', 15250, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = '488 gtb' AND ano = 2017 AND imagem = 'assets/imagens/cars/ferrari/ferrarr.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', 'f40 v8 biturbo', 2021, 10540990.00, 'assets/imagens/cars/ferrari/f40.webp', 'Motor:V8 2.9L turbo de 478 cv Aceleração: 0-100 km/h em 3,8 segundos Velocidade máxima de 324 km/h', 50000, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = 'f40 v8 biturbo' AND ano = 2021 AND imagem = 'assets/imagens/cars/ferrari/f40.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', 'f8 spider', 2022, 5399990.00, 'assets/imagens/cars/ferrari/f8spider.jpg', 'Motor:V8 biturbo de 710 cv Aceleração: 0-100 km/h em 2,9 segundos Velocidade máxima de 340 km/h', 0, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = 'f8 spider' AND ano = 2022 AND imagem = 'assets/imagens/cars/ferrari/f8spider.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', '458 itália', 2015, 3340000.00, 'assets/imagens/cars/ferrari/Ferrari 458 Italia.jpg', 'Motor:V8 de 570 cv Aceleração: 0-100 km/h em 3,4 segundos Velocidade máxima de 325 km/h', 2500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = '458 itália' AND ano = 2015 AND imagem = 'assets/imagens/cars/ferrari/Ferrari 458 Italia.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', '488 pista', 2017, 6220000.00, 'assets/imagens/cars/ferrari/ferrari-488 pista.jpg', 'Motor:V8 biturbo de 720 cv Aceleração: 0-100 km/h em 2,9 segundos Velocidade máxima de 340 km/h', 1500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = '488 pista' AND ano = 2017 AND imagem = 'assets/imagens/cars/ferrari/ferrari-488 pista.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', 'purosangue', 2022, 7200000.00, 'assets/imagens/cars/ferrari/ferrari-purosangue-divulgacao1.jpg', 'Motor:V12 de 725 cv Aceleração: 0-100 km/h em 3,3 segundos Velocidade máxima de 310 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = 'purosangue' AND ano = 2022 AND imagem = 'assets/imagens/cars/ferrari/ferrari-purosangue-divulgacao1.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', '296 gtb', 2021, 3500000.00, 'assets/imagens/cars/ferrari/Ferrari296gtb.webp', 'Motor:V6 híbrido de 830 cv Aceleração: 0-100 km/h em 2,9 segundos Velocidade máxima de 330 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = '296 gtb' AND ano = 2021 AND imagem = 'assets/imagens/cars/ferrari/Ferrari296gtb.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', 'fxxk evo', 2021, 18000000.00, 'assets/imagens/cars/ferrari/Ferrari_FXX_K_Evo.webp', 'Motor:V12 de 1050 cv Aceleração: 0-100 km/h em 2,5 segundos Velocidade máxima de 350 km/h', 0, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = 'fxxk evo' AND ano = 2021 AND imagem = 'assets/imagens/cars/ferrari/Ferrari_FXX_K_Evo.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', 'la ferrari', 2024, 12560000.00, 'assets/imagens/cars/ferrari/laferrari.jpg', 'Motor:V12 naturalmente aspirado de 800 cv Aceleração: 0-100 km/h em 2,6 segundos Velocidade máxima de 350 km/h', 0, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = 'la ferrari' AND ano = 2024 AND imagem = 'assets/imagens/cars/ferrari/laferrari.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Ferrari', 'sf90', 2023, 6230000.00, 'assets/imagens/cars/ferrari/novitec-ferrari-sf90-stradale-2022.webp', 'Motor:V8 biturbo de 1000 cv Aceleração: 0-100 km/h em 2,5 segundos Velocidade máxima de 340 km/h', 0, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Ferrari' AND modelo = 'sf90' AND ano = 2023 AND imagem = 'assets/imagens/cars/ferrari/novitec-ferrari-sf90-stradale-2022.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'agera "odin"', 2021, 12766000.00, 'assets/imagens/cars/koenigsegg/agera.webp', 'Motor : 5.0L V8 biturbo Potência : De 1.000 cv Aceleração 0-100 km/h : Aproximadamente 2,8 segundos Velocidade máxima : Acima de 450 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'agera "odin"' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/agera.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'CC850', 2021, 15890900.00, 'assets/imagens/cars/koenigsegg/CC850.webp', 'Motor : 5.0L V8 biturbo Potência : 1.185 cv Aceleração 0-100 km/h : Aproximadamente 2,8 segundos Velocidade máxima : Acima de 400 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'CC850' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/CC850.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'ccx', 2021, 6000000.00, 'assets/imagens/cars/koenigsegg/ccx.jpg', 'Motor : 4.7L V8 biturbo Potência : 806 cv Aceleração 0-100 km/h : Aproximadamente 3,2 segundos Velocidade máxima : Acima de 400 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'ccx' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/ccx.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'jesko "golden"', 2021, 14340000.00, 'assets/imagens/cars/destaques/golden.jpg', 'Motor : 5.0L V8 biturbo Potência : Até 1.600 cv Aceleração 0-100 km/h : Aproximadamente 2,5 segundos Velocidade máxima : Acima de 480 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'jesko "golden"' AND ano = 2021 AND imagem = 'assets/imagens/cars/destaques/golden.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'jesko odin', 2021, 17000000.00, 'assets/imagens/cars/koenigsegg/Jesko+Odin+Front.jpg', 'Motor : 5.0L V8 biturbo Potência : Até 1.600 cv Aceleração 0-100 km/h : Aproximadamente 2,5 segundos Velocidade máxima : Acima de 430 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'jesko odin' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/Jesko+Odin+Front.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'one 1', 2021, 13000990.00, 'assets/imagens/cars/koenigsegg/one1.webp', 'Motor : 5.0L V8 biturbo Potência : 1.341 cv Aceleração 0-100 km/h : Aproximadamente 2,8 segundos Velocidade máxima : Aproximadamente 450 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'one 1' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/one1.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'ragera', 2021, 18000000.00, 'assets/imagens/cars/koenigsegg/ragera.jpg', 'Motor : 5.0L V8 biturbo + 3 motores elétricos Potência : 1.500 cv Aceleração 0-100 km/h : Aproximadamente 2,8 segundos Velocidade máxima : Acima de 400 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'ragera' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/ragera.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'agera R', 2021, 17000000.00, 'assets/imagens/cars/koenigsegg/ageraR.jpg', 'Motor : 5.0L V8 biturbo Potência : 1.160 cv Aceleração 0-100 km/h : Aproximadamente 2,8 segundos Velocidade máxima : Aproximadamente 440 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'agera R' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/ageraR.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'jesko', 2021, 19990000.00, 'assets/imagens/cars/koenigsegg/Koenigsegg_Jesko_Genf_2019_1Y7A5546.jpg', 'Motor : 5.0L V8 biturbo Potência : Até 1.600 cv Aceleração 0-100 km/h : Aproximadamente 2,5 segundos Velocidade máxima : Acima de 430 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'jesko' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/Koenigsegg_Jesko_Genf_2019_1Y7A5546.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Koenigsegg', 'jesko absolut', 2021, 20000000.00, 'assets/imagens/cars/koenigsegg/jeskoabsolut.png', 'Motor : 5.0L V8 biturbo Potência : Até 1.600 cv Aceleração 0-100 km/h : Aproximadamente 2,5 segundos Velocidade máxima : Acima de 480 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Koenigsegg' AND modelo = 'jesko absolut' AND ano = 2021 AND imagem = 'assets/imagens/cars/koenigsegg/jeskoabsolut.png');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'revuelto', 2021, 8000000.00, 'assets/imagens/cars/lamborghini/2024-lamborghini-revuelto-110-651719c597ac8.avif', 'Motor : 6.5L V12 atmosférico, combinado com 3 motores elétricos Potência : 1.001 cv Aceleração 0-100 km/h : Aceleração de 0 a 100 km/h em menos de 2,5 segundos Velocidade máxima : Aproximadamente 350 km/h/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'revuelto' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/2024-lamborghini-revuelto-110-651719c597ac8.avif');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'aventador', 2021, 2525000.00, 'assets/imagens/cars/lamborghini/aventador2021.jpg', 'Motor : 6.5L V12 atmosférico Potência : 730 cv Aceleração 0-100 km/h : 2,9 segundos Velocidade máxima : 350 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'aventador' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/aventador2021.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'huracan', 2021, 1300000.00, 'assets/imagens/cars/lamborghini/huracen2018.jpg', 'Motor : 5.2L V10 atmosférico Potência : 640 cv Aceleração 0-100 km/h : 2,9 segundos Velocidade máxima : 325 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'huracan' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/huracen2018.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'revuelto', 2021, 9770700.00, 'assets/imagens/cars/lamborghini/lambo-revuelto-1.webp', 'Motor : 6.5L V12 atmosférico, combinado com 3 motores elétricos Potência : 1.001 cv Aceleração 0-100 km/h : Aceleração de 0 a 100 km/h em menos de 2,5 segundos Velocidade máxima : Aproximadamente 350 km/h/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'revuelto' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/lambo-revuelto-1.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'aventador', 2021, 3300890.00, 'assets/imagens/cars/lamborghini/inovacoes-que-o-Lamborghini-Aventador.jpg', 'Motor : 6.5L V12 atmosférico Potência : 730 cv Aceleração 0-100 km/h : 2,9 segundos Velocidade máxima : 350 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'aventador' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/inovacoes-que-o-Lamborghini-Aventador.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'gallardo', 2021, 1110000.00, 'assets/imagens/cars/lamborghini/lamborghini-gallardo-5795139_1280.jpg', 'Motor : 5.2L V10 atmosférico Potência : 560 cv Aceleração 0-100 km/h : 3,7 segundos Velocidade máxima : 320 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'gallardo' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/lamborghini-gallardo-5795139_1280.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'urus', 2021, 1487990.00, 'assets/imagens/cars/lamborghini/lamborghini-urus-s.jpg', 'Motor : 4.0L V8 biturbo Potência : 650 cv Aceleração 0-100 km/h : 3,6 segundos Velocidade máxima : 305 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'urus' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/lamborghini-urus-s.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'veneno', 2021, 35670900.00, 'assets/imagens/cars/lamborghini/lamborghini-veneno-6.webp', 'Motor : 6.5L V12 atmosférico Potência : 750 cv Aceleração 0-100 km/h : 2,8 segundos Velocidade máxima : 355 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'veneno' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/lamborghini-veneno-6.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'urus', 2021, 3335890.00, 'assets/imagens/cars/lamborghini/urus2024.jpg', 'Motor : 4.0L V8 biturbo Potência : 650 cv Aceleração 0-100 km/h : 3,6 segundos Velocidade máxima : 305 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'urus' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/urus2024.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Lamborghini', 'huracan', 2021, 1275000.00, 'assets/imagens/cars/lamborghini/lamborghini-huracan-sto.jpg', 'Motor : 5.2L V10 atmosférico Potência : 640 cv Aceleração 0-100 km/h : 2,9 segundos Velocidade máxima : 325 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Lamborghini' AND modelo = 'huracan' AND ano = 2021 AND imagem = 'assets/imagens/cars/lamborghini/lamborghini-huracan-sto.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', '650s', 2021, 2750000.00, 'assets/imagens/cars/mclaren/659scan-amspider.webp', 'Motor : 3.8L V8 biturbo Potência : 650 cv Aceleração 0-100 km/h : 3,0 segundos Velocidade máxima : 333 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = '650s' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/659scan-amspider.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', '720s', 2021, 3335890.00, 'assets/imagens/cars/mclaren/720S-Coupe_hero_crop-16x9.webp', 'Motor : 4.0L V8 biturbo Potência : 720 cv Aceleração 0-100 km/h : 2,7 segundos Velocidade máxima : 341 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = '720s' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/720S-Coupe_hero_crop-16x9.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', '765lt', 2021, 4550000.00, 'assets/imagens/cars/mclaren/765lt.webp', 'Motor : 4.0L V8 biturbo Potência : 765 cv Aceleração 0-100 km/h : 2,8 segundos Velocidade máxima : 330 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = '765lt' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/765lt.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', 'f1', 2021, 20000000.00, 'assets/imagens/cars/mclaren/f1.webp', 'Motor : 6.1L V12 Potência : 627 cv Aceleração 0-100 km/h : 3,2 segundos Velocidade máxima : 391 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = 'f1' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/f1.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', 'senna', 2021, 11500000.00, 'assets/imagens/cars/mclaren/McLaren_Senna_Genf_2018.jpg', 'Motor : 4.0L V8 biturbo Potência : 800 cv Aceleração 0-100 km/h : 2,8 segundos Velocidade máxima : 335 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = 'senna' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/McLaren_Senna_Genf_2018.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', 'senna gtr', 2021, 15000000.00, 'assets/imagens/cars/mclaren/McLaren_Senna_GTR_Image_Front_Three_Quarters_crop-2x1.webp', 'Motor : 4.0L V8 biturbo Potência : 825 cv Aceleração 0-100 km/h : 2,8 segundos Velocidade máxima : 335 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = 'senna gtr' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/McLaren_Senna_GTR_Image_Front_Three_Quarters_crop-2x1.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', 'p1', 2021, 16000000.00, 'assets/imagens/cars/mclaren/MClarneP1.jpg', 'Motor : 3.8L V8 biturbo + motor elétrico (híbrido) Potência : 903 cv Aceleração 0-100 km/h : 2,8 segundos Velocidade máxima : 350 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = 'p1' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/MClarneP1.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', 'p1 gtr', 2021, 20000000.00, 'assets/imagens/cars/mclaren/p1gtr.webp', 'Motor : 3.8L V8 biturbo + motor elétrico (híbrido) Potência : 1.000 cv Aceleração 0-100 km/h : 2,6 segundos Velocidade máxima : 355 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = 'p1 gtr' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/p1gtr.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', 'solus gt', 2021, 19990000.00, 'assets/imagens/cars/mclaren/solusgt.webp', 'Motor : 5.2L V10 atmosférico Potência : Aproximadamente 840 cv Aceleração 0-100 km/h : Menos de 2,5 segundos Velocidade máxima : 322 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = 'solus gt' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/solusgt.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'McLaren', 'speedtail', 2021, 20000000.00, 'assets/imagens/cars/mclaren/speedtail.jpg', 'Motor : 4.0L V8 biturbo + motor elétrico Potência : 1.035 cv Aceleração 0-100 km/h : 3,0 segundos Velocidade máxima : 403 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'McLaren' AND modelo = 'speedtail' AND ano = 2021 AND imagem = 'assets/imagens/cars/mclaren/speedtail.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes amg e63s', 2021, 920000.00, 'assets/imagens/cars/mercedes/2023-mercedes-amg-e63-s-4matic-103-1671563913.avif', 'Motor : 4.0L V8 biturbo Potência : 612 cv Aceleração 0-100 km/h : 3,4 segundos Velocidade máxima : 300 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes amg e63s' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/2023-mercedes-amg-e63-s-4matic-103-1671563913.avif');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes a200amg', 2021, 240000.00, 'assets/imagens/cars/mercedes/a200amg.jpg', 'Motor : 1.3L 4 cilindros turbo Potência : 163 cv Aceleração 0-100 km/h : Aproximadamente 8,1 segundos Velocidade máxima : 225 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes a200amg' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/a200amg.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes amg gt r pro', 2021, 1990900.00, 'assets/imagens/cars/mercedes/amg gtr pro2018.webp', 'Motor : 4.0L V8 biturbo Potência : 585 cv Aceleração 0-100 km/h : Aproximadamente 3,5 segundos Velocidade máxima : 318 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes amg gt r pro' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/amg gtr pro2018.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes amg cle53', 2021, 670000.00, 'assets/imagens/cars/mercedes/AMGcle53.jpg', 'Motor : 3.0L 6 cilindros em linha turboalimentado com sistema híbrido leve (EQ Boost) Potência : 435 cv Aceleração 0-100 km/h : Aproximadamente 4,5 segundos Velocidade máxima : 250 km/h (limitada eletronicamente)', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes amg cle53' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/AMGcle53.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes amg gt63s', 2021, 1355000.00, 'assets/imagens/cars/mercedes/amggt63s.jpg', 'Motor : 4.0L V8 biturbo Potência : 639 cv Aceleração 0-100 km/h : Aproximadamente 3,2 segundos Velocidade máxima : 315 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes amg gt63s' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/amggt63s.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes c300', 2021, 300000.00, 'assets/imagens/cars/mercedes/c300.jpg', 'Motor : 2.0L 4 cilindros turbo Potência : 258 cv Aceleração 0-100 km/h : Aproximadamente 6,0 segundos Velocidade máxima : 250 km/h (limitada eletronicamente)', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes c300' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/c300.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes cls63amg', 2021, 1090000.00, 'assets/imagens/cars/mercedes/cls63amg.jpg', 'Motor : 4.0L V8 Potência: 612 cv Aceleração 0-100 km/h : Aproximadamente 3,4 segundos Velocidade máxima : 250 km/h (limitada eletronicamente)', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes cls63amg' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/cls63amg.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes gla', 2021, 260000.00, 'assets/imagens/cars/mercedes/gla2021.jpg', 'Motor : motores 1.3L turbo Potência : Entre 163 cv Aceleração 0-100 km/h : Aproximadamente 8,0 segundos Velocidade máxima : Até 250 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes gla' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/gla2021.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes amg gt63s', 2021, 1150000.00, 'assets/imagens/cars/mercedes/Mercedes-AMG-GT-63S-E-Performance-e-hibrido-plug-in-mais-rapido-da-historia-da-Mercedes.png', 'Motor : 4.0L V8 biturbo Potência : 639 cv Aceleração 0-100 km/h : Aproximadamente 3,2 segundos Velocidade máxima : 315 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes amg gt63s' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/Mercedes-AMG-GT-63S-E-Performance-e-hibrido-plug-in-mais-rapido-da-historia-da-Mercedes.png');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Mercedes-Benz', 'mercedes slr mclaren', 2021, 2500000.00, 'assets/imagens/cars/mercedes/Mercedes-Benz_SLR_McLaren_2.jpg', 'Motor : 5.4L V8 superalimentado Potência : 617 cv Aceleração 0-100 km/h : Aproximadamente 3,8 segundos Velocidade máxima : 334 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Mercedes-Benz' AND modelo = 'mercedes slr mclaren' AND ano = 2021 AND imagem = 'assets/imagens/cars/mercedes/Mercedes-Benz_SLR_McLaren_2.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', 'panamera', 2021, 630000.00, 'assets/imagens/cars/porsche/2017-10-04-porsche-panamera-turbo-sport-turismo-10.webp', 'Motorização: V6 Potência: 500 cv Aceleração 0-100 km/h: 5,6 a 3,1 segundos Velocidade máxima: Até 315 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = 'panamera' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/2017-10-04-porsche-panamera-turbo-sport-turismo-10.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', 'cayman', 2021, 500000.00, 'assets/imagens/cars/porsche/2017-porsche-718-cayman.jpg', 'Motorização: Flat-4 Potência: 420 cv Velocidade máxima: Até 293 km/h Aceleração 0-100 km/h: 4,9 a 4,4 segundos', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = 'cayman' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/2017-porsche-718-cayman.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', '911 gt1s', 2021, 30000000.00, 'assets/imagens/cars/porsche/911gt1s.jpg', 'Motorização: 3.2L Flat-6 biturbo Potência: 537 cv Aceleração 0-100 km/h: 3,9 segundos Velocidade máxima: 310 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = '911 gt1s' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/911gt1s.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', '718 spider rs', 2021, 1100000.00, 'assets/imagens/cars/porsche/porsche-718-spyder-rs-br.jpg', 'Motorização: 4.0L Flat-6 aspirado Potência: 500 cv Aceleração 0-100 km/h: 3,4 segundos Velocidade máxima: 308 km/h', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = '718 spider rs' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/porsche-718-spyder-rs-br.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', '911 gt2', 2021, 2450000.00, 'assets/imagens/cars/porsche/porsche-911-gt2-rs.jpg', 'Motorização: 3.8L Flat-6 biturbo Potência: 700 cv Velocidade máxima: 340 km/h Aceleração 0-100 km/h: 2,7 segundos', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = '911 gt2' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/porsche-911-gt2-rs.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', 'cayenne', 2021, 1150000.00, 'assets/imagens/cars/porsche/porsche-cayenne-2023.jpg', 'Motorização: V6 Potência: 335 cv Velocidade máxima: Até 250 km/h Aceleração 0-100 km/h: 6,2 segundos', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = 'cayenne' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/porsche-cayenne-2023.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', 'macan', 2021, 1150000.00, 'assets/imagens/cars/porsche/porsche-macan-rwd-2024.webp', 'Motorização: 4 cilindros e V6 Potência: 350cv Velocidade máxima: Até 270 km/h Aceleração 0-100 km/h: 6,4 segundos', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = 'macan' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/porsche-macan-rwd-2024.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', '918 spider', 2021, 10000000.00, 'assets/imagens/cars/porsche/Porsche_918_Spyder_IAA_2013.jpg', 'Motorização: 4.6L V8 + motores elétricos Potência: 887 cv Velocidade máxima: 345 km/h Aceleração 0-100 km/h: 2,6 segundos', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = '918 spider' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/Porsche_918_Spyder_IAA_2013.jpg');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', 'gt3 rs', 2021, 2200000.00, 'assets/imagens/cars/porsche/porschegt3rs.webp', 'Motorização: 4.0L Flat-6 aspirado Potência: 525 cv Velocidade máxima: 296 km/h Aceleração 0-100 km/h: 3,2 segundos', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = 'gt3 rs' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/porschegt3rs.webp');
INSERT INTO carros (marca, modelo, ano, preco, imagem, descricao, quilometragem, combustivel, status)
SELECT 'Porsche', 'taycan', 2021, 630000.00, 'assets/imagens/cars/porsche/porschetaycan1.jpg', 'Motorização: Motores elétricos Potência: Até 761 cv Velocidade máxima: 260 km/h Aceleração 0-100 km/h: 5,4 a 2,8 segundos', 500, NULL, 'disponivel'
WHERE NOT EXISTS (SELECT 1 FROM carros WHERE marca = 'Porsche' AND modelo = 'taycan' AND ano = 2021 AND imagem = 'assets/imagens/cars/porsche/porschetaycan1.jpg');

USE luxcars;

-- Execute uma vez apenas em bancos criados pelo schema anterior.
ALTER TABLE carros
    ADD COLUMN quilometragem INT UNSIGNED NULL,
    ADD COLUMN cor VARCHAR(60) NULL,
    ADD COLUMN combustivel VARCHAR(40) NULL,
    ADD COLUMN cambio VARCHAR(60) NULL,
    ADD COLUMN versao VARCHAR(100) NULL,
    ADD COLUMN informacoes_adicionais TEXT NULL;

UPDATE carros SET quilometragem = 12000, cor = 'Preto', combustivel = 'Gasolina', cambio = 'Automático', versao = 'M Competition', informacoes_adicionais = 'Tração integral e acabamento esportivo M.' WHERE marca = 'BMW' AND modelo = 'X6 Competition';
UPDATE carros SET quilometragem = 3500, cor = 'Cinza', combustivel = 'Gasolina', cambio = 'Automatizado', versao = 'GT', informacoes_adicionais = 'Motor V10 e tração quattro.' WHERE marca = 'Audi' AND modelo = 'R8 GT';
UPDATE carros SET quilometragem = 8600, cor = 'Vermelho', combustivel = 'Gasolina', cambio = 'Automatizado', versao = 'GTB', informacoes_adicionais = 'Câmbio de dupla embreagem e tração traseira.' WHERE marca = 'Ferrari' AND modelo = '488 GTB';
UPDATE carros SET quilometragem = 5200, cor = 'Branco', combustivel = 'Gasolina', cambio = 'Automatizado', versao = 'GT2 RS', informacoes_adicionais = 'Motor boxer biturbo e tração traseira.' WHERE marca = 'Porsche' AND modelo = '911 GT2 RS';
UPDATE carros SET quilometragem = 14000, cor = 'Preto', combustivel = 'Gasolina', cambio = 'Automático', versao = '4MATIC+', informacoes_adicionais = 'Tração integral e pacote de desempenho AMG.' WHERE marca = 'Mercedes-Benz' AND modelo = 'AMG GT 63 S';
UPDATE carros SET quilometragem = 4100, cor = 'Amarelo', combustivel = 'Gasolina', cambio = 'Automatizado', versao = 'EVO', informacoes_adicionais = 'Tração integral e modos de condução selecionáveis.' WHERE marca = 'Lamborghini' AND modelo = 'Huracán';
UPDATE carros SET quilometragem = 6000, cor = 'Laranja', combustivel = 'Gasolina', cambio = 'Automatizado', versao = 'Performance', informacoes_adicionais = 'Monocoque de fibra de carbono e tração traseira.' WHERE marca = 'McLaren' AND modelo = '720S';
UPDATE carros SET quilometragem = 900, cor = 'Prata', combustivel = 'Gasolina', cambio = 'Automatizado', versao = 'Attack', informacoes_adicionais = 'Unidade de produção limitada com aerodinâmica de pista.' WHERE marca = 'Koenigsegg' AND modelo = 'Jesko';

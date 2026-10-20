# Anúncios de veículos

O formulário de `paginas/anunciar.php` recebe anúncios em quatro etapas: identificação, especificações e preço, fotos e documentação. O valor mínimo é validado na interface e no servidor. As solicitações ficam em análise e só entram no catálogo quando um administrador aprova.

## Ativar no banco

Em uma instalação existente, execute uma vez `database/migrations/20261019_solicitacoes_anuncios_veiculos.sql` depois de aplicar o schema atual. Instalações novas também podem usar o `database/schema.sql`, que já cria a tabela.

## Arquivos

As fotos e os documentos ficam em `storage/anuncios/`. O diretório tem regra Apache para negar acesso direto. CRLV e documentos complementares são servidos somente por `paginas/arquivo_anuncio.php`, que exige sessão administrativa. Fotos aprovadas são copiadas para `assets/imagens/cars/anuncios/` e entram na galeria pública.

O PHP e o servidor web precisam permitir uploads de pelo menos 12 MB por arquivo, `max_file_uploads` igual ou superior a 10 e requisições POST de pelo menos 90 MB para aceitar o limite máximo de arquivos. São aceitas até oito fotos JPG, PNG ou WebP de até 8 MB cada, com pelo menos 960 × 540 pixels. O CRLV é obrigatório; laudo ou histórico de revisões é opcional.

Administradores analisam as propostas em `paginas/admin_anuncios.php`. Uma solicitação devolvida pode ser corrigida pelo anunciante e reenviada para uma nova análise.

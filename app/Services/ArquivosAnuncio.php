<?php
declare(strict_types=1);

namespace Elite\Services;

final class ArquivosAnuncio
{
    private const IMAGE_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    private const DOCUMENT_TYPES = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    private function __construct() {}

    public static function novoDiretorio(int $usuarioId): string
    {
        $relativo = 'storage/anuncios/' . $usuarioId . '/' . bin2hex(random_bytes(16));
        $absoluto = dirname(__DIR__, 2) . '/' . $relativo;
        if (!mkdir($absoluto, 0750, true) && !is_dir($absoluto)) {
            throw new \RuntimeException('Não foi possível preparar o envio seguro dos arquivos.');
        }
        return $relativo;
    }

    /** @param array<string, mixed> $arquivo */
    public static function guardar(array $arquivo, string $diretorioRelativo, bool $somenteImagem, int $limiteBytes): string
    {
        $erro = (int) ($arquivo['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($erro !== UPLOAD_ERR_OK) {
            $mensagens = [
                UPLOAD_ERR_INI_SIZE => 'Um dos arquivos excede o limite configurado no servidor.',
                UPLOAD_ERR_FORM_SIZE => 'Um dos arquivos excede o limite permitido.',
                UPLOAD_ERR_PARTIAL => 'Um arquivo foi enviado parcialmente. Tente novamente.',
                UPLOAD_ERR_NO_FILE => 'Selecione os arquivos obrigatórios para continuar.',
                UPLOAD_ERR_NO_TMP_DIR => 'O servidor não conseguiu receber o arquivo temporário.',
                UPLOAD_ERR_CANT_WRITE => 'O servidor não conseguiu gravar um arquivo enviado.',
                UPLOAD_ERR_EXTENSION => 'O servidor interrompeu o envio de um arquivo.',
            ];
            throw new ErroUploadAnuncio($mensagens[$erro] ?? 'Não foi possível receber um dos arquivos.');
        }

        $temporario = $arquivo['tmp_name'] ?? null;
        $tamanho = (int) ($arquivo['size'] ?? 0);
        if (!is_string($temporario) || !is_uploaded_file($temporario) || $tamanho < 1 || $tamanho > $limiteBytes) {
            throw new ErroUploadAnuncio('Um dos arquivos está vazio ou excede o tamanho máximo permitido.');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($temporario);
        $tiposPermitidos = $somenteImagem ? self::IMAGE_TYPES : self::DOCUMENT_TYPES;
        if (!is_string($mime) || !isset($tiposPermitidos[$mime])) {
            throw new ErroUploadAnuncio($somenteImagem
                ? 'As fotos devem estar nos formatos JPG, PNG ou WebP.'
                : 'O documento deve estar em PDF, JPG, PNG ou WebP.');
        }

        if ($somenteImagem) {
            $dimensoes = @getimagesize($temporario);
            if ($dimensoes === false || $dimensoes[0] < 960 || $dimensoes[1] < 540) {
                throw new ErroUploadAnuncio('Cada foto precisa ter pelo menos 960 × 540 pixels.');
            }
        } elseif ($mime !== 'application/pdf' && @getimagesize($temporario) === false) {
            throw new ErroUploadAnuncio('O arquivo de imagem do documento não é válido.');
        }

        $raiz = dirname(__DIR__, 2);
        $pasta = $raiz . '/' . $diretorioRelativo;
        if (!str_starts_with($diretorioRelativo, 'storage/anuncios/') || !is_dir($pasta)) {
            throw new \RuntimeException('O destino seguro dos arquivos não está disponível.');
        }
        $nome = bin2hex(random_bytes(16)) . '.' . $tiposPermitidos[$mime];
        if (!move_uploaded_file($temporario, $pasta . '/' . $nome)) {
            throw new \RuntimeException('Não foi possível salvar um dos arquivos enviados.');
        }
        @chmod($pasta . '/' . $nome, 0640);
        return $diretorioRelativo . '/' . $nome;
    }

    public static function caminhoSeguro(string $relativo): ?string
    {
        if ($relativo === '' || str_contains($relativo, "\0") || str_contains($relativo, '..') || str_contains($relativo, '\\')) {
            return null;
        }
        $raizProjeto = realpath(dirname(__DIR__, 2));
        $caminho = realpath(dirname(__DIR__, 2) . '/' . ltrim($relativo, '/'));
        if ($raizProjeto === false || $caminho === false || !is_file($caminho)) {
            return null;
        }
        $raizPrivada = realpath($raizProjeto . '/storage/anuncios');
        $raizPublica = realpath($raizProjeto . '/assets/imagens/cars/anuncios');
        $dentroDaRaiz = static function (?string $raiz) use ($caminho): bool {
            return $raiz !== null && str_starts_with($caminho, $raiz . DIRECTORY_SEPARATOR);
        };
        return ($dentroDaRaiz($raizPrivada) || $dentroDaRaiz($raizPublica)) ? $caminho : null;
    }

    public static function copiarFotoParaCatalogo(string $fotoPrivada, int $anuncioId, int $indice): string
    {
        if (!str_starts_with($fotoPrivada, 'storage/anuncios/')) {
            throw new \RuntimeException('A foto da solicitação não está no armazenamento privado.');
        }
        $origem = self::caminhoSeguro($fotoPrivada);
        if ($origem === null) {
            throw new \RuntimeException('Uma das fotos do anúncio não está disponível.');
        }
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($origem);
        if (!is_string($mime) || !isset(self::IMAGE_TYPES[$mime])) {
            throw new \RuntimeException('Uma das fotos do anúncio não é válida.');
        }
        $relativo = 'assets/imagens/cars/anuncios/' . $anuncioId;
        $destinoPasta = dirname(__DIR__, 2) . '/' . $relativo;
        if (!is_dir($destinoPasta) && !mkdir($destinoPasta, 0755, true) && !is_dir($destinoPasta)) {
            throw new \RuntimeException('Não foi possível publicar as fotos aprovadas.');
        }
        $nome = sprintf('%02d-%s.%s', $indice + 1, bin2hex(random_bytes(8)), self::IMAGE_TYPES[$mime]);
        if (!copy($origem, $destinoPasta . '/' . $nome)) {
            throw new \RuntimeException('Não foi possível publicar uma das fotos aprovadas.');
        }
        return $relativo . '/' . $nome;
    }

    /** @param list<string> $caminhos */
    public static function apagar(array $caminhos): void
    {
        foreach ($caminhos as $relativo) {
            $caminho = self::caminhoSeguro($relativo);
            if ($caminho !== null) {
                @unlink($caminho);
            }
        }
    }
}

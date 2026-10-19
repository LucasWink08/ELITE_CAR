<?php
declare(strict_types=1);

namespace Elite\Models;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use JsonException;
use Elite\Core\Conexao;
use PDO;
use Throwable;

final class NoticiaAutomotivaRepository
{
    private PDO $database;

    public function __construct(?PDO $database = null)
    {
        $this->database = $database ?? Conexao::obterConexao();
    }

    public function precisaAtualizar(int $intervaloSegundos = 900): bool
    {
        $intervaloSegundos = max(60, $intervaloSegundos);
        $ultimaAtualizacaoRecente = $this->database
            ->query(
                'SELECT ultima_tentativa_em > DATE_SUB(CURRENT_TIMESTAMP, INTERVAL '
                . $intervaloSegundos . ' SECOND)
                 FROM noticias_automotivas_sync WHERE id = 1'
            )
            ->fetchColumn();

        return $ultimaAtualizacaoRecente === false || !(bool) $ultimaAtualizacaoRecente;
    }

    public function marcarTentativa(): void
    {
        $this->database->exec(
            'INSERT INTO noticias_automotivas_sync (id, ultima_tentativa_em)
             VALUES (1, CURRENT_TIMESTAMP)
             ON DUPLICATE KEY UPDATE ultima_tentativa_em = CURRENT_TIMESTAMP'
        );
    }

    /** @param array<int, array<string, mixed>> $artigos */
    public function salvarArtigos(array $artigos): void
    {
        if ($artigos === []) {
            return;
        }

        $statement = $this->database->prepare(
            'INSERT INTO noticias_automotivas
                (apitube_id, titulo, descricao, imagem_url, url_original, fonte, idioma, publicado_em, dados_json)
             VALUES
                (:apitube_id, :titulo, :descricao, :imagem_url, :url_original, :fonte, :idioma, :publicado_em, :dados_json)
             ON DUPLICATE KEY UPDATE
                titulo = VALUES(titulo), descricao = VALUES(descricao), imagem_url = VALUES(imagem_url),
                url_original = VALUES(url_original), fonte = VALUES(fonte), idioma = VALUES(idioma),
                publicado_em = VALUES(publicado_em), dados_json = VALUES(dados_json),
                sincronizado_em = CURRENT_TIMESTAMP'
        );

        $this->database->beginTransaction();
        try {
            foreach ($artigos as $artigo) {
                $normalizado = $this->normalizarArtigo($artigo);
                if ($normalizado !== null) {
                    $statement->execute($normalizado);
                }
            }
            $this->database->commit();
        } catch (Throwable $exception) {
            if ($this->database->inTransaction()) {
                $this->database->rollBack();
            }
            throw $exception;
        }
    }

    /** @return array<int, array<string, mixed>> */
    public function listarRecentes(int $limite = 10): array
    {
        $limite = max(1, min(20, $limite));
        $statement = $this->database->query(
            'SELECT apitube_id, titulo, descricao, imagem_url, url_original, fonte, idioma, publicado_em
             FROM noticias_automotivas
             ORDER BY COALESCE(publicado_em, sincronizado_em) DESC, id DESC
             LIMIT ' . $limite
        );

        return $statement->fetchAll();
    }

    /** @param array<string, mixed> $artigo
     *  @return array<string, mixed>|null
     */
    private function normalizarArtigo(array $artigo): ?array
    {
        $id = $artigo['id'] ?? null;
        $titulo = trim((string) ($artigo['title'] ?? ''));
        $url = $this->urlValida($artigo['href'] ?? null, true);
        if ((!is_string($id) && !is_int($id)) || trim((string) $id) === '' || $titulo === '' || $url === null) {
            return null;
        }

        try {
            $dadosJson = json_encode($artigo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('Um artigo da APITube nao pode ser serializado.', 0, $exception);
        }

        $descricao = html_entity_decode(
            trim(strip_tags((string) ($artigo['description'] ?? ''))),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );
        $fonte = trim((string) ($artigo['source']['domain'] ?? ''));
        $idioma = trim((string) ($artigo['language'] ?? 'pt'));

        return [
            'apitube_id' => (string) $id,
            'titulo' => $titulo,
            'descricao' => $descricao !== '' ? $descricao : null,
            'imagem_url' => $this->urlValida($artigo['image'] ?? null, false),
            'url_original' => $url,
            'fonte' => $fonte !== '' ? substr($fonte, 0, 255) : null,
            'idioma' => substr($idioma !== '' ? $idioma : 'pt', 0, 12),
            'publicado_em' => $this->dataPublicacao($artigo['published_at'] ?? null),
            'dados_json' => $dadosJson,
        ];
    }

    private function urlValida(mixed $url, bool $permitirHttp): ?string
    {
        if (!is_string($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $esquema = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $esquemasAceitos = $permitirHttp ? ['http', 'https'] : ['https'];
        return in_array($esquema, $esquemasAceitos, true) ? $url : null;
    }

    private function dataPublicacao(mixed $data): ?string
    {
        if (!is_string($data) || trim($data) === '') {
            return null;
        }

        try {
            return (new DateTimeImmutable($data))
                ->setTimezone(new DateTimeZone('America/Sao_Paulo'))
                ->format('Y-m-d H:i:s');
        } catch (\Exception) {
            return null;
        }
    }
}

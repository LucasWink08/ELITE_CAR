<?php
declare(strict_types=1);

namespace LuxCars\Services;

use RuntimeException;

final class NoticiasAutomotivasApi
{
    /** @return array<int, array<string, mixed>> */
    public function buscar(): array
    {
        $apiKey = trim((string) (getenv('APITUBE_API_KEY') ?: ''));
        if ($apiKey === '') {
            return [];
        }

        $query = http_build_query([
            'topic.id' => 'industry.automotive_news',
            'language.code' => 'pt',
            'per_page' => 10,
            'page' => 1,
            'sort.by' => 'published_at',
            'sort.order' => 'desc',
            'is_duplicate' => '0',
            'fl' => 'id,title,description,href,image,published_at,source.domain,language',
        ], '', '&', PHP_QUERY_RFC3986);
        $url = 'https://api.apitube.io/v1/news/everything?' . $query;
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Accept: application/json\r\nX-API-Key: " . str_replace(["\r", "\n"], '', $apiKey) . "\r\n",
                'timeout' => 5,
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);
        $statusCode = 0;
        foreach ($http_response_header ?? [] as $header) {
            if (preg_match('/^HTTP\/\S+\s+(\d{3})/i', $header, $matches) === 1) {
                $statusCode = (int) $matches[1];
            }
        }

        if ($response === false) {
            throw new RuntimeException('Nao foi possivel consultar a API de noticias APITube.');
        }
        if ($statusCode < 200 || $statusCode >= 300) {
            throw new RuntimeException('A API de noticias APITube respondeu com HTTP ' . $statusCode . '.');
        }

        try {
            $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new RuntimeException('A API de noticias APITube retornou JSON invalido.', 0, $exception);
        }

        if (!is_array($data) || ($data['status'] ?? null) !== 'ok' || !is_array($data['results'] ?? null)) {
            throw new RuntimeException('A resposta da API de noticias APITube nao possui artigos validos.');
        }

        return array_values(array_filter($data['results'], 'is_array'));
    }
}

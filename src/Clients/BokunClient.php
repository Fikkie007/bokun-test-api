<?php

namespace App\Clients;

class BokunClient
{
    public function __construct(
        private string $accessKey,
        private string $secretKey,
        private string $appUrl
    ) {
        $this->appUrl = rtrim($this->appUrl, '/');
    }

    public function get(string $path, array $query = []): array
    {
        $method = 'GET';
        $fullPath = $this->buildPath($path, $query);
        $url = $this->appUrl . $fullPath;
        $date = gmdate('Y-m-d H:i:s');
        $signature = $this->sign($date, $method, $fullPath);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER    => $this->buildHeaders($date, $signature),
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException("cURL error: $error");
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON: $response");
        }

        return ['status' => $status, 'data' => $data];
    }

    public function post(string $path, array $body = []): array
    {
        $method = 'POST';
        $date = gmdate('Y-m-d H:i:s');
        $fullPath = $this->buildPath($path, []);
        $signature = $this->sign($date, $method, $fullPath);

        $ch = curl_init($this->appUrl . $fullPath);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => array_merge(
                $this->buildHeaders($date, $signature),
                ['Content-Type: application/json']
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($body),
        ]);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException("cURL error: $error");
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON: $response");
        }

        return ['status' => $status, 'data' => $data];
    }


    private function sign(string $date, string $method, string $path): string
    {
        $stringToSign = "{$date}{$this->accessKey}{$method}{$path}";
        $hmac = hash_hmac('sha1', $stringToSign, $this->secretKey, true);
        return base64_encode($hmac);
    }

    private function buildPath(string $path, array $query): string
    {
        return $query ? ($path . '?' . http_build_query($query)) : $path;
    }

    private function buildHeaders(string $date, string $signature): array
    {
        return [
            'Accept: application/json',
            "X-Bokun-Date: {$date}",
            "X-Bokun-AccessKey: {$this->accessKey}",
            "X-Bokun-Signature: {$signature}",
        ];
    }
}

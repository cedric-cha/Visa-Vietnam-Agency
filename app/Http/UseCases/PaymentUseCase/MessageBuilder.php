<?php

namespace App\Http\UseCases\PaymentUseCase;

use App\Exceptions\SignatureException;

class MessageBuilder
{
    private $method = 'GET';

    private $uri;

    private $headers;

    private $date;

    private $params;

    private $body;

    public function with(mixed $date, string $uri, string $method = 'GET', array $headers = []): self
    {
        $this->date = $date;
        $this->uri = $uri;
        $this->method = $method;
        $this->headers = $headers;

        return $this;
    }

    public function withBody(array|string $body): self
    {
        if (! is_string($body)) {
            $body = json_encode($body);
        }

        $this->body = $body;

        return $this;
    }

    public function withParams(array $params = []): self
    {
        $this->params = $params;

        return $this;
    }

    public function build(): string
    {
        try {
            $this->validate();
        } catch (SignatureException $e) {
            report($e);
        }

        $canonicalHeaders = $this->canonicalHeaders();

        if ($this->method == 'POST' && $this->body) {
            $canonicalPayload = $this->canonicalBody();
        } else {
            $canonicalPayload = $this->canonicalParams();
        }
        $components = [$this->method, $this->uri, $this->date];
        if ($canonicalHeaders) {
            $components[] = $canonicalHeaders;
        }
        if ($canonicalPayload) {
            $components[] = $canonicalPayload;
        }

        return implode("\n", $components);
    }

    public static function instance(): self
    {
        return new MessageBuilder();
    }

    public function __toString()
    {
        return $this->build();
    }

    protected function validate(): void
    {
        if (empty($this->uri) || empty($this->date)) {
            throw new SignatureException('Please pass properties by with function first');
        }
    }

    protected function canonicalHeaders(): string
    {
        if (! empty($this->headers)) {
            ksort($this->headers);

            return http_build_query($this->headers);
        }

        return '';
    }

    protected function canonicalParams(): string
    {
        $str = '';
        if (! empty($this->params)) {
            ksort($this->params);
            foreach ($this->params as $key => $val) {
                $str .= urlencode($key).'='.urlencode($val).'&';
            }
            $str = substr($str, 0, -1);
        }

        return $str;
    }

    protected function canonicalBody(): string
    {
        if (! empty($this->body)) {
            return base64_encode(hash('sha256', $this->body, true));
        }

        return '';
    }
}

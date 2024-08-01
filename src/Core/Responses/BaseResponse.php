<?php

namespace Kolirt\Telegram\Core\Responses;

abstract class BaseResponse
{

    public bool $ok = true;
    public int|null $error_code = null;
    public string|null $description = null;

    public function __construct(array $response)
    {
        $this->ok = $response['ok'];
        if (isset($response['error_code'])) $this->error_code = $response['error_code'];
        if (isset($response['description'])) $this->description = $response['description'];
    }

    /**
     * Check if the response is successful.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->ok;
    }

    /**
     * Check if the response is an error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return !$this->isSuccess();
    }

    /**
     * Get the error description.
     *
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        return $this->error_code;
    }

    /**
     * Get the error description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Check if bot was blocked by the user.
     *
     * @return bool
     */
    public function isBlockedByUserError(): bool
    {
        return $this->isError() && $this->description === 'Forbidden: bot was blocked by the user';
    }

    /**
     * Check if chat not found.
     *
     * @return bool
     */
    public function isChatNotFoundError(): bool
    {
        return $this->isError() && $this->description === 'Bad Request: chat not found';
    }

}

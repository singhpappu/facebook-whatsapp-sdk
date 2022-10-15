<?php

namespace LaravelNotification\Whatsapp\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;

/**
 * Class CouldNotSendNotification.
 */
class WhatsappException extends Exception
{
    /**
     * Thrown when there's a bad request and an error is responded.
     *
     * @return static
     */
    public static function facebookGraphErrorResponse(ClientException $exception): self
    {
        if (!$exception->hasResponse()) {
            return new static('Facebook returned an error but no response body found.');
        }

        $statusCode = $exception->getResponse()->getStatusCode();

        $result = json_decode($exception->getResponse()->getBody()->getContents(), false);
        $description = $result->description ?? 'discription not available';

        return new static("Facebook returned an error `{$statusCode} - {$description}`", 0, $exception);
    }

    public static function comunicationWithFacebookGraphNotEstablished($string): self
    {
        return new static($string);
    }
}

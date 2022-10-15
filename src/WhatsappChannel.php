<?php

namespace LaravelNotification\Whatsapp;

use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use LaravelNotification\Whatsapp\Exceptions\WhatsappException;
use Illuminate\Contracts\Events\Dispatcher;

class WhatsappChannel
{

    protected $whatsapp;

    protected $dispatcher;

    public function __construct(Whatsapp $whatsapp, Dispatcher $dispatcher)
    {
        $this->whatsapp = $whatsapp;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Send the whatsapp notification.
     *
     * @param mixed $notifiable
     *
     * @throws WhatsappNotificationNotSend
     */

    public function send($notifiable, Notification $notification): ?array
    {
        $messages = $notification->toWhatsapp($notifiable);

        if (is_string($messages)) {
            $messages = (new WhatsappMessage)->body($messages);
        }

        try {
            if ($messages instanceof WhatsappMessage) {
                if ($messages->isMessageTypeTemplate()) {
                    $messages->setComponentsParameters();
                    $response = $this->whatsapp->sendTextMessage($messages->getPayload());
                }
            }
        } catch (WhatsappException $exception) {
            $this->dispatcher->dispatch(new NotificationFailed(
                $notifiable,
                $notification,
                'telegram',
                []
            ));
            throw $exception;
        }
        
        return json_decode($response->getBody()->getContents(), true);
    }
}

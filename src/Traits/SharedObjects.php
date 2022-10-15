<?php

namespace LaravelNotification\Whatsapp\Traits;

trait SharedObjects
{
    use TemplateObjects;

    /** @var string required */
    protected $version = "v14.0"; // default facebook app version

    /** 
     * Whatsapp phone number id to authenticate the app 
     * @var string required
     * */
    protected $phoneNumberId;

    /**
     * Whatsapp recipient phone number, where you want to send 
     * @var string required
     */
    protected $recipientPhoneNumber;

    /**
     * Whatsapp access token, in development mode the token will expire in 23 hrs.
     * @var string required
     */
    protected $token;

    /**
     * Request payload
     * @var array
     */
    protected $payload;

    /**
     * Get the value of version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the value of version
     *
     * @return  self
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }


    /**
     * Get whatsapp phone number id to authenticate the app
     *
     * @return  string
     */
    public function getPhoneNumberId()
    {
        return $this->phoneNumberId;
    }

    /**
     * Set whatsapp phone number id to authenticate the app
     *
     * @param  string  $phoneNumberId  Whatsapp phone number id to authenticate the app
     *
     * @return  self
     */
    public function setPhoneNumberId(string $phoneNumberId)
    {
        $this->phoneNumberId = $phoneNumberId;

        return $this;
    }

    /**
     * Get whatsapp recipient phone number, where you want to send
     */
    public function getRecipientPhoneNumber()
    {
        return $this->recipientPhoneNumber;
    }

    /**
     * Set whatsapp recipient phone number, where you want to send
     *
     * @return  self
     */
    public function setRecipientPhoneNumber($recipientPhoneNumber)
    {
        $this->recipientPhoneNumber = $recipientPhoneNumber;

        return $this;
    }

    /**
     * Get required
     *
     * @return  string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set required
     *
     * @param  string  $token  required
     *
     * @return  self
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set messaging product
     */
    public function messagingProduct(string $product = 'whatsapp'): self
    {
        $this->payload['messaging_product'] = $product;
        return $this;
    }

    /**
     * Set message type by defualt it is text
     */
    public function type(string $type = 'text'): self
    {
        $this->payload['type'] = $type;
        return $this;
    }

    /**
     * Use the template type message to send from system
     */
    public function useTemplate(string $template_name): self
    {
        $this->payload['type'] = 'template';
        $this->setName($template_name);

        // Set language for template
        $this->setLanguage([
            'policy' => 'deterministic',
            'code' => 'en'
        ]);
        
        return $this;
    }

    /**
     * Set recipient's whatsapp phone number
     */
    public function to(string $to): self
    {
        $this->payload['to'] = $to;
        return $this;
    }

    /**
     * Get template name required
     *
     * @return  string
     */ 
    public function getType()
    {
        return $this->payload['type'];
    }

    public function isMessageTypeTemplate()
    {
        return $this->getType() === 'template';
    }

    /**
     * Get request payload
     *
     * @return  array
     */ 
    public function getPayload()
    {
        return $this->payload;
    }
}

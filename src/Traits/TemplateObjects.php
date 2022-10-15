<?php

namespace LaravelNotification\Whatsapp\Traits;

trait TemplateObjects
{
    /**
     * Name of the template.
     * @var string required
     */
    protected $name;

    /**
     * Contains a language object. Specifies the language the template may be rendered in.
     * @var array required [
     *  policy
     *  code
     * ]
     */
    protected $language;

    /**
     * Array of components objects containing the parameters of the message.
     * Supported type: header, body, button
     * @var array optional
     */
    protected $components;

    /**
     * Set the button.
     * Supported type: payload, text
     * @var array optional
     */

    protected $button;

    /**
     * Set the currency.
     * @var array optional
     */

    protected $currency;

    /**
     * Set date time object
     */
    protected $dateTime;

    /**
     * Set required
     *
     * @param  string  $name  required
     *
     * @return  self
     */
    public function setName(string $name): self
    {
        $this->payload['template']['name'] = $name;

        return $this;
    }



    /**
     * Set required
     *
     * @param  array  $language  required
     *
     * @return  self
     */
    public function setLanguage(array $language): self
    {
        $this->payload['template']['language'] = $language;

        return $this;
    }

    /**
     * Set optional
     *
     * @param  array  $components  optional
     *
     * @return  self
     */
    public function setComponents(array $components): self
    {
        $this->payload['template']['components'] = $components;

        return $this;
    }

    public function setComponentsParameters()
    {
        if ($this->body && !is_array($this->body)) {
            throw new \Exception("If the template have variable then only array of values will be acceptable in sequence.");
        }
        $this->setComponents([ $this->getComponentBody($this->body) ]);
        return $this;
    }


    private function getComponentBody(array $body): array
    {
        $parameters = [];
        foreach ($body as $key => $value) {
            array_push($parameters, [
                "type" => "text",
                "text" => $value
            ]);
        }

        return [
            "type" => "body",
            "parameters" => $parameters
        ];
    }
}

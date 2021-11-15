<?php

namespace OrangeApiClient\Service\Sms;

/**
 * SMS Message Object
 * 
 * @see Message::__call() That permit use setters methods without << set >>
 */
class Message
{
    /**
     * @var string The Message content
     */
    protected $message;

    /**
     * The Phone number with contry code (ex: 243899999999)
     * @var int The message sender address
     */
    protected $senderAddress;

    /**
     * @var string The Message sender name
     */
    protected $senderName;

    /**
     * The Phone number with contry code (ex: 243899999999)
     * @var int The message address (receiver)
     */
    protected $address;


    /**
     * Construct Message
     * 
     * @param string $message
     * @param int $senderAddress The Phone number with contry code (ex: 243899999999)
     * @param string $senderName
     * @param int $address The Phone number with contry code (ex: 243899999999)
     */
    public function __construct(string $message = null, int $senderAddress = null, string $senderName = null, int $address = null)
    {
        $this->message = $message;
        $this->$senderAddress = $senderAddress;
        $this->senderName = $senderName;
        $this->address = $address;
    }

    /**
     * @param string
     * @return self
     */
    public function setContent(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param int
     * @return self
     */
    public function setFrom(int $senderAddress): self
    {
        $this->senderAddress = $senderAddress;

        return $this;
    }

    /**
     * @param string
     * @return self
     */
    public function setAs(string $senderName): self
    {
        $this->senderName = $senderName;

        return $this;
    }

    /**
     * @param int
     * @return self
     */
    public function setTo(int $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * You can use setters methods without set
     * 
     * 
     * $message = new Message();
     * $message
     *      ->content('Hello world, via Orange SMS API.')
     *      ->from(243899999999)
     *      ->as('Lussi')
     *      ->to(243899999999)
     * ;
     * 
     */
    public function __call($method, $argument): self
    {
        $method = 'set' . ucfirst($method);
        $this->$method($argument[0]);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return int|null
     */
    public function getSenderAddress(): ?int
    {
        return $this->senderAddress;
    }

    /**
     * @return string|null
     */
    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    /**
     * @return int|null
     */
    public function getAddress(): ?int
    {
        return $this->address;
    }
}

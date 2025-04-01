<?php

namespace ApiBundle\ApplicationLayer\CreateAndSendServiceEmailCommand;

use Symfony\Component\Validator\Constraints as Assert;

class CreatedAndSendServiceEmailCommandDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Type(type="string")
     */
    protected $email;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 100
     * )
     */
    protected $title;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 480
     * )
     */
    protected $message;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 255
     * )
     */
    protected $organization;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 50
     * )
     */
    protected $phone;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 50
     * )
     */
    protected $name;


    /**
     * ChangePostPriorityCommandDto constructor.
     * @param string $postId
     * @param int $priority
     */
    protected function __construct()
    {
    }

    static function createFromObject($dto)
    {
        $instance = new self();

        foreach ($dto as $propName => $value) {
            if (property_exists(self::class, $propName)) {
                $instance->$propName = $value;
            }
        }

        return $instance;
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        $array = [];
        foreach ($this as $propName => $value) {
            $array[$propName] = $value;
        }

        return $array;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}

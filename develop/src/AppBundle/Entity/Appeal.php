<?php
    namespace AppBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\Table(name="appeals")
     */
    class Appeal
    {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        private $id;

        /**
         * @ORM\Column(type="string", length=255)
         */
        private $name;

        /**
         * @ORM\Column(type="string", length=255)
         */
        private $surname;

        /**
         * @ORM\Column(type="string", length=20)
         */
        private $phone;

        /**
         * @ORM\Column(type="string", length=255)
         */
        private $email;

        /**
         * @ORM\Column(type="string", length=50)
         */
        private $personType; // Тип лица: физическое или юридическое

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $organization; // Организация (для юридических лиц)

        /**
         * @ORM\Column(type="text")
         */
        private $message;

        /**
         * @ORM\Column(type="datetime")
         */
        private $createdAt;

        public function __construct()
        {
            $this->createdAt = new \DateTime();
        }

        // Геттеры и сеттеры

        public function getId()
        {
            return $this->id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
            return $this;
        }

        public function getSurname()
        {
            return $this->surname;
        }

        public function setSurname($surname)
        {
            $this->surname = $surname;
            return $this;
        }

        public function getPhone()
        {
            return $this->phone;
        }

        public function setPhone($phone)
        {
            $this->phone = $phone;
            return $this;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($email)
        {
            $this->email = $email;
            return $this;
        }

        public function getPersonType()
        {
            return $this->personType;
        }

        public function getPersonTypeText()
        {
            $types = [
                'FL' => 'Физическое лицо',
                'YUL' => 'Юридическое лицо',
            ];

            return isset($types[$this->personType]) ? $types[$this->personType] : 'Не указано';
        }

        public function setPersonType($personType)
        {
            $this->personType = $personType;
            return $this;
        }

        public function getOrganization()
        {
            return $this->organization;
        }

        public function setOrganization($organization)
        {
            $this->organization = $organization;
            return $this;
        }

        public function getMessage()
        {
            return $this->message;
        }

        public function setMessage($message)
        {
            $this->message = $message;
            return $this;
        }

        public function getCreatedAt()
        {
            return $this->createdAt;
        }

        public function setCreatedAt($createdAt)
        {
            $this->createdAt = $createdAt;
            return $this;
        }

        /**
         * @ORM\Column(type="string", length=50, nullable=true)
         */
        private $apiStatus;

        public function getApiStatus()
        {
            return $this->apiStatus;
        }

        public function setApiStatus($apiStatus)
        {
            $this->apiStatus = $apiStatus;
            return $this;
        }

    }

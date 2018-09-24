<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=512)
     * @Assert\NotBlank(message="Body should not blank.")
     */
    private $body;

    /**
     * @var int
     *
     * @ORM\Column(name="sent_count_andr", type="integer",nullable=true )
     */
    private $sentCountAndr;

    /**
     * @var int
     *
     * @ORM\Column(name="sent_count_ios", type="integer",nullable=true )
     */
    private $sentCountiOs;

    /**
     * @var int
     *
     * @ORM\Column(name="click_count_andr", type="integer", nullable=true)
     */
    private $clickCountAndr;

    /**
     * @var int
     *
     * @ORM\Column(name="click_count_ios", type="integer", nullable=true)
     */
    private $clickCountiOs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \string
     *
     * @ORM\Column(name="uid", type="string", length=255, nullable=false, unique=true)
     */
    private $uid;

    /**
     * @var bigint
     *
     * @ORM\Column(name="message_id", type="bigint", nullable=true)
     */
    private $messageId;

    /**
     * @ORM\OneToMany(targetEntity="Country", mappedBy="notification", cascade={"persist", "remove" })
     */
    protected $countries;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();
        $this->countries = new ArrayCollection();
    }

    /**
     * @return Country[]|ArrayCollection
     */
    public function getCountries()
    {
        return $this->countries;
    }

    public function addCountry($country)
    {
        if($this->countries->contains($country) == false) {
            $this->countries->add($country);
        }
        return $this->countries;
    }

    public function deleteCountry($country)
    {
        if($this->countries->contains($country)) {
            $this->countries->remove($country);
        }
        return $this->countries;
    }


    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Notification
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getSentCountAndr()
    {
        return $this->sentCountAndr;
    }

    /**
     * @param int $sentCountAndr
     */
    public function setSentCountAndr($sentCountAndr)
    {
        $this->sentCountAndr = $sentCountAndr;
    }

    /**
     * @return int
     */
    public function getSentCountiOs()
    {
        return $this->sentCountiOs;
    }

    /**
     * @param int $sentCountiOs
     */
    public function setSentCountiOs($sentCountiOs)
    {
        $this->sentCountiOs = $sentCountiOs;
    }

    /**
     * @return int
     */
    public function getClickCountAndr()
    {
        return $this->clickCountAndr;
    }

    /**
     * @param int $clickCountAndr
     */
    public function setClickCountAndr($clickCountAndr)
    {
        $this->clickCountAndr = $clickCountAndr;
    }

    /**
     * @return int
     */
    public function getClickCountiOs()
    {
        return $this->clickCountiOs;
    }

    /**
     * @param int $clickCountiOs
     */
    public function setClickCountiOs($clickCountiOs)
    {
        $this->clickCountiOs = $clickCountiOs;
    }

    /**
     * Set Notification update value.
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Set Created At Value before adding notofication to Database.
     *
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param int $messageId
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }
}


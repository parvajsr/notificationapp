<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Country
 *
 * @ORM\Table(name="country",uniqueConstraints={
 * @ORM\UniqueConstraint(columns={ "notification_id", "country_code"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CountryRepository")
 */
class Country
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
     * @var int
     *
     * @ORM\Column(name="sent_android", type="integer", nullable=true)
     */
    private $sentAndroid;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=255)
     */
    private $countryCode;

    /**
     * @var int
     *
     * @ORM\Column(name="sent_ios", type="integer", nullable=true)
     */
    private $sentIos;

    /**
     * @var int
     *
     * @ORM\Column(name="click_android", type="integer", nullable=true)
     */
    private $clickAndroid;

    /**
     * @var int
     *
     * @ORM\Column(name="click_ios", type="integer", nullable=true)
     */
    private $clickIos;

    /**
     * @ORM\ManyToOne(targetEntity="Notification", inversedBy="country")
     * @ORM\JoinColumn(nullable=false)
     */
    private $notification;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->notification = new ArrayCollection();
    }

    /**
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
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
     * Set sentAndroid
     *
     * @param integer $sentAndroid
     *
     * @return Country
     */
    public function setSentAndroid($sentAndroid)
    {
        $this->sentAndroid = $sentAndroid;

        return $this;
    }

    /**
     * Get sentAndroid
     *
     * @return int
     */
    public function getSentAndroid()
    {
        return $this->sentAndroid;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return Country
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set sentIos
     *
     * @param integer $sentIos
     *
     * @return Country
     */
    public function setSentIos($sentIos)
    {
        $this->sentIos = $sentIos;

        return $this;
    }

    /**
     * Get sentIos
     *
     * @return int
     */
    public function getSentIos()
    {
        return $this->sentIos;
    }

    /**
     * Set clickAndroid
     *
     * @param integer $clickAndroid
     *
     * @return Country
     */
    public function setClickAndroid($clickAndroid)
    {
        $this->clickAndroid = $clickAndroid;

        return $this;
    }

    /**
     * Get clickAndroid
     *
     * @return int
     */
    public function getClickAndroid()
    {
        return $this->clickAndroid;
    }

    /**
     * Set clickIos
     *
     * @param integer $clickIos
     *
     * @return Country
     */
    public function setClickIos($clickIos)
    {
        $this->clickIos = $clickIos;

        return $this;
    }

    /**
     * Get clickIos
     *
     * @return int
     */
    public function getClickIos()
    {
        return $this->clickIos;
    }
}


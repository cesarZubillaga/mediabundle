<?php

namespace MediaBundle\Entity;

use AppBundle\Entity\Moderator;
use AppBundle\Entity\Team;

/**
 * Media
 */
class Media
{
    const TYPE_MEME = 0;
    const TYPE_VIDEO = 1;


    /**
     * @return array
     */
    static public function getStringTypes()
    {
        return array(
            self::TYPE_MEME => 'Meme',
            self::TYPE_VIDEO => 'Video',

        );
    }

    public function isMeme()
    {
        return self::TYPE_MEME == $this->getType();
    }

    public function isVideo()
    {
        return self::TYPE_VIDEO == $this->getType();
    }

    /**
     * @return mixed
     */
    public function getStringType()
    {
        return self::getStringTypes()[$this->getType()];
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return sprintf('%s%s', $this->getPath(), $this->getFile());
    }

    /**
     * Get from the web folder the location of the file.
     */
    public function getFileLocation()
    {
        return sprintf('%s/%s', $this->getPath(), $this->getFile());
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @var string
     */
    private $size;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $urlThumbnail;

    /**
     * @var \DateTime
     */
    private $payUntil;

    /**
     * @var boolean
     */
    private $active = false;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime
     */
    private $deletedAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Media
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Media
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return Media
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Media
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Media
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set urlThumbnail
     *
     * @param string $urlThumbnail
     *
     * @return Media
     */
    public function setUrlThumbnail($urlThumbnail)
    {
        $this->urlThumbnail = $urlThumbnail;

        return $this;
    }

    /**
     * Get urlThumbnail
     *
     * @return string
     */
    public function getUrlThumbnail()
    {
        return $this->urlThumbnail;
    }

    /**
     * Set payUntil
     *
     * @param \DateTime $payUntil
     *
     * @return Media
     */
    public function setPayUntil($payUntil)
    {
        $this->payUntil = $payUntil;

        return $this;
    }

    /**
     * Get payUntil
     *
     * @return \DateTime
     */
    public function getPayUntil()
    {
        return $this->payUntil;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Media
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Media
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Media
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Media
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}

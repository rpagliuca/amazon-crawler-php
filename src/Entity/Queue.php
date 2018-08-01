<?php

namespace RPagliuca\AmazonCrawler\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\RPagliuca\AmazonCrawler\Repository\Queue")
 */
class Queue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column
     */
    private $url;

    /**
     * @ORM\Column
     */
    private $status;

    /**
     * @ORM\Column(nullable=true)
     */
    private $processId;

    /**
     * @ORM\Column(type="datetime");
     */
    private $modifiedAt;

    /**
     * @ORM\Column(type="datetime");
     */
    private $createdAt;

    /**
     * Get id.
     *
     * @return id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param id the value to set.
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get url.
     *
     * @return url.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url.
     *
     * @param url the value to set.
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get status.
     *
     * @return status.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param status the value to set.
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get processId.
     *
     * @return processId.
     */
    public function getProcessId()
    {
        return $this->processId;
    }

    /**
     * Set processId.
     *
     * @param processId the value to set.
     */
    public function setProcessId($processId)
    {
        $this->processId = $processId;
        return $this;
    }

    /**
     * Get modifiedAt.
     *
     * @return modifiedAt.
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set modifiedAt.
     *
     * @param modifiedAt the value to set.
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return createdAt.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt.
     *
     * @param createdAt the value to set.
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}

<?php

namespace RPagliuca\AmazonCrawler\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Link
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\RPagliuca\AmazonCrawler\Entity\Node")
     */
    private $fromNode;

    /**
     * @ORM\ManyToOne(targetEntity="\RPagliuca\AmazonCrawler\Entity\Node")
     */
    private $toNode;

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
     * Get fromNode.
     *
     * @return fromNode.
     */
    public function getFromNode()
    {
        return $this->fromNode;
    }

    /**
     * Set fromNode.
     *
     * @param fromNode the value to set.
     */
    public function setFromNode($fromNode)
    {
        $this->fromNode = $fromNode;
        return $this;
    }

    /**
     * Get toNode.
     *
     * @return toNode.
     */
    public function getToNode()
    {
        return $this->toNode;
    }

    /**
     * Set toNode.
     *
     * @param toNode the value to set.
     */
    public function setToNode($toNode)
    {
        $this->toNode = $toNode;
        return $this;
    }
}

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
}

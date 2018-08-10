<?php

namespace RPagliuca\AmazonCrawler\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\RPagliuca\AmazonCrawler\Repository\Node")
 */
class Node
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $authors;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    /**
     * @ORM\Column(nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(nullable=true)
     */
    private $reviewCount;

    /**
     * @ORM\Column(nullable=true)
     */
    private $coverType;

    /**
     * @ORM\Column(nullable=true)
     */
    private $pages;

    /**
     * @ORM\Column(nullable=true)
     */
    private $width;

    /**
     * @ORM\Column(nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(nullable=true)
     */
    private $depth;

    /**
     * @ORM\Column(nullable=true)
     */
    private $weight;

    /**
     * @ORM\Column(nullable=true)
     */
    private $publisher;

    /**
     * @ORM\Column(nullable=true)
     */
    private $edition;

    /**
     * @ORM\Column(nullable=true)
     */
    private $publicationDate;

    /**
     * @ORM\Column(nullable=true)
     */
    private $rankingCategory;

    /**
     * @ORM\Column(nullable=true)
     */
    private $ranking;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category1;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category2;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category3;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category4;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category5;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category6;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category7;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category8;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category9;

    /**
     * @ORM\Column(nullable=true)
     */
    private $category10;

    /**
     * @ORM\Column(nullable=true)
     */
    private $isbn10;

    /**
     * @ORM\Column(nullable=true)
     */
    private $isbn13;

    /**
     * @ORM\Column(nullable=true)
     */
    private $language;

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
     * Get title.
     *
     * @return title.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param title the value to set.
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get price.
     *
     * @return price.
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price.
     *
     * @param price the value to set.
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
     * Get authors.
     *
     * @return authors.
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set authors.
     *
     * @param authors the value to set.
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * Get details.
     *
     * @return details.
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set details.
     *
     * @param details the value to set.
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * Get rating.
     *
     * @return rating.
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set rating.
     *
     * @param rating the value to set.
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Get reviewCount.
     *
     * @return reviewCount.
     */
    public function getReviewCount()
    {
        return $this->reviewCount;
    }

    /**
     * Set reviewCount.
     *
     * @param reviewCount the value to set.
     */
    public function setReviewCount($reviewCount)
    {
        $this->reviewCount = $reviewCount;
        return $this;
    }

    /**
     * Get coverType.
     *
     * @return coverType.
     */
    public function getCoverType()
    {
        return $this->coverType;
    }

    /**
     * Set coverType.
     *
     * @param coverType the value to set.
     */
    public function setCoverType($coverType)
    {
        $this->coverType = $coverType;
        return $this;
    }

    /**
     * Get pages.
     *
     * @return pages.
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set pages.
     *
     * @param pages the value to set.
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * Get width.
     *
     * @return width.
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set width.
     *
     * @param width the value to set.
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Get height.
     *
     * @return height.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set height.
     *
     * @param height the value to set.
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Get depth.
     *
     * @return depth.
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set depth.
     *
     * @param depth the value to set.
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }

    /**
     * Get weight.
     *
     * @return weight.
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set weight.
     *
     * @param weight the value to set.
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Get publisher.
     *
     * @return publisher.
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set publisher.
     *
     * @param publisher the value to set.
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
        return $this;
    }

    /**
     * Get edition.
     *
     * @return edition.
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * Set edition.
     *
     * @param edition the value to set.
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;
        return $this;
    }

    /**
     * Get publicationDate.
     *
     * @return publicationDate.
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * Set publicationDate.
     *
     * @param publicationDate the value to set.
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    /**
     * Get rankingCategory.
     *
     * @return rankingCategory.
     */
    public function getRankingCategory()
    {
        return $this->rankingCategory;
    }

    /**
     * Set rankingCategory.
     *
     * @param rankingCategory the value to set.
     */
    public function setRankingCategory($rankingCategory)
    {
        $this->rankingCategory = $rankingCategory;
        return $this;
    }

    /**
     * Get ranking.
     *
     * @return ranking.
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Set ranking.
     *
     * @param ranking the value to set.
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;
        return $this;
    }

    /**
     * Get category1.
     *
     * @return category1.
     */
    public function getCategory1()
    {
        return $this->category1;
    }

    /**
     * Set category1.
     *
     * @param category1 the value to set.
     */
    public function setCategory1($category1)
    {
        $this->category1 = $category1;
        return $this;
    }

    /**
     * Get category2.
     *
     * @return category2.
     */
    public function getCategory2()
    {
        return $this->category2;
    }

    /**
     * Set category2.
     *
     * @param category2 the value to set.
     */
    public function setCategory2($category2)
    {
        $this->category2 = $category2;
        return $this;
    }

    /**
     * Get category3.
     *
     * @return category3.
     */
    public function getCategory3()
    {
        return $this->category3;
    }

    /**
     * Set category3.
     *
     * @param category3 the value to set.
     */
    public function setCategory3($category3)
    {
        $this->category3 = $category3;
        return $this;
    }

    /**
     * Get category4.
     *
     * @return category4.
     */
    public function getCategory4()
    {
        return $this->category4;
    }

    /**
     * Set category4.
     *
     * @param category4 the value to set.
     */
    public function setCategory4($category4)
    {
        $this->category4 = $category4;
        return $this;
    }

    /**
     * Get category5.
     *
     * @return category5.
     */
    public function getCategory5()
    {
        return $this->category5;
    }

    /**
     * Set category5.
     *
     * @param category5 the value to set.
     */
    public function setCategory5($category5)
    {
        $this->category5 = $category5;
        return $this;
    }

    /**
     * Get category6.
     *
     * @return category6.
     */
    public function getCategory6()
    {
        return $this->category6;
    }

    /**
     * Set category6.
     *
     * @param category6 the value to set.
     */
    public function setCategory6($category6)
    {
        $this->category6 = $category6;
        return $this;
    }

    /**
     * Get category7.
     *
     * @return category7.
     */
    public function getCategory7()
    {
        return $this->category7;
    }

    /**
     * Set category7.
     *
     * @param category7 the value to set.
     */
    public function setCategory7($category7)
    {
        $this->category7 = $category7;
        return $this;
    }

    /**
     * Get category8.
     *
     * @return category8.
     */
    public function getCategory8()
    {
        return $this->category8;
    }

    /**
     * Set category8.
     *
     * @param category8 the value to set.
     */
    public function setCategory8($category8)
    {
        $this->category8 = $category8;
        return $this;
    }

    /**
     * Get category9.
     *
     * @return category9.
     */
    public function getCategory9()
    {
        return $this->category9;
    }

    /**
     * Set category9.
     *
     * @param category9 the value to set.
     */
    public function setCategory9($category9)
    {
        $this->category9 = $category9;
        return $this;
    }

    /**
     * Get category10.
     *
     * @return category10.
     */
    public function getCategory10()
    {
        return $this->category10;
    }

    /**
     * Set category10.
     *
     * @param category10 the value to set.
     */
    public function setCategory10($category10)
    {
        $this->category10 = $category10;
        return $this;
    }

    /**
     * Get isbn10.
     *
     * @return isbn10.
     */
    public function getIsbn10()
    {
        return $this->isbn10;
    }

    /**
     * Set isbn10.
     *
     * @param isbn10 the value to set.
     */
    public function setIsbn10($isbn10)
    {
        $this->isbn10 = $isbn10;
        return $this;
    }

    /**
     * Get isbn13.
     *
     * @return isbn13.
     */
    public function getIsbn13()
    {
        return $this->isbn13;
    }

    /**
     * Set isbn13.
     *
     * @param isbn13 the value to set.
     */
    public function setIsbn13($isbn13)
    {
        $this->isbn13 = $isbn13;
        return $this;
    }

    /**
     * Get language.
     *
     * @return language.
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set language.
     *
     * @param language the value to set.
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }
}

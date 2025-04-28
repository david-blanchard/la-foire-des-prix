<?php

    namespace App\Entity;

    use App\Repository\ProductRepository;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity(repositoryClass: ProductRepository::class)]
    class Product
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[ORM\Column(type: 'string', length: 255)]
        private ?string $name = null;

        #[ORM\Column(type: 'text')]
        private ?string $description = null;

        #[ORM\Column(type: 'text', nullable: true)]
        private ?string $moreInfos = null;

        #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
        private ?float $price = null;

        #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'products')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Brand $brand = null;

        #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, cascade: ['persist', 'remove'])]
        private Collection $productImages;

        #[ORM\OneToMany(mappedBy: 'product', targetEntity: CampaignProduct::class, cascade: ['persist', 'remove'])]
        private Collection $campaignProducts;

        public function __construct()
        {
            $this->productImages = new ArrayCollection();
            $this->campaignProducts = new ArrayCollection();
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function getName(): ?string
        {
            return $this->name;
        }

        public function setName(string $name): self
        {
            $this->name = $name;

            return $this;
        }

        public function getDescription(): ?string
        {
            return $this->description;
        }

        public function setDescription(string $description): self
        {
            $this->description = $description;

            return $this;
        }

        public function getMoreInfos(): ?string
        {
            return $this->moreInfos;
        }

        public function setMoreInfos(?string $moreInfos): self
        {
            $this->moreInfos = $moreInfos;

            return $this;
        }

        public function getPrice(): ?float
        {
            return $this->price;
        }

        public function setPrice(float $price): self
        {
            $this->price = $price;

            return $this;
        }

        public function getBrand(): ?Brand
        {
            return $this->brand;
        }

        public function setBrand(?Brand $brand): self
        {
            $this->brand = $brand;

            return $this;
        }

        public function getProductImages(): Collection
        {
            return $this->productImages;
        }

        public function addProductImage(ProductImage $productImage): self
        {
            if (!$this->productImages->contains($productImage)) {
                $this->productImages[] = $productImage;
                $productImage->setProduct($this);
            }

            return $this;
        }

        public function removeProductImage(ProductImage $productImage): self
        {
            if ($this->productImages->removeElement($productImage)) {
                if ($productImage->getProduct() === $this) {
                    $productImage->setProduct(null);
                }
            }

            return $this;
        }

        public function getCampaignProducts(): Collection
        {
            return $this->campaignProducts;
        }

        public function addCampaignProduct(CampaignProduct $campaignProduct): self
        {
            if (!$this->campaignProducts->contains($campaignProduct)) {
                $this->campaignProducts[] = $campaignProduct;
                $campaignProduct->setProduct($this);
            }

            return $this;
        }

        public function removeCampaignProduct(CampaignProduct $campaignProduct): self
        {
            if ($this->campaignProducts->removeElement($campaignProduct)) {
                if ($campaignProduct->getProduct() === $this) {
                    $campaignProduct->setProduct(null);
                }
            }

            return $this;
        }
    }

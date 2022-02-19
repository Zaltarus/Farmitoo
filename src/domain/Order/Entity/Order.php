<?php


namespace App\domain\Order\Entity;

use App\domain\Promotion\Entity\Promotion;
use App\domain\User\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Order
{

    private int $id;

    private User $user;

    /**
     * @var Collection<int, OrderItem>
     */
    private Collection $items;

    // Promotion sera un champs json dans la table order avec tout les détaille de la promotion
    // pas d'objet promotion car il est possible que la promotion soit modifié ou supprimé
    // mais pour le test je le passe en Promotion (plus simple à traiter)
    private ?Promotion $promotion;

    public function __construct(int $id, User $user)
    {
        $this->id = $id;
        $this->user = $user;
        $this->items = new ArrayCollection();
        $this->promotion = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): void
    {
        $this->items->add($item);
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): void
    {
        $this->promotion = $promotion;
    }
}

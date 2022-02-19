<?php


namespace App\domain\Order\Entity;

use App\domain\User\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Order
{

    private User $user;

    /**
     * @var Collection<int, OrderItem>
     */
    protected Collection $items;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->items = new ArrayCollection();
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

}

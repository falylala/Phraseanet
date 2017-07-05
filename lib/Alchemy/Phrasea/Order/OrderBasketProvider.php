<?php
/**
 * This file is part of Phraseanet
 *
 * (c) 2005-2016 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Phrasea\Order;

use Alchemy\Phrasea\Model\Entities\Basket;
use Alchemy\Phrasea\Model\Entities\Order;
use Alchemy\Phrasea\Model\Entities\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\TranslatorInterface;

class OrderBasketProvider
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(EntityManager $manager, TranslatorInterface $translator)
    {
        $this->manager = $manager;
        $this->translator = $translator;
    }

    public function provideBasketForOrderAndUser(Order $order, User $acceptor, $options = null)
    {
        $basket = $order->getBasket();

        if (null === $basket) {
            $basket = new Basket();

            if ($options) {
                $basket->setName($options['title']);
                $basket->setDescription($options['description']);
            } else {
                $basket->setName($this->translator->trans('Commande du %date%', [
                    '%date%' => $order->getCreatedOn()->format('Y-m-d'),
                ]));
                $basket->setPusher($acceptor);
            }

            $order->setBasket($basket);

            $basket->setUser($order->getUser());


            $this->manager->persist($basket);
            $this->manager->flush($basket);
        }

        return $basket;
    }
}

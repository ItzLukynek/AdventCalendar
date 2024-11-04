<?php
// src/Service/BoxService.php
namespace App\Service;

use App\Entity\Box;
use App\Repository\BoxRepository;
use DateTime;

class BoxService
{
    private BoxRepository $boxRepository;

    public function __construct(BoxRepository $boxRepository)
    {
        $this->boxRepository = $boxRepository;
    }

    /**
     *
     *
     * @return Box[] Array of boxes with a status (today, expired, blocked)
     */
    public function getBoxesWithStatus(): array
    {
        $boxes = $this->boxRepository->findAll();
        $todayDay = (int)(new DateTime())->format('j');

        foreach ($boxes as $box) {
            $boxNumber = $box->getNumber();

            if ($boxNumber === $todayDay) {
                $box->status = 'today';
            } elseif ($boxNumber < $todayDay) {
                $box->status = 'expired';
            } else {
                $box->status = 'blocked';
            }
        }

        return $boxes;
    }
}

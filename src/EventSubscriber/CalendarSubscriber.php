<?php

namespace App\EventSubscriber;

use App\Repository\EntretienRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $entretienRepository;
    private $router;

    public function __construct(
        EntretienRepository $entretienRepository,
        UrlGeneratorInterface $router
    ) {
        $this->entretienRepository = $entretienRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $entretiens = $this->entretienRepository
            ->createQueryBuilder('entretien')
            ->where('entretien.beginAt BETWEEN :start and :end OR entretien.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($entretiens as $entretien) {
            // this create the events with your data (here booking data) to fill calendar
            $entretienEvent = new Event(
                $entretien->getTitre(),
                $entretien->getBeginAt(),
                $entretien->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $entretienEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $entretienEvent->addOption(
                'url',
                $this->router->generate('app_entretien_show', [
                    'id' => $entretien->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($entretienEvent);
        }
    }
}
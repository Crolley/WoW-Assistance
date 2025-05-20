<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Character;
use App\Form\EventForm;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event')]
final class EventController extends AbstractController
{
    #[Route(name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $characterId = $request->getSession()->get('selected_character_id');
        $character = $entityManager->getRepository(Character::class)->find($characterId);

        if (!$character || !$character->getGuild()) {
            $this->addFlash('error', 'Impossible de créer un événement sans guilde.');
            return $this->redirectToRoute('app_dashboard');
        }

        $event = new Event();
        $form = $this->createForm(EventForm::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setGuild($character->getGuild());

            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_guild_events');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventForm::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_guild_events');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
    
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $submittedToken)) {
            $entityManager->remove($event);
            $entityManager->flush();
    
            $this->addFlash('success', 'Événement supprimé.');
        }
    
        return $this->redirectToRoute('app_guild_events');
    }
    

    #[Route('/guild/events', name: 'app_guild_events')]
    public function guildEvents(Request $request, EntityManagerInterface $em): Response
    {
        $characterId = $request->getSession()->get('selected_character_id');
        $character = $em->getRepository(Character::class)->find($characterId);

        if (!$character || !$character->getGuild()) {
            $this->addFlash('error', 'Pas de guilde trouvée.');
            return $this->redirectToRoute('app_dashboard');
        }

        $events = $em->getRepository(Event::class)->findBy(['guild' => $character->getGuild()]);

        return $this->render('event/guild_event.html.twig', [
            'events' => $events,
            'character' => $character,
        ]);
    }
}

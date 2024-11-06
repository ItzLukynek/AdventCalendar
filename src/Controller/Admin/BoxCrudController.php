<?php
// src/Controller/Admin/BoxCrudController.php

namespace App\Controller\Admin;

use App\Entity\Box;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class BoxCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;
    private AdminUrlGenerator $adminUrlGenerator;
    private RequestStack $requestStack;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return Box::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        //reset box to default
        $resetBox = Action::new('resetBox', 'Resetovat')
            ->linkToCrudAction('resetBox')
            ->setCssClass('btn btn-warning btn-sm');
        //reset active boxes for users
        $resetUserBoxes = Action::new('resetUserBoxes')
            ->setLabel('Resetovat aktivované boxy uživatelů')
            ->linkToCrudAction('resetBoxes')
            ->createAsGlobalAction()
            ->setCssClass('btn btn-danger btn-lg p-2');

        return $actions
            ->disable(Action::NEW)
            ->disable(Action::DELETE)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Edit')->displayAsLink();
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $resetBox)
            ->add(Crud::PAGE_INDEX, $resetUserBoxes);
    }


    public function resetBox(): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $id = $request ? $request->get('entityId') : null;

        if (!$id) {
            $this->addFlash('error', 'Nebylo nalezeno ID');
            return $this->redirectToRoute('admin', ['entity' => 'Box']);
        }

        $box = $this->entityManager->getRepository(Box::class)->find($id);
        if (!$box) {
            $this->addFlash('error', 'Nenalezen box');
            return $this->redirectToRoute('admin', ['entity' => 'Box']);
        }

        // Reset to default
        $box->resetToDefaults();
        $this->entityManager->persist($box);
        $this->entityManager->flush();

        $this->addFlash('success', 'Základní hodnoty byly nastaveny pro box s id: ' . $id);

        return $this->redirectToRoute('admin', ['entity' => 'Box']);
    }
    public function resetBoxes(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $user->resetBoxes();
        }

        $this->entityManager->flush();

        $this->addFlash('success', 'Uživatelům byly resetovány aktivované boxy');

        return new RedirectResponse($this->adminUrlGenerator->setController(self::class)->setAction('index')->generateUrl());
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('number')->setLabel('Den')->addCssClass('field-integer'),
            TextareaField::new('description')->setLabel('Popis')->addCssClass('field-textarea'),
            ColorField::new('color')->setLabel('Barva písma')->onlyOnForms()->addCssClass('field-color'),
            ColorField::new('bg_color')->setLabel('Barva pozadí')->onlyOnForms()->addCssClass('field-color'),
            TextField::new('button_text')->setLabel('Text tlačítka')->addCssClass('field-text'),
            TextField::new('button_link')->setLabel('Odkaz tlačítka')->addCssClass('field-link'),
            ImageField::new('image_url')
                ->setLabel('Obrázek v modálu')
                ->setUploadDir('public/uploads/images')
                ->setBasePath('uploads/images')
                ->setRequired(false)
                ->onlyOnForms()
                ->addCssClass('field-image'),
            ImageField::new('bg_image_url')
                ->setLabel('Pozadí')
                ->setUploadDir('public/uploads/images/boxbg')
                ->setBasePath('uploads/images/boxbg')
                ->setRequired(false)
                ->onlyOnForms()
                ->addCssClass('field-image'),
        ];
    }
}

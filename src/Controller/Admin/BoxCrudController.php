<?php
// src/Controller/Admin/BoxCrudController.php

namespace App\Controller\Admin;

use App\Entity\Box;
use App\Entity\User; // Assuming you have a User entity
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
use Symfony\Component\HttpFoundation\Response;

class BoxCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Box::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Boxes')
            ->setEntityLabelInPlural('Boxes')
            ->setEntityLabelInSingular('Box');
    }

    public function configureActions(Actions $actions): Actions
    {
        // Here we define our custom action for resetting boxes
        $resetBoxesAction = Action::new('resetBoxes', 'Reset All Boxes')
            ->setIcon('fa fa-trash') // Set the icon for the button
            ->setCssClass('btn btn-danger') // CSS class for styling
            ->linkToCrudAction('resetBoxes'); // Link to the reset action

        // Add the reset button to the toolbar of the index page
        return $actions
            ->add(Crud::PAGE_INDEX, $resetBoxesAction) // Add to the index page toolbar
            ->disable(Action::NEW) // Disable the new button if you don't want it
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Edit')->displayAsLink();
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('Number')->setLabel('Den'),
            TextareaField::new('description')->setLabel('Popis'),
            ColorField::new('color')->setLabel('Barva písma')->onlyOnForms(),
            ColorField::new('bg_color')->setLabel('Barva pozadí')->onlyOnForms(),
            TextField::new('button_text')->setLabel('Text tlačítka'),
            TextField::new('button_link')->setLabel('Odkaz tlačítka'),
            ImageField::new('image_url')
                ->setLabel('Obrázek')
                ->setUploadDir('public/uploads/images')
                ->setBasePath('uploads/images')
                ->setRequired(false)
                ->onlyOnForms(),
            ImageField::new('bg_image_url')
                ->setLabel('Pozadí')
                ->setUploadDir('public/uploads/images/boxbg')
                ->setBasePath('uploads/images/boxbg')
                ->setRequired(false)
                ->onlyOnForms(),
        ];
    }

    public function resetBoxes(): Response
    {
        // Fetch all users
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $user->resetBoxes(); // Reset boxes to an empty array
        }

        // Persist the changes
        $this->entityManager->flush();

        $this->addFlash('success', 'All boxes have been reset for all users.');

        // Redirect back to the index page or any other page
        return $this->redirectToRoute('easyadmin', ['entity' => 'Box']);
    }
}

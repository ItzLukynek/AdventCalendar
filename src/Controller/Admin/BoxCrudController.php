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
        $goToStripe = Action::new('Resetovat aktivované boxy uživatelů')
            ->linkToCrudAction('resetBoxes')
            ->createAsGlobalAction()
            ->setCssClass('btn btn-danger btn-lg p-2')
            ->setIcon('fa fa-trash')
        ;
        return $actions
            ->disable(Action::NEW)
            ->disable(Action::DELETE)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Edit')->displayAsLink();
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $goToStripe);
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
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $user->resetBoxes();
        }

        $this->entityManager->flush();

        $this->addFlash('success', 'Uživatelům byly resetovány aktivované boxy');

        return $this->redirectToRoute('admin', ['entity' => 'Box']);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Box;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BoxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Box::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, '');
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Edit')->displayAsLink(); // Displays Edit inline as a link/button
                 });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('Number')->setLabel('Den'),
            TextareaField::new('description')->setLabel('Popisek'),
            ColorField::new('color')
                ->setLabel('Barva písma')
                ->onlyOnForms(),
            ColorField::new('bg_color')
                ->setLabel('Barva pozadí')
                ->onlyOnForms(),

            TextField::new('button_text')->setLabel('Text tlačítka'),
            TextField::new('button_link')->setLabel('Odkaz tlačítka'),
            ImageField::new('image_url')
                ->setLabel('Obrázek')
                ->setUploadDir('public\uploads\images')
                ->setBasePath('uploads/images')
                ->setRequired(false)
                ->onlyOnForms(),
            ImageField::new('bg_image_url')
                ->setLabel('Pozadí')
                ->setUploadDir('public\uploads\images\boxbg')
                ->setBasePath('uploads/images/boxbg')
                ->setRequired(false)
                ->onlyOnForms(),
        ];
    }

}

<?php

namespace App\Controller\Admin;

use App\Entity\Box;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('Number')->setLabel('Den'),
            TextareaField::new('description')->setLabel('Popisek'),
            TextField::new('button_text')->setLabel('Text tlačítka'),
            TextField::new('button_link')->setLabel('Odkaz tlačítka'),
            ImageField::new('image_url')
                ->setLabel('Obrázek')
                ->setUploadDir('public\uploads\images')
                ->setBasePath('uploads/images')
                ->setRequired(false),
            ImageField::new('bg_image_url')
                ->setLabel('Pozadí')
                ->setUploadDir('public\uploads\images\boxbg')
                ->setBasePath('uploads/images/boxbg')
                ->setRequired(false),
        ];
    }

}

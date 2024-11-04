<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class SettingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Settings::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, '')
            ->setDefaultSort(['id' => 'ASC'])
            ->setEntityPermission('ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        yield BooleanField::new('auth')->renderAsSwitch()->setLabel("Ověřit přihlášení");
        yield BooleanField::new('shuffle')->renderAsSwitch()->setLabel("Zamíchat dny");
        yield BooleanField::new('show_gift')->setLabel("Ukázat dárek")->onlyOnForms();
        yield TextField::new('title')->setLabel("Nadpis");
        yield ImageField::new('bg_image_url')
            ->setLabel('Pozadí stránky')
            ->setUploadDir('public/uploads/images/bg')
            ->setBasePath('uploads/images/bg')
            ->setRequired(false);
        yield ColorField::new('title_color')
            ->setLabel('Barva nadpisu');

    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('main_settings');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW); //disabled add button
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->andWhere('entity.main_settings = :main_settings')
            ->setParameter('main_settings', true);

        return $qb;
    }
}

<?php

namespace App\Controller\Admin;


use App\Entity\Pizza;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class PizzaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pizza::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextField::new('content'),

            // Liste des ingrédients -> gestion 'Array'
            AssociationField::new('ingredient', 'name')
                ->formatValue(function ($value) {
                    // Si $value est une collection, on peut afficher les noms des ingrédients
                    if ($value) {
                        return implode(', ', array_map(function ($ingredient) {
                            return $ingredient->getName(); // Affiche le nom de chaque ingrédient
                        }, $value->toArray()));
                    }
                    return 'Aucun ingrédient';
                })
                ->onlyOnIndex(), // Affiche dans l'index

            // Display de l'image -> Gestion display 'FileType'
            ImageField::new('imageName', 'image')
                ->onlyOnIndex()
                ->setBasePath('uploads/images/'),
            ImageField::new('imageFile', 'image')
                ->onlyOnForms()
                ->setFormType(FileType::class)
        ];
    }
}

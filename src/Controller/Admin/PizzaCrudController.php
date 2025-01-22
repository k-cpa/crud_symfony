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

        // Tu peux laisser tout commenté et ça affiche tout automatiquement !! 
        return [
            TextField::new('name'),
            TextField::new('content'),

            // Liste des ingrédients -> gestion 'Array'
            AssociationField::new('ingredient', 'ingredients')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true, 
                    'choice_label'=> 'name', // champ à récupérer
                ]),

            // Display de l'image -> Gestion display 'FileType'
            ImageField::new('imageName', 'image')
                ->setBasePath('uploads/images/')
                ->setUploadDir('public/uploads/images/')
        ];
    }
}

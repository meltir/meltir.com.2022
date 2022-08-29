<?php

namespace App\Controller\Admin;

use App\Entity\PagePost;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PagePostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PagePost::class;
    }


    public function __configureFields(string $pageName): iterable
    {
        return [
            TextField::new('body'),
            BooleanField::new('active'),
        ];
    }

}

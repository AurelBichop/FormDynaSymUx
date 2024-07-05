<?php

namespace App\Form;

use App\Entity\Drink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class DrinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('teaOrCoffee', ChoiceType::class, [
                'choices' => [
                    '-- Choisir --'=>"",
                    'Tea'=> 'tea',
                    'Coffee' => 'coffee',
                ],
                'expanded'=> false,
                'multiple'=> false,
                'autocomplete' => true,
            ])
            ->addDependent('teaType', 'teaOrCoffee', function (DependentField $field, ?string $teaOrCoffee){
                if($teaOrCoffee === 'tea'){
                    $field
                        ->add(ChoiceType::class, [
                        'choices' => [
                            'Green'=> 'green',
                            'Black' => 'black',
                            'Herbal' => 'herbal',
                        ],
                        'expanded'=> false,
                        'multiple'=> false,
                        'autocomplete' => true,
                    ]);
                }
            })
            ->addDependent('coffeType', 'teaOrCoffee', function (DependentField $field, ?string $teaOrCoffee){
                if($teaOrCoffee === 'coffee'){
                    $field
                        ->add(ChoiceType::class, [
                            'choices' => [
                                'Expresso'=> 'expresso',
                                'Americano' => 'americano',
                                'Latte' => 'latte'
                            ],
                            'expanded'=> false,
                            'multiple'=> false,
                            'autocomplete' => true,
                        ]);
                }
            })
            ->add('sugar', ChoiceType::class,[
                'choices'=>[
                    'No sugar' => false,
                    'Sugar' => true
                ],
                'expanded'=> false,
                'multiple'=> false,
                'autocomplete' => true,
            ]);
/*             ->add('teaType', ChoiceType::class, [
                'choices' => [
                    'Green'=> 'green',
                    'Black' => 'black',
                    'Herbal' => 'herbal',
                ],
                'expanded'=> false,
                'multiple'=> false,
                'autocomplete' => true,
            ])
            ->add('coffeType', ChoiceType::class, [
                'choices' => [
                    'Expresso'=> 'expresso',
                    'Americano' => 'americano',
                    'Latte' => 'latte'
                ],
                'expanded'=> false,
                'multiple'=> false,
                'autocomplete' => true,
            ])
            ->add('sugar', ChoiceType::class,[
                'choices'=>[
                    'No sugar' => false,
                    'Sugar' => true
                ],
                'expanded'=> false,
                'multiple'=> false,
                'autocomplete' => true,
            ]) */
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Drink::class,
        ]);
    }
}

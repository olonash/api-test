<?php
namespace App\Form\Type;

use App\Services\VilleService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ReservationType
 * @package App\Form\Type
 */
class ReservationType extends AbstractType
{
    protected $villeService;

    /**
     * HotelType constructor.
     * @param VilleService $villeService
     */
    public function __construct(VilleService $villeService)
    {
        $this->villeService = $villeService;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom'])
            ->add('id', HiddenType::class, ['label' => 'Id'])
            ->add('prixAdulte', IntegerType::class, ['label' => 'prixAdulte'])
            ->add('prixEnfant', IntegerType::class, ['label' => 'prixEnfant'])
            ->add('ville', ChoiceType::class, [
                'label' => 'ville',
                'choices' => $this->getListeVille(),
                'preferred_choices' =>'/villes/6'
            ])
            ->add('hotel', ChoiceType::class, [
                'label' => 'Hotel',
                'choices' => []
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'csrf_protection' => false,
        ));
    }

    /**
     * @return array
     */
    protected function getListeVille()
    {
        $liste = [];
        $data = $this->villeService->liste();
        foreach ($data['hydra:member'] as $ville) {
            $liste[$ville['nom']] =  $ville['@id'];
        }

        return $liste;
    }

}

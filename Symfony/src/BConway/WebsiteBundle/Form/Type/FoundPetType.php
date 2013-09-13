<?php
// src/BConway/WebsiteBundle/Form/Type/FoundPetType.php
namespace BConway\WebsiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FoundPetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
        ->add('petType', 'choice', array(
            'choices' => array(
                'dog'   => 'Dog',
                'cat'   => 'Cat',
                'other' => 'Other'
            ),
            'expanded' => true,
            'multiple' => false,
            'label'    => 'Type'
        ))
        ->add('petName', 'text', array(
            'label' => 'Name (optional, if available)'
        ))
        ->add('petColors', 'text', array(
            'label' => 'Color(s)'
        ))
        ->add('petDescription', 'textarea', array(
            'label' => 'Description / What happened (optional)'
        ))
        ->add('petBreed', 'text', array(
            'label' => 'Breed (used for searching)'
        ))
        ->add('setPetLocationFoundCity', 'text', array(
            'label' => 'Location found (Street/City)<br />
                        (e.g. "Mongomery Ave, Cleveland" or<br />
                        "Montgomery Ave & Main St in Cleveland") '
        ))
        ->add('setPetLocationFoundState', 'choice', array(
            'choices' => array(
                'empty_value' => 'Choose a state',
                'AL'          => 'Alabama',
                'AK'          => 'Alaska',
                'AZ'          => 'Arizona',
                'AR'          => 'Arkansas',
                'CA'          => 'California',
                'CO'          => 'Colorado',
                'CT'          => 'Connecticut',
                'DE'          => 'Delaware',
                'DC'          => 'District Of Columbia',
                'FL'          => 'Florida',
                'GA'          => 'Georgia',
                'HI'          => 'Hawaii',
                'ID'          => 'Idaho',
                'IL'          => 'Illinois',
                'IN'          => 'Indiana',
                'IA'          => 'Iowa',
                'KS'          => 'Kansas',
                'KY'          => 'Kentucky',
                'LA'          => 'Louisiana',
                'ME'          => 'Maine',
                'MD'          => 'Maryland',
                'MA'          => 'Massachusetts',
                'MI'          => 'Michigan',
                'MN'          => 'Minnesota',
                'MS'          => 'Mississippi',
                'MO'          => 'Missouri',
                'MT'          => 'Montana',
                'NE'          => 'Nebraska',
                'NV'          => 'Nevada',
                'NH'          => 'New Hampshire',
                'NJ'          => 'New Jersey',
                'NM'          => 'New Mexico',
                'NY'          => 'New York',
                'NC'          => 'North Carolina',
                'ND'          => 'North Dakota',
                'OH'          => 'Ohio',
                'OK'          => 'Oklahoma',
                'OR'          => 'Oregon',
                'PA'          => 'Pennsylvania',
                'RI'          => 'Rhode Island',
                'SC'          => 'South Carolina',
                'SD'          => 'South Dakota',
                'TN'          => 'Tennessee',
                'TX'          => 'Texas',
                'UT'          => 'Utah',
                'VT'          => 'Vermont',
                'VA'          => 'Virginia',
                'WA'          => 'Washington',
                'WV'          => 'West Virginia',
                'WI'          => 'Wisconsin',
                'WY'          => 'Wyoming',
            ),
            'expanded' => false,
            'multiple' => false,
            'label'    => 'Location found (state)'
        ))
        ->add('petImage', 'file', array(
            'label' => 'Upload a picture (optional)<br/>
                        (JPEG, PNG or GIF)'
        ))
        ->add('deletePetImage', 'checkbox', array(
            'label' => 'Delete picture',
            'mapped' => false
        ))
        ->add('contactName', 'text', array(
            'label' => 'Name'
        ))
        ->add('contactEmail', 'email', array(
            'label' => 'Email'
        ))
        ->add('contactPhone', 'text', array(
            'label' => 'Phone number (optional)'
        ))
        ->add('save', 'submit');
    }

    public function getName()
    {
    return 'found_pet';
    }
}
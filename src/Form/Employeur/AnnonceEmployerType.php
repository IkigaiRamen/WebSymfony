<?php

namespace App\Form\Employeur;

use App\Entity\Annonce;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class AnnonceEmployerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description',TextareaType::class )  
            ->add('autres',TextAreaType::class)
            ->add('responsibilities',TextAreaType::class)
            ->add('eduexp',TextAreaType::class)
            ->add('expire',DateType::class)
            ->add('categorie',ChoiceType::class ,[
                'choices'=>[
                'Domaine'=>null,
                'Agriculture' => 'Agriculture'  ,
                'Agroalimentaire - Alimentation' =>'Agroalimentaire - Alimentation' ,
                'Animaux' => 'Animaux',
                'Architecture - Aménagement intérieur' => 'Architecture - Aménagement intérieur',
                'Artisanat - Métiers d art' => 'Artisanat - Métiers d art',
                'Banque - Finance - Assurance' => 'Banque - Finance - Assurance',
                'Bâtiment - Travaux publics' =>'Bâtiment - Travaux publics',
                'Biologie - Chimie' => 'Biologie - Chimie',
                'Commerce - Immobilier' => 'Commerce - Immobilier',
                'Communication - Information' => 'Communication - Information',
                'Culture - Spectacle' => 'Culture - Spectacle',
                'Défense - Sécurité - Secours' => 'Défense - Sécurité - Secours',
                'Droit' =>'Droit',
                'Edition - Imprimerie - Livre'=> 'Edition - Imprimerie - Livre',
                'Informatique - électronique' =>'Informatique - électronique',
                'Enseignement - Formation' => 'Enseignement - Formation',
                'Environnement - Nature - Nettoyage' => 'Environnement - Nature - Nettoyage',
                'Gestion - Audit - Ressources humaines' => 'Gestion - Audit - Ressources humaines',
                'Hôtellerie - Restauration - Tourisme' => 'Hôtellerie - Restauration - Tourisme',
                'Humanitaire' => 'Humanitaire',
                'Industrie - Matériaux' => 'Industrie - Matériaux',
                'Lettres - Sciences humaines' => 'Lettres - Sciences humaines',
                'Mécanique - Maintenance' => 'Mécanique - Maintenance',
                'Numérique - Multimédia - Audiovisuel' => 'Numérique - Multimédia - Audiovisuel',
                'Santé' => 'Santé',
                'Sciences - Maths - Physique' => 'Sciences - Maths - Physique',
                'Secrétariat - Accueil' => 'Secrétariat - Accueil',
                'Social - Services à la personne' => 'Social - Services à la personne',
                'Soins - Esthétique - Coiffure' => 'Soins - Esthétique - Coiffure' ,
                'Sport et animation' => 'Sport et animation',
                'Transport - Logistique'  =>'Sport et animation',
                'Autres secteurs' =>'Sport et animation',
                ] ])
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'À plein temps'=>'À plein temps',
                    'À temps partiel'=>'À temps partiel',
                    'Temporaire'=>'Temporaire',
                    'Permanant'=>'Permanant',
                    'Freelance'=>'Freelance'
                ]
            ])
            ->add('salairemin')
            ->add('salairemax')

            ->add('exp',ChoiceType::class,[
                'choices'=>[
                    'Experience'=>'0',
                    'Moins d un an'=>'1',
                    '2 années'=>'2',
                    '3 années'=>'3',
                    '4 années'=>'4',
                    'Plus que 5 ans'=>'5'
                ]
             ] )
             ->add('qualification',ChoiceType::class,[
                'choices'=>[
                    'Qualification'=>'',
                    'Immatriculation'=>'Immatriculation',
                    'Intermédiaire'=>'Intermédiaire',
                    'Diplômé'=>'Diplômé'
                ]
            ])
            ->add('sex',ChoiceType::class,[
                'choices'=>[
                    'Sex'=>'Sex',
                    'Homme'=>'Homme',
                    'Femme'=>'Femme'
                ]
                ])
            ->add('city' ,ChoiceType::class,[
                'choices'=>[   
                'Emplacement'=>null,            
                'Afghanistan'=>'Afghanistan' ,
                'Åland Islands'=>'Åland Islands' ,
                'Albania'=>'Albania' ,
                'Algeria'=>'Algeria' ,
                'American Samoa'=>'American Samoa' ,
                'Andorra'=>'Andorra' ,
                'Angola'=>'Angola' ,
                'Anguilla'=>'Anguilla' ,
                'Antarctica'=>'Antarctica' ,
                'Antigua and Barbuda'=>'Antigua and Barbuda' ,
                'Argentina'=>'Argentina' ,
                'Armenia'=>'Armenia' ,
                'Aruba'=>'Aruba' ,
                'Australia'=>'Australia' ,
                'Austria'=>'Austria' ,
                'Azerbaijan'=>'Azerbaijan' ,
                'Bahamas'=>'Bahamas' ,
                'Bahrain'=>'Bahrain' ,
                'Bangladesh'=>'Bangladesh' ,
                'Barbados'=>'Barbados' ,
                'Belarus'=>'Belarus' ,
                'Belgium'=>'Belgium' ,
                'Belize'=>'Belize' ,
                'Benin'=>'Benin' ,
                'Bermuda'=>'Bermuda' ,
                'Bhutan'=>'Bhutan' ,
                'Bolivia'=>'Bolivia' ,
                'Bosnia and Herzegovina'=>'Bosnia and Herzegovina' ,
                'Botswana'=>'Botswana' ,
                'Bouvet Island'=>'Bouvet Island' ,
                'Brazil'=>'Brazil' ,
                'British Indian Ocean Territory'=>'British Indian Ocean Territory' ,
                'Brunei Darussalam'=>'Brunei Darussalam' ,
                'Bulgaria'=>'Bulgaria' ,
                'Burkina Faso'=>'Burkina Faso' ,
                'Burundi'=>'Burundi' ,
                'Cambodia'=>'Cambodia' ,
                'Cameroon'=>'Cameroon' ,
                'Canada'=>'Canada' ,
                'Cape Verde'=>'Cape Verde' ,
                'Cayman Islands'=>'Cayman Islands' ,
                'Central African Republic'=>'Central African Republic' ,
                'Chad'=>'Chad' ,
                'Chile'=>'Chile' ,
                'China'=>'China' ,
                'Christmas Island'=>'Christmas Island' ,
                'Cocos (Keeling) Islands'=>'Cocos (Keeling) Islands' ,
                'Colombia'=>'Colombia' ,
                'Comoros'=>'Comoros' ,
                'Congo'=>'Congo' ,
                'Congo, The Democratic Republic of The'=>'Congo, The Democratic Republic of The' ,
                'Cook Islands'=>'Cook Islands' ,
                'Costa Rica'=>'Costa Rica' ,
                'Cote D ivoire'=>'Cote D ivoire' ,
                'Croatia'=>'Croatia' ,
                'Cuba'=>'Cuba' ,
                'Cyprus'=>'Cyprus' ,
                'Czechia'=>'Czechia' ,
                'Denmark'=>'Denmark' ,
                'Djibouti'=>'Djibouti' ,
                'Dominica'=>'Dominica' ,
                'Dominican Republic'=>'Dominican Republic' ,
                'Ecuador'=>'Ecuador' ,
                'Egypt'=>'Egypt' ,
                'El Salvador'=>'El Salvador' ,
                'Equatorial Guinea'=>'Equatorial Guinea' ,
                'Eritrea'=>'Eritrea' ,
                'Estonia'=>'Estonia' ,
                'Ethiopia'=>'Ethiopia' ,
                'Falkland Islands (Malvinas)'=>'Falkland Islands (Malvinas)' ,
                'Faroe Islands'=>'Faroe Islands' ,
                'Fiji'=>'Fiji' ,
                'Finland'=>'Finland' ,
                'France'=>'France' ,
                'French Guiana'=>'French Guiana' ,
                'French Polynesia'=>'French Polynesia' ,
                'French Southern Territories'=>'French Southern Territories' ,
                'Gabon'=>'Gabon' ,
                'Gambia'=>'Gambia' ,
                'Georgia'=>'Georgia' ,
                'Germany'=>'Germany' ,
                'Ghana'=>'Ghana' ,
                'Gibraltar'=>'Gibraltar' ,
                'Greece'=>'Greece' ,
                'Greenland'=>'Greenland' ,
                'Grenada'=>'Grenada' ,
                'Guadeloupe'=>'Guadeloupe' ,
                'Guam'=>'Guam' ,
                'Guatemala'=>'Guatemala' ,
                'Guernsey'=>'Guernsey' ,
                'Guinea'=>'Guinea' ,
                'Guinea-bissau'=>'Guinea-bissau' ,
                'Guyana'=>'Guyana' ,
                'Haiti'=>'Haiti' ,
                'Heard Island and Mcdonald Islands'=>'Heard Island and Mcdonald Islands' ,
                'Holy See (Vatican City State)'=>'Holy See (Vatican City State)' ,
                'Honduras'=>'Honduras' ,
                'Hong Kong'=>'Hong Kong' ,
                'Hungary'=>'Hungary' ,
                'Iceland'=>'Iceland' ,
                'India'=>'India' ,
                'Indonesia'=>'Indonesia' ,
                'Iran, Islamic Republic of'=>'Iran, Islamic Republic of' ,
                'Iraq'=>'Iraq' ,
                'Ireland'=>'Ireland' ,
                'Isle of Man'=>'Isle of Man' ,
                'Israel'=>'Israel' ,
                'Italy'=>'Italy' ,
                'Jamaica'=>'Jamaica' ,
                'Japan'=>'Japan' ,
                'Jersey'=>'Jersey' ,
                'Jordan'=>'Jordan' ,
                'Kazakhstan'=>'Kazakhstan' ,
                'Kenya'=>'Kenya' ,
                'Kiribati'=>'Kiribati' ,
                'Korea, Democratic People s Republic of'=>'Korea, Democratic People s Republic of' ,
                'Korea, Republic of'=>'Korea, Republic of' ,
                'Kuwait'=>'Kuwait' ,
                'Kyrgyzstan'=>'Kyrgyzstan' ,
                'Lao People s Democratic Republic'=>'Lao People s Democratic Republic' ,
                'Latvia'=>'Latvia' ,
                'Lebanon'=>'Lebanon' ,
                'Lesotho'=>'Lesotho' ,
                'Liberia'=>'Liberia' ,
                'Libyan Arab Jamahiriya'=>'Libyan Arab Jamahiriya' ,
                'Liechtenstein'=>'Liechtenstein' ,
                'Lithuania'=>'Lithuania' ,
                'Luxembourg'=>'Luxembourg' ,
                'Macao'=>'Macao' ,
                'Macedonia, The Former Yugoslav Republic of'=>'Macedonia, The Former Yugoslav Republic of' ,
                'Madagascar'=>'Madagascar' ,
                'Malawi'=>'Malawi' ,
                'Malaysia'=>'Malaysia' ,
                'Maldives'=>'Maldives' ,
                'Mali'=>'Mali' ,
                'Malta'=>'Malta' ,
                'Marshall Islands'=>'Marshall Islands' ,
                'Martinique'=>'Martinique' ,
                'Mauritania'=>'Mauritania' ,
                'Mauritius'=>'Mauritius' ,
                'Mayotte'=>'Mayotte' ,
                'Mexico'=>'Mexico' ,
                'Micronesia, Federated States of'=>'Micronesia, Federated States of' ,
                'Moldova, Republic of'=>'Moldova, Republic of' ,
                'Monaco'=>'Monaco' ,
                'Mongolia'=>'Mongolia' ,
                'Montenegro'=>'Montenegro' ,
                'Montserrat'=>'Montserrat' ,
                'Morocco'=>'Morocco' ,
                'Mozambique'=>'Mozambique' ,
                'Myanmar'=>'Myanmar' ,
                'Namibia'=>'Namibia' ,
                'Nauru'=>'Nauru' ,
                'Nepal'=>'Nepal' ,
                'Netherlands'=>'Netherlands' ,
                'Netherlands Antilles'=>'Netherlands Antilles' ,
                'New Caledonia'=>'New Caledonia' ,
                'New Zealand'=>'New Zealand' ,
                'Nicaragua'=>'Nicaragua' ,
                'Niger'=>'Niger' ,
                'Nigeria'=>'Nigeria' ,
                'Niue'=>'Niue' ,
                'Norfolk Island'=>'Norfolk Island' ,
                'Northern Mariana Islands'=>'Northern Mariana Islands' ,
                'Norway'=>'Norway' ,
                'Oman'=>'Oman' ,
                'Pakistan'=>'Pakistan' ,
                'Palau'=>'Palau' ,
                'Palestinian Territory, Occupied'=>'Palestinian Territory, Occupied' ,
                'Panama'=>'Panama' ,
                'Papua New Guinea'=>'Papua New Guinea' ,
                'Paraguay'=>'Paraguay' ,
                'Peru'=>'Peru' ,
                'Philippines'=>'Philippines' ,
                'Pitcairn'=>'Pitcairn' ,
                'Poland'=>'Poland' ,
                'Portugal'=>'Portugal' ,
                'Puerto Rico'=>'Puerto Rico' ,
                'Qatar'=>'Qatar' ,
                'Reunion'=>'Reunion' ,
                'Romania'=>'Romania' ,
                'Russian Federation'=>'Russian Federation' ,
                'Rwanda'=>'Rwanda' ,
                'Saint Helena'=>'Saint Helena' ,
                'Saint Kitts and Nevis'=>'Saint Kitts and Nevis' ,
                'Saint Lucia'=>'Saint Lucia' ,
                'Saint Pierre and Miquelon'=>'Saint Pierre and Miquelon' ,
                'Saint Vincent and The Grenadines'=>'Saint Vincent and The Grenadines' ,
                'Samoa'=>'Samoa' ,
                'San Marino'=>'San Marino' ,
                'Sao Tome and Principe'=>'Sao Tome and Principe' ,
                'Saudi Arabia'=>'Saudi Arabia' ,
                'Senegal'=>'Senegal' ,
                'Serbia'=>'Serbia' ,
                'Seychelles'=>'Seychelles' ,
                'Sierra Leone'=>'Sierra Leone' ,
                'Singapore'=>'Singapore' ,
                'Slovakia'=>'Slovakia' ,
                'Slovenia'=>'Slovenia' ,
                'Solomon Islands'=>'Solomon Islands' ,
                'Somalia'=>'Somalia' ,
                'South Africa'=>'South Africa' ,
                'South Georgia and The South Sandwich Islands'=>'South Georgia and The South Sandwich Islands' ,
                'Spain'=>'Spain' ,
                'Sri Lanka'=>'Sri Lanka' ,
                'Sudan'=>'Sudan' ,
                'Suriname'=>'Suriname' ,
                'Svalbard and Jan Mayen'=>'Svalbard and Jan Mayen' ,
                'Swaziland'=>'Swaziland' ,
                'Sweden'=>'Sweden' ,
                'Switzerland'=>'Switzerland' ,
                'Syrian Arab Republic'=>'Syrian Arab Republic' ,
                'Taiwan, Province of China'=>'Taiwan, Province of China' ,
                'Tajikistan'=>'Tajikistan' ,
                'Tanzania, United Republic of'=>'Tanzania, United Republic of' ,
                'Thailand'=>'Thailand' ,
                'Timor-leste'=>'Timor-leste' ,
                'Togo'=>'Togo' ,
                'Tokelau'=>'Tokelau' ,
                'Tonga'=>'Tonga' ,
                'Trinidad and Tobago'=>'Trinidad and Tobago' ,
                'Tunisia'=>'Tunisia' ,
                'Turkey'=>'Turkey' ,
                'Turkmenistan'=>'Turkmenistan' ,
                'Turks and Caicos Islands'=>'Turks and Caicos Islands' ,
                'Tuvalu'=>'Tuvalu' ,
                'Uganda'=>'Uganda' ,
                'Ukraine'=>'Ukraine' ,
                'United Arab Emirates'=>'United Arab Emirates' ,
                'United Kingdom'=>'United Kingdom' ,
                'United States'=>'United States' ,
                'United States Minor Outlying Islands'=>'United States Minor Outlying Islands' ,
                'Uruguay'=>'Uruguay' ,
                'Uzbekistan'=>'Uzbekistan' ,
                'Vanuatu'=>'Vanuatu' ,
                'Venezuela'=>'Venezuela' ,
                'Viet Nam'=>'Viet Nam' ,
                'Virgin Islands, British'=>'Virgin Islands, British' ,
                'Virgin Islands, U.S.'=>'Virgin Islands, U.S.' ,
                'Wallis and Futuna'=>'Wallis and Futuna' ,
                'Western Sahara'=>'Western Sahara' ,
                'Yemen'=>'Yemen' ,
                'Zambia'=>'Zambia' ,
                'Zimbabwe'=>'Zimbabwe' 
                ]
                        ])

            ->add('publier' ,SubmitType::class);
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}

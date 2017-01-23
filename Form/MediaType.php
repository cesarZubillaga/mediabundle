<?php
namespace MediaBundle\Form;

/**
 * Created by PhpStorm.
 * User: César Zubillaga Beraza
 * Date: 16/12/2016
 * Time: 09:56
 */

use MediaBundle\Entity\Media;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(isset($options['attr']['data'])){
            $defaultType = $options['attr']['data'];
        }else{
            $defaultType = null;
        }
        $builder
            ->add(
                'type',
                ChoiceType::class,
                array(
                    'label' => 'form.media.children.type.label',
                    'attr' => array(
                        'id' => 'form_media_type'
                    ),
                    'choices' => Media::getStringTypes(),
                    'expanded' => false,
                    'required' => true,
                )
            )
            ->add(
                'file',
                FileType::class,
                array(
                    'label' => 'form.media.children.file.label',
                    'attr' => array(
                        'data-type' => Media::TYPE_MEME,
                        'class' => 'fileUpload',
                        'data-target' => 'file-image-holder',
                    ),
                    'required' => false,
                    'data_class' => null,
                )
            )
            ->add(
                'url',
                UrlType::class,
                array(
                    'label' => 'form.media.children.url.label',
                    'attr' => array(
                        'data-type' => Media::TYPE_VIDEO,
                    ),
                    'required' => false,
                )
            )
            ->add(
                'urlThumbnail',
                TextType::class,
                array(
                    'label' => 'form.media.children.urlThumbnail.label',
                    'attr' => array(
                        'data-type' => Media::TYPE_VIDEO,
                    ),
                    'required' => false,
                )
            )
        ;

        /**
         * Non mapped value adds Logic on the Create or Update
         */
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($defaultType) {
                $form = $event->getForm();
                $media = $event->getData();
                $type = $form->get('type');
                $file = $form->get('file');
                if ($media instanceof Media && $media->getId() && $media->isMeme()) {

                } elseif ($media instanceof Media && $media->getId() && $media->isVideo()) {
                    $options = array_merge(
                        $file->getConfig()->getOptions(),
                        array(
                            'disabled' => true,
                        )
                    );
                    $form->add('file', ChoiceType::class, $options);
                }
                $options = array_merge(
                    $type->getConfig()->getOptions(),
                    array(
                        'disabled' => true,
                    )
                );
                if ($media instanceof Media && $media->getId()) {
                    $form->add('type', ChoiceType::class, $options);
                }
                if(null !== $defaultType && Media::TYPE_MEME == $defaultType){
                    $form->add('type', HiddenType::class, array(
                        'data' => Media::TYPE_MEME,
                    ));
                    $form->add('url', HiddenType::class);
                    $form->add('urlThumbnail', HiddenType::class);
                }

            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                /** @var Form $url */
                $url = ($form->get('url')) ? $form->get('url') : null;
                /** @var Form $urlThumbnail */
                $urlThumbnail = ($form->get('urlThumbnail')) ? $form->get('urlThumbnail') : null;
                $url->getConfig()->getDataClass();
                if (isset($data['type']) && Media::TYPE_MEME == intval($data['type'])) {
                    $form->add(
                        'file',
                        FileType::class,
                        array(
                            'attr' => array(
                                'data-type' => Media::TYPE_MEME,
                            ),
                            'required' => true,
                            'data_class' => null,
                        )
                    );
                } else {
                    $form->add(
                        'url',
                        $url->getConfig()->getDataClass(),
                        array_merge($url->getConfig()->getOptions(), array('required' => true,))
                    );
                    $form->add(
                        'urlThumbnail',
                        $urlThumbnail->getConfig()->getDataClass(),
                        array_merge($urlThumbnail->getConfig()->getOptions(), array('required' => true,))
                    );
                }
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => Media::class,
                'attr' => array(
                    'id' => 'form_media',
                ),
                'validation_groups' => function (FormInterface $form) {
                    /** @var Media $data */
                    $data = $form->getData();
                    if ($data->getId() && $data->isMeme()) {

                        return array(
                            'Default',
                            'meme',
                        );
                    } elseif ($data->isMeme()) {
                        return array(
                            'Default',
                            'meme_new',
                        );
                    } elseif ($data->isVideo()) {
                        return array(
                            'Default',
                            'video',
                        );
                    } else {
                        return array(
                            'Default',
                        );
                    }
                },
            )
        );
    }

}
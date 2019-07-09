<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserWorkspaceRights;
use App\Entity\Workspace;
use App\Hierarchy\ProjectRightsHierarchy;
use App\Repository\UserWorkspaceRightsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\OptionDefinitionException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectManageUsersType extends AbstractType
{

    /**
     * @var ProjectRightsHierarchy
     */
    private $rightsHierarchy;

    /**
     * @var UserWorkspaceRightsRepository
     */
    private $workspaceRightsRepository;

    public function __construct(ProjectRightsHierarchy $rightsHierarchy, UserWorkspaceRightsRepository $workspaceRightsRepository)
    {
        $this->rightsHierarchy = $rightsHierarchy;
        $this->workspaceRightsRepository = $workspaceRightsRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if(!$options['workspace'] instanceof Workspace){
            throw new OptionDefinitionException('Workspace not specified');
        }

        $choices = $this->rightsHierarchy->getHierarchy();
        $builder
            ->add('rights', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => $choices,
                'choice_attr' => function($choice, $key, $value){
                    return [
                        'data-children' => implode(" ", array_keys($choice->getChildren())),
                    ];
                },
                'choice_value' => function($choice){
                    return $choice->getItem()->getSignature();
                },
                'choice_label' => function($choice, $key, $value){
                    return $choice->getItem()->getDescription();
                },
                'label' => _('Права'),
            ])
            ->add('users', ChoiceType::class, [
                'multiple' => true,
                'choices' => $this->workspaceRightsRepository->getWorkspaceRelatedUsers($options['workspace']),
                'choice_label' =>
                function(UserWorkspaceRights $choice, $key, $value){
                    return $choice->getUser()->getUsername();
                },
                'label' => _('Пользователи'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'workspace' => null,
        ]);
    }



}

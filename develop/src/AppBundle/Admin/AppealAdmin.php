<?php

    namespace AppBundle\Admin;

    use Sonata\AdminBundle\Admin\Admin;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Form\FormMapper;

    class AppealAdmin extends Admin
    {
        // Устанавливаем значения сортировки по умолчанию
        protected $datagridValues = [
            '_sort_order' => 'DESC', // Порядок сортировки: DESC - убывающий
            '_sort_by' => 'createdAt', // Поле сортировки
        ];

        /**
         * Конфигурация формы редактирования
         */
        protected function configureFormFields(FormMapper $form)
        {
            $form
                ->add('name', 'text', ['label' => 'Имя'])
                ->add('surname', 'text', ['label' => 'Фамилия'])
                ->add('phone', 'text', ['label' => 'Телефон'])
                ->add('email', 'email', ['label' => 'Почта'])
                ->add('personType', 'choice', [
                    'label' => 'Тип лица',
                    'choices' => [
                        'FL' => 'Физическое лицо',
                        'YUL' => 'Юридическое лицо',
                    ],
                ])
                ->add('organization', 'text', ['label' => 'Организация', 'required' => false])
                ->add('message', 'textarea', ['label' => 'Сообщение'])
                ->add('createdAt', 'datetime', ['label' => 'Дата создания', 'disabled' => true]);
        }

        /**
         * Конфигурация фильтров в панели
         */
        protected function configureDatagridFilters(DatagridMapper $filter)
        {
            $filter
                ->add('name', null, ['label' => 'Имя'])
                ->add('surname', null, ['label' => 'Фамилия'])
                ->add('phone', null, ['label' => 'Телефон'])
                ->add('email', null, ['label' => 'Почта'])
                ->add('organization', null, ['label' => 'Организация'])
                ->add('personType', 'doctrine_orm_choice', [
                    'label' => 'Тип лица',
                    'field_options' => [
                        'choices' => [
                            'FL' => 'Физическое лицо',
                            'YUL' => 'Юридическое лицо',
                        ],
                        'placeholder' => 'Выберите тип лица',
                    ],
                    'field_type' => 'choice',
                ])
                ->add('apiStatus', 'doctrine_orm_choice', [
                    'label' => 'Статус отправки в УГД',
                    'field_options' => [
                        'choices' => [
                            'done' => 'Отправлено',
                            'failed' => 'Ошибка отправки',
                            'pending' => 'Отправляется',
                        ],
                        'placeholder' => 'Выберите статус',
                    ],
                    'field_type' => 'choice',
                ]);
        }

        /**
         * Конфигурация отображения списка
         */
        protected function configureListFields(ListMapper $list)
        {
            $list
                ->addIdentifier('id', null, ['label' => 'ID'])
                ->add('name', null, ['label' => 'Имя'])
                ->add('surname', null, ['label' => 'Фамилия'])
                ->add('phone', null, ['label' => 'Телефон'])
                ->add('email', null, ['label' => 'Почта'])
                ->add('personTypeText', null, ['label' => 'Тип лица'])
                ->add('organization', null, ['label' => 'Организация'])
                ->add('createdAt', 'datetime', ['label' => 'Дата создания'])
                ->add('apiStatus', 'text', [
                    'label' => 'Статус API',
                    'sortable' => true,
                    'template' => 'Admin/fields/api_status_field.html.twig',
                ])
                ->add('_action', 'actions', [
                    'actions' => [
                        'edit' => [],
                        'delete' => [],
                        'retry' => [
                            'route' => 'admin_app_appeal_retry_send',
                            'template' => 'Admin/actions/api_send_appeal_retry_button.html.twig',
                        ],
                    ],
                ]);
        }
    }

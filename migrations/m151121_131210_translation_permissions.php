<?php

use yeesoft\db\PermissionsMigration;

class m151121_131210_translation_permissions extends PermissionsMigration
{

    public function safeUp()
    {
        $this->addPermissionsGroup('translation-management', 'Translation Management');

        parent::safeUp();
    }

    public function safeDown()
    {
        parent::safeDown();
        $this->deletePermissionsGroup('translation-management');
    }

    public function getPermissions()
    {
        return [
            'translation-management' => [
                'view-translations' => [
                    'title' => 'View Translations',
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'translation/default', 'action' => 'index'],
                    ],
                ],
                'update-translations' => [
                    'title' => 'Update Translations',
                    'child' => ['view-translations'],
                    'roles' => [self::ROLE_ADMIN],
                ],
                'create-source-messages' => [
                    'title' => 'Create Source Messages',
                    'child' => ['view-translations'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'translation/source', 'action' => 'create'],
                    ],
                ],
                'update-source-messages' => [
                    'title' => 'Update Source Messages',
                    'child' => ['view-translations', 'update-translations'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'translation/source', 'action' => 'update'],
                    ],
                ],
                'delete-source-messages' => [
                    'title' => 'Delete Source Messages',
                    'child' => ['view-translations', 'update-source-messages'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'translation/source', 'action' => 'delete'],
                    ],
                ],
            ],
        ];
    }

}

<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use App\Model\Entity\TenantTheme;

/**
 * TenantThemes Model
 *
 * @method \App\Model\Entity\TenantTheme get($primaryKey, $options = [])
 * @method \App\Model\Entity\TenantTheme newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TenantTheme[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TenantTheme|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TenantTheme|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TenantTheme patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TenantTheme[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TenantTheme findOrCreate($search, callable $callback = null, $options = [])
 */
class TenantThemesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('tenant_themes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id'
        ]);
        $config = [
                'logo_name' => [
                'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForThemeLogo'),
                'fields' => [
                    'dir' => 'logo_path'
                ],
                'nameCallback' => function ($data, $settings) {
                    return time(). $data['name'];
                    },
                ],
        ];
        if(Configure::read('uploadSetting') === 's3'){
            $config['logo_name']['path'] = Configure::read('ImageUpload.uploadPathForThemeLogo'); 
            $config['logo_name']['filesystem'] = [
                    'adapter' => Configure::read('Josegonzalez/upload'),
                ];
        }
        $this->addBehavior('Josegonzalez/Upload.Upload', $config);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('theme_color_light')
            ->maxLength('theme_color_light', 255)
            ->allowEmpty('theme_color_light');

        $validator
            ->scalar('theme_color_dark')
            ->maxLength('theme_color_dark', 255)
            ->allowEmpty('theme_color_dark');

        $validator
            ->allowEmpty('logo_name');

        $validator
            ->scalar('logo_path')
            ->allowEmpty('logo_path');

        $validator
            ->scalar('content_area')
            ->allowEmpty('content_area');

        $validator
            ->scalar('content_sidebar')
            ->allowEmpty('content_sidebar');

        $validator
            ->scalar('content_header')
            ->allowEmpty('content_header');

        $validator
            ->scalar('content_footer')
            ->allowEmpty('content_footer');

        $validator
            ->scalar('redirect_url')
            ->maxLength('redirect_url', 255)
            ->allowEmpty('redirect_url');

        $validator
            ->scalar('color')
            ->maxLength('color', 255)
            ->allowEmpty('color');

        return $validator;
    }
}

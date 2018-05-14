<?php
namespace LilTaxRegisters\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Lil\Model\Table\IsOwnedByTrait;

/**
 * BusinessPremises Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Owners
 *
 * @method \LilTaxRegisters\Model\Entity\BusinessPremise get($primaryKey, $options = [])
 * @method \LilTaxRegisters\Model\Entity\BusinessPremise newEntity($data = null, array $options = [])
 * @method \LilTaxRegisters\Model\Entity\BusinessPremise[] newEntities(array $data, array $options = [])
 * @method \LilTaxRegisters\Model\Entity\BusinessPremise|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LilTaxRegisters\Model\Entity\BusinessPremise patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \LilTaxRegisters\Model\Entity\BusinessPremise[] patchEntities($entities, array $data, array $options = [])
 * @method \LilTaxRegisters\Model\Entity\BusinessPremise findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BusinessPremisesTable extends Table
{
    use IsOwnedByTrait;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('business_premises');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->notEmpty('issuer_taxno')
            ->add('issuer_taxno', [
                'numeric' => ['rule' => ['numeric']],
                'minLength' => ['rule' => ['minLength', 8]],
                'maxLength' => ['rule' => ['maxLength', 8]],
            ]);

        $validator
            ->notEmpty('no')
            ->add('no', [
                'alphanumeric' => ['rule' => ['alphanumeric']],
                'minLength' => ['rule' => ['minLength', 1]],
                'maxLength' => ['rule' => ['maxLength', 20]],
            ]);

        $validator
            ->notEmpty('title');

        $validator
            ->requirePresence('kind', 'create')
            ->notEmpty('kind');

        $validator
            ->allowEmpty('casadral_number')
            ->add('casadral_number', [
                'numeric' => ['rule' => ['numeric']],
                'minLength' => ['rule' => ['minLength', 1]],
                'maxLength' => ['rule' => ['maxLength', 4]],
            ]);

        $validator
            ->allowEmpty('building_number')
            ->add('building_number', [
                'numeric' => ['rule' => ['numeric']],
                'minLength' => ['rule' => ['minLength', 1]],
                'maxLength' => ['rule' => ['maxLength', 5]],
            ]);

        $validator
            ->allowEmpty('building_section_number')
            ->add('building_section_number', [
                'numeric' => ['rule' => ['numeric']],
                'minLength' => ['rule' => ['minLength', 1]],
                'maxLength' => ['rule' => ['maxLength', 4]],
            ]);

        $validator
            ->allowEmpty('street');

        $validator
            ->allowEmpty('house_number');

        $validator
            ->allowEmpty('house_number_additional');

        $validator
            ->allowEmpty('community');

        $validator
            ->allowEmpty('city');

        $validator
            ->allowEmpty('postal_code');

        $validator
            ->allowEmpty('mo_type');

        $validator
            ->date('validity_date')
            ->notEmpty('validity_date');

        $validator
            ->boolean('closed')
            ->notEmpty('closed');

        $validator
            ->allowEmpty('sw_taxno');

        $validator
            ->allowEmpty('sw_title');

        $validator
            ->allowEmpty('notes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }

    /**
     * Returns list of rooms for specified owner
     *
     * @param uuid $findType Company Id.
     * @param bool $ownerId Show only active accounts.
     * @return mixed
     */
    public function findForOwner($findType, $ownerId)
    {
        $conditions = ['owner_id' => $ownerId];
        $ret = $this->find($findType)
            ->where($conditions)
            ->order('title');

        $ret->all();

        return $ret;
    }
}

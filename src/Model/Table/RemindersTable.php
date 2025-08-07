<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reminders Model
 *
 * @property \App\Model\Table\GendersTable&\Cake\ORM\Association\BelongsTo $Genders
 * @property \App\Model\Table\TemplatesTable&\Cake\ORM\Association\BelongsTo $Templates
 *
 * @method \App\Model\Entity\Reminder newEmptyEntity()
 * @method \App\Model\Entity\Reminder newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Reminder> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reminder get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Reminder findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Reminder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Reminder> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reminder|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Reminder saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Reminder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Reminder>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Reminder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Reminder> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Reminder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Reminder>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Reminder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Reminder> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RemindersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reminders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Genders', [
            'foreignKey' => 'gender_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Templates', [
            'foreignKey' => 'template_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
         $validator
            ->scalar('name')
            ->maxLength('name', 155)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');
        $validator
            ->integer('gender_id')
            ->notEmptyString('gender_id');

        $validator
            ->integer('template_id')
            ->notEmptyString('template_id');

        $validator
            ->integer('date_before1')
            ->notEmptyString('date_before1');

        $validator
            ->integer('date_before2')
            ->notEmptyString('date_before2');

        $validator
            ->integer('date_before3')
            ->notEmptyString('date_before3');

        $validator
            ->integer('date_before4')
            ->notEmptyString('date_before4');

        $validator
            ->integer('days_after')
            ->notEmptyString('days_after');

        $validator
            ->integer('create_uid')
            ->requirePresence('create_uid', 'create')
            ->notEmptyString('create_uid');

        $validator
            ->integer('write_uid')
            ->requirePresence('write_uid', 'create')
            ->notEmptyString('write_uid');

        $validator
            ->uuid('uuid')
            ->requirePresence('uuid', 'create')
            ->notEmptyString('uuid');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['gender_id'], 'Genders'), ['errorField' => 'gender_id']);
        $rules->add($rules->existsIn(['template_id'], 'Templates'), ['errorField' => 'template_id']);

        return $rules;
    }
}

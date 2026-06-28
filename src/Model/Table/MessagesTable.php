<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Messages Model
 *
 * @property \App\Model\Table\InspectionsTable&\Cake\ORM\Association\BelongsTo $Inspections
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \App\Model\Entity\Message newEmptyEntity()
 * @method \App\Model\Entity\Message newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Message> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Message get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Message findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Message patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Message> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Message|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Message saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Message>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Message>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Message>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Message> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Message>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Message>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Message>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Message> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MessagesTable extends Table
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

        $this->setTable('messages');
        $this->setDisplayField('sender_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Inspections', [
            'foreignKey' => 'inspection_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id',
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
        // $validator
        //     ->scalar('sender_name')
        //     ->maxLength('sender_name', 11)
        //     ->requirePresence('sender_name', 'create')
        //     ->notEmptyString('sender_name');

        $validator
            ->scalar('receiver')
            ->maxLength('receiver', 10)
            ->requirePresence('receiver', 'create')
            ->notEmptyString('receiver');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        // $validator
        //     ->integer('create_uid')
        //     ->requirePresence('create_uid', 'create')
        //     ->notEmptyString('create_uid');

        // $validator
        //     ->integer('write_uid')
        //     ->requirePresence('write_uid', 'create')
        //     ->notEmptyString('write_uid');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 40)
            ->requirePresence('uuid', 'create')
            ->notEmptyString('uuid');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->dateTime('sent_date')
            ->requirePresence('sent_date', 'create')
            ->notEmptyDateTime('sent_date');

        // $validator
        //     ->integer('response_code')
        //     ->requirePresence('response_code', 'create')
        //     ->notEmptyString('response_code');

        // $validator
        //     ->scalar('response_body')
        //     ->requirePresence('response_body', 'create')
        //     ->notEmptyString('response_body');

        // $validator
        //     ->integer('parts')
        //     ->requirePresence('parts', 'create')
        //     ->notEmptyString('parts');

        // $validator
        //     ->integer('inspection_id')
        //     ->notEmptyString('inspection_id');

        // $validator
        //     ->integer('customer_id')
        //     ->notEmptyString('customer_id');

        // $validator
        //     ->scalar('direction')
        //     ->maxLength('direction', 3)
        //     ->notEmptyString('direction');

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
        $rules->add($rules->existsIn(['inspection_id'], 'Inspections'), ['errorField' => 'inspection_id']);
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['contact_id'], 'Contacts'), ['errorField' => 'contact_id']);
        return $rules;
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Motifs Model
 *
 * @property \App\Model\Table\StartupsTable&\Cake\ORM\Association\BelongsTo $Startups
 * @property \App\Model\Table\CashMovementsTable&\Cake\ORM\Association\HasMany $CashMovements
 *
 * @method \App\Model\Entity\Motif newEmptyEntity()
 * @method \App\Model\Entity\Motif newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Motif> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Motif get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Motif findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Motif patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Motif> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Motif|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Motif saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Motif>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Motif>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Motif>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Motif> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Motif>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Motif>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Motif>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Motif> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MotifsTable extends Table
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

        $this->setTable('motifs');
        $this->setDisplayField('uuid');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Startups', [
            'foreignKey' => 'startup_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('CashMovements', [
            'foreignKey' => 'motif_id',
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
            ->scalar('content')
            ->maxLength('content', 300)
            ->requirePresence('content', 'create')
            ->notEmptyString('content');
            
        $validator
            ->integer('create_uid')
            ->requirePresence('create_uid', 'create')
            ->notEmptyString('create_uid');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 40)
            ->requirePresence('uuid', 'create')
            ->notEmptyString('uuid');

        $validator
            ->integer('startup_id')
            ->notEmptyString('startup_id');

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
        $rules->add($rules->existsIn(['startup_id'], 'Startups'), ['errorField' => 'startup_id']);

        return $rules;
    }
}

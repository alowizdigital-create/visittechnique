<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Startups Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\HasMany $Customers
 * @property \App\Model\Table\GendersTable&\Cake\ORM\Association\HasMany $Genders
 * @property \App\Model\Table\MotifsTable&\Cake\ORM\Association\HasMany $Motifs
 *
 * @method \App\Model\Entity\Startup newEmptyEntity()
 * @method \App\Model\Entity\Startup newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Startup> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Startup get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Startup findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Startup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Startup> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Startup|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Startup saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Startup>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Startup>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Startup>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Startup> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Startup>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Startup>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Startup>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Startup> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StartupsTable extends Table
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

        $this->setTable('startups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Customers', [
            'foreignKey' => 'startup_id',
        ]);
        $this->hasMany('Genders', [
            'foreignKey' => 'startup_id',
        ]);
        $this->hasMany('Motifs', [
            'foreignKey' => 'startup_id',
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
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('create_uid')
            ->requirePresence('create_uid', 'create')
            ->notEmptyString('create_uid');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 40)
            ->requirePresence('uuid', 'create')
            ->notEmptyString('uuid');

        return $validator;
    }
}

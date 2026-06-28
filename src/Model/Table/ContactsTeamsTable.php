<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactsTeams Model
 *
 * @property \App\Model\Table\ContactsTable&\Cake\ORM\Association\BelongsTo $Contacts
 * @property \App\Model\Table\TeamsTable&\Cake\ORM\Association\BelongsTo $Teams
 *
 * @method \App\Model\Entity\ContactsTeam newEmptyEntity()
 * @method \App\Model\Entity\ContactsTeam newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactsTeam> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContactsTeam get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ContactsTeam findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ContactsTeam patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactsTeam> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContactsTeam|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ContactsTeam saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ContactsTeam>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactsTeam>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactsTeam>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactsTeam> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactsTeam>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactsTeam>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactsTeam>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactsTeam> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ContactsTeamsTable extends Table
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

        $this->setTable('contacts_teams');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Teams', [
            'foreignKey' => 'team_id',
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
            ->integer('contact_id')
            ->notEmptyString('contact_id');

        $validator
            ->integer('team_id')
            ->notEmptyString('team_id');

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
        $rules->add($rules->existsIn(['contact_id'], 'Contacts'), ['errorField' => 'contact_id']);
        $rules->add($rules->existsIn(['team_id'], 'Teams'), ['errorField' => 'team_id']);

        return $rules;
    }
}

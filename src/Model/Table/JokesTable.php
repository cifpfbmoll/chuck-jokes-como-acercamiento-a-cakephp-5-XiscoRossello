<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Jokes Model
 *
 * @method \App\Model\Entity\Joke newEmptyEntity()
 * @method \App\Model\Entity\Joke newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Joke> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Joke get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Joke findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Joke patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Joke> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Joke|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Joke saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Joke>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Joke>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Joke>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Joke> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Joke>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Joke>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Joke>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Joke> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class JokesTable extends Table
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

        $this->setTable('jokes');
        $this->setDisplayField('setup');
        $this->setPrimaryKey('id');

        // Optimización: configurar Timestamp behavior con opciones específicas
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
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
            ->scalar('setup')
            ->maxLength('setup', 255)
            ->requirePresence('setup', 'create')
            ->notEmptyString('setup');

        $validator
            ->scalar('punchline')
            ->maxLength('punchline', 255)
            ->allowEmptyString('punchline');

        return $validator;
    }

    /**
     * Método optimizado para verificar si un chiste ya existe
     * 
     * @param string $setup El texto del chiste
     * @return bool
     */
    public function jokeExists(string $setup): bool
    {
        return $this->exists(['setup' => $setup]);
    }

    /**
     * Método optimizado para guardar chiste rápidamente
     * 
     * @param string $setup
     * @param string $punchline
     * @return bool
     */
    public function saveJokeFast(string $setup, string $punchline = ''): bool
    {
        // Verificar duplicado primero (opcional)
        if ($this->jokeExists($setup)) {
            return false; // Ya existe
        }

        // Inserción directa optimizada
        $data = [
            'setup' => substr($setup, 0, 255),
            'punchline' => substr($punchline, 0, 255),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        ];

        return (bool) $this->getConnection()->insert('jokes', $data);
    }
}

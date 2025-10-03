<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Jokes Controller
 */
class JokesController extends AppController
{
    /**
     * Random method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function random()
    {
        $joke = null;
        $error = null;

        // Si es POST (guardar chiste), procesar primero
        if ($this->request->is('post')) {
            $setup = $this->request->getData('setup');
            $punchline = $this->request->getData('punchline');
            
            if (!empty($setup)) {
                // En CakePHP 5 usa fetchTable('Jokes') (no loadModel)
                $jokesTable = $this->fetchTable('Jokes');
                
                // Optimización: usar método rápido de guardado
                $saved = $jokesTable->saveJokeFast($setup, $punchline ?: '');
                
                if ($saved) {
                    // Mensajes flash de éxito
                    $this->Flash->success(__('¡Chiste guardado exitosamente!'));
                    // Limpiar sesión después de guardar para forzar nuevo chiste
                    $this->request->getSession()->delete('current_joke');
                    return $this->redirect(['action' => 'random']);
                } else {
                    // Podría ser duplicado o error de BD
                    if ($jokesTable->jokeExists($setup)) {
                        $this->Flash->warning(__('Este chiste ya existe en la base de datos.'));
                    } else {
                        $this->Flash->error(__('Error en la base de datos. Inténtalo de nuevo.'));
                    }
                }
            } else {
                $this->Flash->error(__('No hay chiste para guardar.'));
            }
        }

        // Solo obtener nuevo chiste si no es POST o si no hay chiste en sesión
        if (!$this->request->is('post') || empty($this->request->getSession()->read('current_joke'))) {
            // Realizar petición GET a la API de Chuck Norris con timeout optimizado
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5, // Timeout de 5 segundos
                    'method' => 'GET',
                    'header' => 'User-Agent: CakePHP-ChuckJokes/1.0'
                ]
            ]);

            try {
                $response = file_get_contents('https://api.chucknorris.io/jokes/random', false, $context);
                if ($response !== false) {
                    $data = json_decode($response, true);
                    if (isset($data['value'])) {
                        // Recortar a 255 caracteres para cumplir la longitud
                        $joke = substr($data['value'], 0, 255);
                        // Guardar en sesión para evitar nuevas peticiones en recargas
                        $this->request->getSession()->write('current_joke', $joke);
                    }
                }
            } catch (Exception $e) {
                $error = 'Error al obtener el chiste: ' . $e->getMessage();
            }

            // Si no se pudo obtener un chiste nuevo, intentar usar el de la sesión
            if (!$joke && !$error) {
                $joke = $this->request->getSession()->read('current_joke');
                if (!$joke) {
                    $error = 'No se pudo obtener un chiste. Inténtalo de nuevo.';
                }
            }
        } else {
            // Usar el chiste de la sesión en peticiones POST
            $joke = $this->request->getSession()->read('current_joke');
        }

        $this->set(compact('joke', 'error'));
    }

    /**
     * Obtener nuevo chiste (limpiar sesión y redirigir)
     */
    public function newJoke()
    {
        $this->request->getSession()->delete('current_joke');
        return $this->redirect(['action' => 'random']);
    }
}
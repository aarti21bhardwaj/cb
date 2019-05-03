<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StudentTransferHistories Controller
 *
 * @property \App\Model\Table\StudentTransferHistoriesTable $StudentTransferHistories
 *
 * @method \App\Model\Entity\StudentTransferHistory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentTransferHistoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Students', 'PreviousCourses', 'CurrentCourses']
        ];
        $studentTransferHistories = $this->paginate($this->StudentTransferHistories);

        $this->set(compact('studentTransferHistories'));
    }

    /**
     * View method
     *
     * @param string|null $id Student Transfer History id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $studentTransferHistory = $this->StudentTransferHistories->get($id, [
            'contain' => ['Students', 'PreviousCourses', 'CurrentCourses']
        ]);

        $this->set('studentTransferHistory', $studentTransferHistory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $studentTransferHistory = $this->StudentTransferHistories->newEntity();
        if ($this->request->is('post')) {
            $studentTransferHistory = $this->StudentTransferHistories->patchEntity($studentTransferHistory, $this->request->getData());
            if ($this->StudentTransferHistories->save($studentTransferHistory)) {
                $this->Flash->success(__('The student transfer history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student transfer history could not be saved. Please, try again.'));
        }
        $students = $this->StudentTransferHistories->Students->find('list', ['limit' => 200]);
        $previousCourses = $this->StudentTransferHistories->PreviousCourses->find('list', ['limit' => 200]);
        $currentCourses = $this->StudentTransferHistories->CurrentCourses->find('list', ['limit' => 200]);
        $this->set(compact('studentTransferHistory', 'students', 'previousCourses', 'currentCourses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Student Transfer History id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $studentTransferHistory = $this->StudentTransferHistories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $studentTransferHistory = $this->StudentTransferHistories->patchEntity($studentTransferHistory, $this->request->getData());
            if ($this->StudentTransferHistories->save($studentTransferHistory)) {
                $this->Flash->success(__('The student transfer history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student transfer history could not be saved. Please, try again.'));
        }
        $students = $this->StudentTransferHistories->Students->find('list', ['limit' => 200]);
        $previousCourses = $this->StudentTransferHistories->PreviousCourses->find('list', ['limit' => 200]);
        $currentCourses = $this->StudentTransferHistories->CurrentCourses->find('list', ['limit' => 200]);
        $this->set(compact('studentTransferHistory', 'students', 'previousCourses', 'currentCourses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Student Transfer History id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studentTransferHistory = $this->StudentTransferHistories->get($id);
        if ($this->StudentTransferHistories->delete($studentTransferHistory)) {
            $this->Flash->success(__('The student transfer history has been deleted.'));
        } else {
            $this->Flash->error(__('The student transfer history could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php

namespace App\Controllers;

use App\Models\Note;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class NotesController extends ResourceController
{
    protected $modelName = 'App\Models\Note';
    protected $format    = 'json';

    /**
     * Return an array of all notes
     *
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $model = new Note();
        $page = $this->request->getGet('page') ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $notes = $model->orderBy('updated_at', 'DESC')->findAll($limit, $offset);
        $total = $model->countAllResults();
        $pages = ceil($total / $limit);
        return $this->respond([
            'data' => $notes,
            'code' => count($notes) > 0 ? 200 : 404,
            'message' => count($notes) > 0 ? "Berhasil menampilkan notes di halaman $page" : "Tidak ada notes",
            'meta' => [
                'page' => $page,
                'limit' => $limit,
                'offset' => $offset,
                'total' => $total,
                'pages' => $pages,
            ]
        ], count($notes) > 0 ? 200 : 404);
    }

    /**
     * Return a specific note by ID
     *
     * @param int|null $id
     * @return ResponseInterface
     */
    public function show($id = null): ResponseInterface
    {
        $model = new Note();
        $note = $model->find($id);

        if ($note === null) {
            return $this->respond([
                'code' => 404,
                'message' => 'Note not found',
            ], 404);
        }

        return $this->respond([
            'data' => $note,
            'code' => 200,
            'message' => 'Berhasil menampilkan note dengan id ' . $id,
        ], 200);
    }

    /**
     * Create a new note
     *
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {
        $model = new Note();
        $data = $this->request->getJSON(true);

        if (!$model->save($data)) {
            return $this->respond([
                'code' => 400,
                'message' => 'Bad Request',
                'errors' => $model->errors(),
            ], 400);
        }

        return $this->respond([
            'data' => $data,
            'code' => 201,
            'message' => 'Berhasil menambahkan note',
        ], 201);
    }

    /**
     * Update an existing note
     *
     * @param int|null $id
     * @return ResponseInterface
     */
    public function update($id = null): ResponseInterface
    {
        $model = new Note();
        $data = $this->request->getJSON(true);

        if (!$model->update($id, $data)) {
            return $this->respond([
                'code' => 400,
                'message' => 'Bad Request',
                'errors' => $model->errors(),
            ], 400);
        }

        return $this->respond([
            'code' => 200,
            'message' => 'Berhasil mengupdate note dengan id ' . $id,
        ], 200);
    }

    /**
     * Delete a note
     *
     * @param int|null $id
     * @return ResponseInterface
     */
    public function delete($id = null): ResponseInterface
    {
        $model = new Note();
        $note = $model->find($id);

        if ($note === null) {
            return $this->respond([
                'code' => 404,
                'message' => 'Note not found',
            ], 404);
        }

        if (!$model->delete($id)) {
            return $this->respond([
                'code' => 500,
                'message' => 'Could not delete note',
            ], 500);
        }

        return $this->respond([
            'code' => 200,
            'message' => 'Berhasil menghapus note dengan id ' . $id,
        ], 200);
    }
}


<?php

namespace App\Controllers;

// use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BeritaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Api extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        $model = new BeritaModel();
        $data = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond(['message' => 'success', 'data'=> $data]);
    }

    public function show($id = null)
    {
        $model = new BeritaModel();
        $data = $model->where('id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Berita Tidak Ditemukan.');
        }
    }

    public function create()
    {
        $model = new BeritaModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi' => $this->request->getVar('isi'),
            'gambar' => $this->request->getVar('gambar')
        ];
        $model->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berita berhasil ditambah.'
            ]
        ];
        return $this->respondCreated($response);
    }

    public function update($id = null)
    {
        $model = new BeritaModel();
        // $data = [
        //     'judul' => $this->request->getVar('judul'),
        //     'isi' => $this->request->getVar('isi'),
        //     'gambar' => $this->request->getVar('gambar')
        // ];
        $input = $this->request->getRawInput();
        $data = [
            'judul' => $input['judul'],
            'isi' => $input['isi'],
            'gambar' => $input['gambar']
        ];
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Berita Berhassil Diubah.'
            ]
        ];
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $model = new BeritaModel();
        $data = $model->where('id', $id)->delete($id);
        if($data){
            $model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Berita Berhasil Dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Berita Tidak Ditemukan.');
        }

    }
}

<?php 

use GuzzleHttp\Client;

class Mahasiswa_model extends CI_model {

    private $_client;
    public function __construct(){
        $this->_client = new Client([
        'base_uri'=>'http://localhost/practice/api/rest-server/api/',
        'auth'=>['admin','1234'],
        ]);  
    }
    
    public function getAllMahasiswa()
    {

        $response=$this->_client->request('GET','mahasiswa',
        [
            'auth'=>['admin','1234'],
            'query'=>[
                'giddy-key'=>'rahasiailahi',
                ]
            ]);

            $result =json_decode($response->getBody()->getContents(), true);
            return $result['data'];

    }

    public function getMahasiswaById($id)
    {
        $response=$this->_client->request('GET','mahasiswa',
        [
            'auth'=>['admin','1234'],
            'query'=>[
                'giddy-key'=>'rahasiailahi',
                'id'=>$id
                ]
            ]);

            $result =json_decode($response->getBody()->getContents(), true);
            return $result['data'][0];
    }


    public function tambahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            'giddy-key'=>'rahasiailahi'
        ];

        $response=$this->_client->request('POST','mahasiswa',[
            'form_params'=>
                $data 
       ]);
       $result =json_decode($response->getBody()->getContents(), true);
    }

    public function hapusDataMahasiswa($id)
    {
       $response=$this->_client->request('DELETE','mahasiswa',[
            'form_params'=>[
                'id'=>$id,
                'giddy-key'=>'rahasiailahi'
            ] 
       ]);
       $result =json_decode($response->getBody()->getContents(), true);
    }

    

    public function ubahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            "id" => $this->input->post('id', true),
            'giddy-key'=>'rahasiailahi'
        ];

        $response=$this->_client->request('PUT','mahasiswa',[
            'form_params'=>
                $data ,

       ]);
       $result =json_decode($response->getBody()->getContents(), true);
    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}
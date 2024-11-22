<?php
// File: classes/Menu.php
class Menu {
    private $id;
    private $nama;
    private $harga;
    private $deskripsi;
    private $status;

    public function __construct($nama, $harga, $deskripsi) {
        $this->nama = $nama;
        $this->harga = $harga;
        $this->deskripsi = $deskripsi;
        $this->status = 'tersedia';
    }

    public function getInfo() {
        return [
            'nama' => $this->nama,
            'harga' => $this->harga,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status
        ];
    }
}

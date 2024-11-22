<?php
// File: classes/Order.php
class Order {
    private $id;
    private $userId;
    private $items = [];
    private $status;
    private $totalHarga;
    private $waktuPesan;

    public function __construct($userId) {
        $this->userId = $userId;
        $this->status = 'pending';
        $this->waktuPesan = date('Y-m-d H:i:s');
    }

    public function addItem($menuId, $quantity) {
        $this->items[] = [
            'menuId' => $menuId,
            'quantity' => $quantity
        ];
    }

    public function calculateTotal($menuList) {
        $this->totalHarga = 0;
        foreach ($this->items as $item) {
            $menu = $menuList[$item['menuId']];
            $this->totalHarga += $menu->getInfo()['harga'] * $item['quantity'];
        }
        return $this->totalHarga;
    }
}



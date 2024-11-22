<?php
// File: classes/OrderQueue.php
class OrderQueue {
    private $queue = [];

    public function enqueue($order) {
        array_push($this->queue, $order);
    }

    public function dequeue() {
        if (!$this->isEmpty()) {
            return array_shift($this->queue);
        }
        return null;
    }

    public function isEmpty() {
        return empty($this->queue);
    }

    public function getQueue() {
        return $this->queue;
    }
}

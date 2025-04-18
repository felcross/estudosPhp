<?php
namespace Database;

interface RecordInterface
{
    public function fromArray($data);
    public function toArray();
    public function store();
    public function load($id);
    public function delete($id);
}

<?php


namespace App\Http\Interfaces;


interface RepositoryInerface
{
    public function all();

    public function crate(array $date);

    public function update(array $data ,$id );

    public function delete($id);

    public function show($id);

}

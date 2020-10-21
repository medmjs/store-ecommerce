<?php


namespace App\Repositories;
use \App\Http\Interfaces\RepositoryInerface;

class Repository implements RepositoryInerface
{
    protected $model;

    public  function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->PAGENATION_COUNT();
    }

    public function crate(array $date)
    {
        // TODO: Implement crate() method.

        return $this->model->create();
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
        $requerd = $this->find($id);
        return $requerd->update($data);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.

        return $this->model->destroy($id);
    }

    public function show($id)
    {
        // TODO: Implement show() method.
        return $this->model->findOrFail($id);
    }
}

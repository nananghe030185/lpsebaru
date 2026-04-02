<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LpseRepository;
use App\Entities\Lpse;
use App\Validators\LpseValidator;
use Exception;

/**
 * Class LpseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LpseRepositoryEloquent extends BaseRepository implements LpseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Lpse::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function status($id, $status)
    {
        try {

            $lpse = $this->model->findOrFail($id);
            $lpse->update(['state' => $status]);

            return json_encode(["resp" => $lpse]);

        } catch (Exception $e) {

            throw $e;
        }
    }

    public function scrape($id, $scrape)
    {
        try {

            $lpse = $this->model->findOrFail($id);
            $lpse->update(['state' => $scrape]);

            return json_encode(["resp" => $lpse]);

        } catch (Exception $e) {

            throw $e;
        }
    }
}

<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BlogRepositoryRepository;
use App\Entities\BlogRepository;
use App\Validators\BlogRepositoryValidator;

/**
 * Class BlogRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BlogRepositoryRepositoryEloquent extends BaseRepository implements BlogRepositoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BlogRepository::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

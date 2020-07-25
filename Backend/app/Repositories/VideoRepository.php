<?php

namespace App\Repositories;

use App\Video;

/**
 * Class VideoRepository
 * @package App\Repositories
 */
class VideoRepository extends CrudRepository
{
    /**
     * VideoRepository constructor.
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        parent::__construct($video);
    }
}

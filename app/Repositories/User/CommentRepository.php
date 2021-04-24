<?php

namespace App\Repositories\User;

use App\Models\User_comment;
use App\Repositories\EloquentRepository;
use App\Repositories\User\Contracts\CommentRepositoryContract;

class CommentRepository extends EloquentRepository implements CommentRepositoryContract
{
	protected static string $model = User_comment::class;
}
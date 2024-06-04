<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public static function saveTask(array $data)
    {
        $task = Task::find($data['user_id']) ?? new Task;
        $task->fill($data);
        $task->save();
        return $task;
    }

    public static function findByUserId($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    public static function deleteTask($taskId)
    {
        $task = self::find($taskId);
        if ($task) {
            $task->delete();
            return true;
        }
        return false;
    }

    public static function findTaskById($taskId)
    {
        return self::find($taskId);
    }
}
